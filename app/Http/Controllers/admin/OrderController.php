<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng, mới nhất lên đầu
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['details.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Hàm xử lý khi Admin bấm nút cập nhật trạng thái
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // 1. Xử lý nút "Xác nhận đã thanh toán"
        if ($request->has('confirm_payment')) {
            $order->payment_status = 'Paid';
            // Thường khi đã trả tiền thì đơn hàng cũng chuyển sang đang xử lý luôn
            if ($order->status == 0) { // Nếu đang là Pending
                $order->status = 1; // Chuyển sang Processing
            }
            $order->save();
            return redirect()->back()->with('success', 'Đã xác nhận thanh toán thành công!');
        }

        // 2. Xử lý cập nhật trạng thái giao hàng (Ví dụ: Đang giao, Hoàn thành, Hủy)
        if ($request->has('status')) {
            $order->status = $request->status;
            $order->save();
            return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng.');
        }

        return redirect()->back()->with('error', 'Không có hành động nào được thực hiện.');
    }
}