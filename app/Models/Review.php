<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Các trường được phép gán hàng loạt.
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'reviewer_name',
        'rating',
        'comment',
    ];

    /**
     * Lấy người dùng đã viết đánh giá.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy sản phẩm được đánh giá.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}