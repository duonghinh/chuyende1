@extends('admin.layout')
@section('title', 'Danh sách sản phẩm bánh ngọt')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Danh sách sản phẩm bánh ngọt</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">+ Thêm mới</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên bánh</th>
                <th>Giá</th>
                <th>Thông tin nhanh</th>
                <th>Danh mục</th>
                <th>Tồn</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" width="56" class="rounded" alt="{{ $product->name }}">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $product->name }}</strong><br>
                    <small class="text-muted">SKU: {{ $product->sku }}</small>
                </td>
                <td>
                    @if($product->sale_price)
                        <del>{{ number_format($product->price) }}đ</del><br>
                        <strong class="text-danger">{{ number_format($product->sale_price) }}đ</strong>
                    @else
                        {{ number_format($product->price) }}đ
                    @endif
                </td>
                <td>
                    <div><small><strong>Loại:</strong> {{ $product->display_cake_type ?: '---' }}</small></div>
                    <div><small><strong>Kích cỡ:</strong> {{ $product->display_size ?: '---' }}</small></div>
                    <div><small><strong>Vị:</strong> {{ $product->display_flavor ?: '---' }}</small></div>
                </td>
                <td>
                    {{ $product->category->name ?? 'N/A' }}<br>
                    <small class="text-muted">{{ $product->brand->name ?? 'N/A' }}</small>
                </td>
                <td>{{ $product->quantity }}</td>
                <td>
                    @if($product->status == 1)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-secondary">Ẩn</span>
                    @endif
                    @if($product->is_featured)
                        <span class="badge bg-warning text-dark">Nổi bật</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
