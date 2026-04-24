<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // 1. Hiển thị form nhập email
    public function showLinkRequestForm()
    {
        return view('client.auth.forgot-password');
    }

    // 2. Xử lý gửi email reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Tạo token ngẫu nhiên
        $token = Str::random(64);

        // Lưu token vào bảng password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Gửi email (Sử dụng View mail đơn giản)
        // Lưu ý: Cần cấu hình MAIL_... trong .env trước
        Mail::send('client.emails.forget-password', ['token' => $token, 'email' => $request->email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu - Sweet Bakery');
        });

        return back()->with('success', 'Chúng tôi đã gửi link đặt lại mật khẩu vào email của bạn!');
    }

    // 3. Hiển thị form nhập mật khẩu mới (khi bấm link từ email)
    public function showResetForm($token, $email)
    {
        return view('client.auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    // 4. Xử lý đổi mật khẩu mới
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        // Kiểm tra token có khớp không
        $checkToken = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if(!$checkToken){
            return back()->withInput()->with('error', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.');
        }

        // Cập nhật mật khẩu mới
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Xóa token sau khi dùng xong
        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đổi thành công. Vui lòng đăng nhập lại.');
    }
}