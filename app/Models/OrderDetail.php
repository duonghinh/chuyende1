<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
    ];

    /**
     * Quan hệ: Một chi tiết đơn hàng thuộc về một đơn hàng (Order)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Quan hệ: Một chi tiết đơn hàng thuộc về một sản phẩm (Product)
     * ĐÂY LÀ HÀM BẠN ĐANG THIẾU
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}