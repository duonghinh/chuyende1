<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Hiển thị trang thông tin tài khoản
     */
    public function index()
    {
        $user = Auth::user();
        return view('client.account.index', compact('user'));
    }

    /**
     * Cập nhật thông tin cá nhân (Tên, Email, SĐT, Địa chỉ)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Email phải là duy nhất, nhưng bỏ qua ID của chính user này
            ],
        ], [
            'name.required' => 'Họ tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email này đã tồn tại trên hệ thống.',
        ]);

        // Cập nhật
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success_profile', 'Cập nhật thông tin thành công!');
    }

    /**
     * Cập nhật mật khẩu
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                // Kiểm tra mật khẩu hiện tại có đúng không
                if (!Hash::check($value, $user->password)) {
                    $fail('Mật khẩu hiện tại không chính xác.');
                }
            }],
            'password' => 'required|string|min:6|confirmed', // 'confirmed' yêu cầu phải có trường 'password_confirmation'
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success_password', 'Đổi mật khẩu thành công!');
    }
}