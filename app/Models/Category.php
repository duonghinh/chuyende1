<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id'];

    // Quan hệ: Danh mục có nhiều Sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    // (Tùy chọn) Quan hệ danh mục cha-con nếu muốn hiển thị đẹp hơn
    public function children() { return $this->hasMany(Category::class, 'parent_id'); }
    public function parent() { return $this->belongsTo(Category::class, 'parent_id'); }
}
