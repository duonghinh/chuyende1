<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $data['sale_price'] = $data['sale_price'] ?: null;
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm bánh ngọt thành công!');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $this->validateProduct($request, $id);

        if ($request->name !== $product->name) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $data['sale_price'] = $data['sale_price'] ?: null;
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm bánh ngọt thành công!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    private function validateProduct(Request $request, ?string $id = null): array
    {
        return $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $id,
            'sku' => 'required|unique:products,sku,' . $id,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'thumbnail' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'cake_type' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'serving_size' => 'nullable|string|max:255',
            'flavor' => 'nullable|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'collection' => 'nullable|string|max:255',
            'ingredients' => 'nullable|string',
            'allergens' => 'nullable|string|max:255',
            'storage_instructions' => 'nullable|string|max:255',
            'shelf_life' => 'nullable|string|max:255',
            'custom_message' => 'nullable|string|max:255',
            'lead_time_hours' => 'nullable|integer|min:0|max:168',
            'is_customizable' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ], [
            'name.required' => 'Vui lòng nhập tên bánh.',
            'name.unique' => 'Tên bánh đã tồn tại.',
            'sku.required' => 'Vui lòng nhập mã SKU.',
            'sku.unique' => 'Mã SKU đã tồn tại.',
            'price.required' => 'Vui lòng nhập giá bán.',
            'sale_price.lte' => 'Giá khuyến mãi không được lớn hơn giá niêm yết.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'brand_id.required' => 'Vui lòng chọn thương hiệu/bộ sưu tập.',
            'thumbnail.image' => 'File tải lên phải là hình ảnh.',
        ]);
    }
}
