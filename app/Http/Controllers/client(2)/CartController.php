<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Xem giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('client.cart.index', compact('cart', 'total'));
    }

    // Thêm sản phẩm vào giỏ
    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Kiểm tra nếu sản phẩm đã có trong giỏ -> Tăng số lượng
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Nếu chưa có -> Thêm mới
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->sale_price ?? $product->price, // Ưu tiên giá sale
                "thumbnail" => $product->thumbnail
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Cập nhật giỏ hàng (Hàm này sẽ được gọi bằng AJAX)
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            
            // Cập nhật số lượng mới
            $cart[$request->id]["quantity"] = $request->quantity;
            
            session()->put('cart', $cart);
            
            // Tính lại tổng tiền từng món và tổng bill để trả về cho JS cập nhật giao diện
            $itemTotal = $cart[$request->id]["price"] * $request->quantity;
            
            $cartTotal = 0;
            foreach($cart as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
            return response()->json([
                'success' => true,
                'itemTotal' => number_format($itemTotal), // Thành tiền của sp này
                'cartTotal' => number_format($cartTotal)  // Tổng tiền cả giỏ
            ]);
        }
    }

    // Xóa sản phẩm
    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}