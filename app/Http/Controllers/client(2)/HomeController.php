<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Sản phẩm ĐANG GIẢM GIÁ (Sale Sốc)
        $saleProducts = Product::with('category')
            ->where('status', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 2. Sản phẩm GỢI Ý (Featured/Random)
        $featuredProducts = Product::with('category')
            ->where('status', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 3. Sản phẩm MỚI NHẤT
        $latestProducts = Product::with('category')
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        // 4. Lấy danh sách Danh mục và sản phẩm của nó
        // === [SỬA LỖI TẠI ĐÂY]: Bỏ 'where('status', 1)' ===
        $categories = Category::all(); 

        foreach ($categories as $category) {
            // Lấy 4 sản phẩm mới nhất của danh mục đó (Sản phẩm thì vẫn có status)
            $products = $category->products()
                                 ->where('status', 1)
                                 ->latest()
                                 ->take(4)
                                 ->get();
            
            $category->setRelation('products', $products);
        }

        // Lọc bỏ danh mục trống
        $categories = $categories->filter(function ($category) {
            return $category->products->isNotEmpty();
        });

        return view('client.home', compact('saleProducts', 'featuredProducts', 'latestProducts', 'categories'));
    }
}