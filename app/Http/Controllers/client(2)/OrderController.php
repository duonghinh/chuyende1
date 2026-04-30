<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product; // Cần import Product để trừ kho
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Để dùng transaction
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Lấy thông tin người dùng đang đăng nhập để điền sẵn vào form
        $user = auth()->user();

        return view('client.checkout.index', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'shipping_address' => 'required',
            // Thêm validation cho phương thức thanh toán nếu cần thiết
            // 'payment_method' => 'required|in:COD,BANK',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
             return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Sử dụng DB Transaction để đảm bảo toàn vẹn dữ liệu (lưu cả order và detail cùng lúc)
        try {
            DB::beginTransaction();

            // 1. Tạo đơn hàng
            $order = Order::create([
                'user_id' => auth()->id(), 
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'note' => $request->note,
                'total_amount' => $total,
                'status' => 0, // Mới đặt (Pending)
                'payment_method' => $request->payment_method ?? 'COD',
                'payment_status' => 'Unpaid' // Mặc định chưa thanh toán
            ]);

            // 2. Lưu chi tiết đơn hàng và trừ kho
            foreach ($cart as $id => $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Trừ kho (Optional: Tùy logic của bạn có muốn trừ ngay không)
                $product = Product::find($id);
                if ($product) {
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            DB::commit(); // Xác nhận lưu vào DB

            // 3. Xóa giỏ hàng sau khi đặt thành công
            session()->forget('cart');

            // === LOGIC ĐIỀU HƯỚNG ===
            if ($request->payment_method == 'BANK') {
                // Nếu chọn chuyển khoản -> Chuyển sang trang QR Code
                return redirect()->route('checkout.payment', ['orderId' => $order->id]);
            } else {
                // Nếu chọn COD -> Chuyển sang trang thành công luôn
                return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công! Mã đơn hàng #' . $order->id);
            }

        } catch (\Exception $e) {
            DB::rollBack(); // Nếu lỗi thì hủy hết các thao tác trên
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    // --- 1. Hiển thị trang QR Code (MỚI) ---
    public function showPaymentQr($orderId)
    {
        // Tìm đơn hàng của user hiện tại
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        // Nếu đơn đã thanh toán rồi hoặc bị hủy thì không cho vào trang thanh toán nữa
        // Giả sử status 2 là Đã thanh toán/Hoàn thành, 3 là Hủy (tùy quy ước của bạn)
        if ($order->payment_status == 'Paid' || $order->status == 3) {
            return redirect()->route('client.orders.show', $order->id)->with('info', 'Đơn hàng này đã được xử lý.');
        }

        return view('client.checkout.payment', compact('order'));
    }

    // --- 2. Xử lý Khách xác nhận đã chuyển khoản (MỚI) ---
    public function confirmPayment(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'transaction_code' => 'nullable|string|max:50', // Cho phép nhập mã hoặc để trống
        ]);

        // Cập nhật mã giao dịch vào đơn hàng
        // Lưu ý: Cần đảm bảo model Order có fillable 'transaction_code'
        $order->transaction_code = $request->transaction_code;
        
        // Có thể đổi trạng thái đơn hàng sang "Chờ duyệt" (ví dụ status = 1) nếu muốn
        // $order->status = 1; 
        
        $order->save();

        return redirect()->route('checkout.success')->with('success', 'Đã gửi xác nhận thanh toán! Chúng tôi sẽ kiểm tra và giao hàng sớm nhất.');
    }

    // Xem lịch sử đơn hàng
    public function history()
    {
        // Lấy danh sách đơn hàng của user đang đăng nhập, sắp xếp mới nhất lên đầu
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        return view('client.orders.index', compact('orders'));
    }

    // Xem chi tiết một đơn hàng
    public function detail($id)
    {
        // Tìm đơn hàng theo ID và đảm bảo nó thuộc về user đang đăng nhập
        $order = Order::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->with('details') // Eager load details
                    ->firstOrFail();

        return view('client.orders.show', compact('order'));
    }

    public function success()
    {
        return view('client.checkout.success');
    }
}