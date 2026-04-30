<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; 
use App\Models\Brand; 
use App\Models\Review;
use Illuminate\Support\Facades\Auth;   
use Illuminate\Http\Request; 

class ProductController extends Controller
{
    /**
     * Hiển thị trang Cửa hàng (Shop) + Lọc sản phẩm
     */
    public function index(Request $request)
    {
        // 1. Khởi tạo query lấy sản phẩm đang hiển thị
        $query = Product::where('status', 1);

        // 2. Xử lý tìm kiếm (FIX LỖI: Nhận cả 'keyword' từ bộ lọc và 'search' từ header)
        // Nếu có 'keyword' thì lấy, không thì lấy 'search'
        $searchKey = $request->input('keyword') ?? $request->input('search');
        
        if ($searchKey) {
            $query->where('name', 'like', '%' . $searchKey . '%');
        }

        // 3. Xử lý lọc theo danh mục
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // 4. Xử lý lọc theo thương hiệu
        if ($request->filled('brand') && $request->brand != 'all') {
            $query->where('brand_id', $request->brand);
        }

        // 5. Xử lý lọc theo giá
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // 6. Sắp xếp
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Mặc định mới nhất
        }

        // 7. Lấy dữ liệu và phân trang
        $products = $query->with(['category'])->paginate(12)->withQueryString();

        // Lấy danh sách cho sidebar lọc
        $categories = Category::all();
        $brands = Brand::all();

        // TRẢ VỀ VIEW
        // Lưu ý: Nếu file view của bạn là 'resources/views/client/shop.blade.php' 
        // thì sửa dòng dưới thành: return view('client.shop', ...)
        // Ở đây mình giữ nguyên theo code bạn gửi là 'client.products.index'
        if (view()->exists('client.products.index')) {
            return view('client.products.index', compact('products', 'categories', 'brands'));
        } else {
            return view('client.shop', compact('products', 'categories', 'brands'));
        }
    }


    /**
     * Hiển thị trang Chi tiết sản phẩm
     */
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'category', 
                'brand', 
                'reviews' => function ($query) { 
                    $query->latest(); 
                }, 
                'reviews.user' 
            ])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(4)
            ->get();

        return view('client.products.detail', compact('product', 'relatedProducts'));
    }

    /**
     * Lưu đánh giá sản phẩm
     */
    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $userId = Auth::id(); 

        if (!$userId) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để đánh giá.');
        }

        Review::create([
            'product_id' => $productId,
            'user_id' => $userId,
            'reviewer_name' => $request->reviewer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }

    public function sale()
    {
        $products = Product::where('status', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price') 
            ->orderBy('sale_price', 'asc') 
            ->paginate(12); 

        return view('client.sale', compact('products'));
    }
}