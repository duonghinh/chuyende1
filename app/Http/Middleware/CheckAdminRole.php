<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // 1. Kiểm tra xem đã đăng nhập chưa
    if (auth()->check()) {
        // 2. Kiểm tra xem có phải là Admin (role = 1) không
        if (auth()->user()->role == 1) {
            // Đúng là Admin -> Cho phép đi tiếp
            return $next($request);
        } else {
            // Đã đăng nhập nhưng là khách hàng -> Đuổi về trang chủ
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào trang quản trị!');
        }
    }

    // Chưa đăng nhập -> Đuổi về trang đăng nhập
    return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
}
}
