<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('client.layout', function ($view) {
            
            // === [SỬA LỖI TẠI ĐÂY]: Bỏ 'where('status', 1)' ===
            // Lấy tất cả danh mục và sắp xếp theo tên
            $categories_list = Category::orderBy('name', 'asc')->get();
            
            $view->with('categories_list', $categories_list);
        });
    }
}