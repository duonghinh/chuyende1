<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các đánh giá.
     */
    public function index()
    {
        // Lấy tất cả đánh giá, sắp xếp mới nhất lên trước
        // Tải kèm thông tin 'user' và 'product' để hiển thị tên
        $reviews = Review::with(['user', 'product'])
                        ->latest()
                        ->paginate(15); // Phân trang

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Xóa một đánh giá khỏi cơ sở dữ liệu.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá thành công.');
    }
}