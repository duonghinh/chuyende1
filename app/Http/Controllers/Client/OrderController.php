<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
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

        $user = auth()->user();

        return view('client.checkout.index', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        // 1. CHỈNH SỬA VALIDATION: Địa chỉ chỉ bắt buộc khi chọn delivery
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'shipping_method' => 'required|in:delivery,pickup',
            'shipping_address' => $request->shipping_method == 'delivery' ? 'required' : 'nullable',
        ], [
            'customer_name.required' => 'Vui lòng nhập tên người nhận.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ để tiệm giao bánh.',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
             return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            DB::beginTransaction();

            // 2. XỬ LÝ ĐỊA CHỈ VÀ GHI CHÚ
            $address = $request->shipping_address;
            $note = $request->note;

            if ($request->shipping_method == 'pickup') {
                $address = "NHẬN TẠI CỬA HÀNG";
                $note = "[KHÁCH TỰ ĐẾN LẤY] " . $note;
            }

            // 3. Tạo đơn hàng
            $order = Order::create([
                'user_id' => auth()->id(), 
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'shipping_address' => $address,
                'note' => $note,
                'total_amount' => $total,
                'status' => 0, 
                'payment_method' => $request->payment_method ?? 'COD',
                'payment_status' => 'Unpaid'
            ]);

            // 4. Lưu chi tiết đơn hàng và trừ kho
            foreach ($cart as $id => $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $product = Product::find($id);
                if ($product) {
                    $product->decrement('quantity', $item['quantity']);
                }
            }

            DB::commit();

            session()->forget('cart');

            if ($request->payment_method == 'BANK') {
                return redirect()->route('checkout.payment', ['orderId' => $order->id]);
            } else {
                return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công! Mã đơn hàng #' . $order->id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function showPaymentQr($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        if ($order->payment_status == 'Paid' || $order->status == 3) {
            return redirect()->route('client.orders.show', $order->id)->with('info', 'Đơn hàng này đã được xử lý.');
        }
        return view('client.checkout.payment', compact('order'));
    }

    public function confirmPayment(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        $request->validate(['transaction_code' => 'nullable|string|max:50']);
        $order->transaction_code = $request->transaction_code;
        $order->save();
        return redirect()->route('checkout.success')->with('success', 'Đã gửi xác nhận thanh toán!');
    }

    public function history()
    {
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        return view('client.orders.index', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->with('details')
                    ->firstOrFail();
        return view('client.orders.show', compact('order'));
    }

    public function success()
    {
        return view('client.checkout.success');
    }
}