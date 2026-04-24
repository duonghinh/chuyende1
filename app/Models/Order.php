<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'note',
        'total_amount',
        'status',
        // Các cột thanh toán mới thêm
        'payment_method',
        'payment_status',
        'transaction_code',
    ];

    /**
     * Quan hệ: Một đơn hàng có nhiều chi tiết đơn hàng (sản phẩm)
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    
    /**
     * Quan hệ: Một đơn hàng thuộc về một người dùng (User)
     * ĐÂY LÀ HÀM BẠN ĐANG THIẾU
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}