<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Lấy danh sách user có role = 0 (Khách hàng)
        $customers = User::where('role', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    // Có thể thêm hàm xóa khách hàng nếu muốn
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        // Chỉ cho phép xóa nếu không phải là admin
        if ($customer->role == 0) {
             $customer->delete();
             return redirect()->back()->with('success', 'Đã xóa khách hàng thành công!');
        }
        return redirect()->back()->with('error', 'Không thể xóa tài khoản này!');
    }
    // Xem chi tiết khách hàng và lịch sử đơn hàng
    public function show($id)
    {
        // Lấy thông tin khách hàng kèm theo danh sách đơn hàng của họ (sắp xếp đơn mới nhất lên trước)
        $customer = User::with(['orders' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }
}