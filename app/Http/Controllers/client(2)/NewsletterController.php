<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Email không hợp lệ.']);
        }

        try {
            // Gửi email
            Mail::to($request->email)->send(new NewsletterEmail());

            return response()->json([
                'success' => true, 
                'message' => 'Đã gửi thông tin ưu đãi vào email của bạn!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Lỗi gửi mail (Kiểm tra .env). Chi tiết: ' . $e->getMessage()
            ]);
        }
    }
}