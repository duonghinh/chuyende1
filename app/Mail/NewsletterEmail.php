<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $products;

    public function __construct()
    {
        // Lấy 3 sản phẩm giảm giá tốt nhất để gửi
        $this->products = Product::where('status', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();
    }

    public function build()
    {
        return $this->subject('🔥 Sweet Bakery: Ưu đãi bánh ngọt nổi bật tuần này!')
                    ->view('emails.newsletter');
    }
}