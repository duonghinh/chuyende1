@extends('client.layout')
@section('title', 'Cửa hàng bánh ngọt')

@section('content')
<div class="shop-hero mb-4">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="bakery-chip mb-3"><i class="bi bi-shop"></i> Sweet Bakery Collection</span>
            <h1 class="fw-bold mb-3">Chọn bánh theo vị, kích cỡ, dịp dùng và ngân sách</h1>
            <p class="text-muted mb-0">Trang cửa hàng đã được làm theo kiểu tiệm bánh: dễ lọc bánh sinh nhật, bánh mousse, bánh tiệc trà và sản phẩm nhận viết chữ theo yêu cầu.</p>
        </div>
        <div class="col-lg-4">
            <div class="bakery-soft-card p-4 h-100">
                <div class="fw-bold mb-2">Gợi ý đặt bánh nhanh</div>
                <ul class="text-muted small mb-0 ps-3">
                    <li>Chọn bánh theo dịp sinh nhật, kỷ niệm, khai trương.</li>
                    <li>Lọc theo giá để tạo combo dễ bán hơn.</li>
                    <li>Ưu tiên sản phẩm có nhận viết chữ nếu là quà tặng.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card filter-card border-0">
            <div class="card-header fw-bold">BỘ LỌC BÁNH NGỌT</div>
            <div class="card-body p-4">
                <form action="{{ route('client.shop') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Từ khóa</label>
                        <input type="text" class="form-control rounded-pill" name="keyword" value="{{ request('keyword') }}" placeholder="Tên bánh, vị bánh...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Danh mục</label>
                        <select class="form-select rounded-pill" name="category">
                            <option value="all">Tất cả danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Thương hiệu / bộ sưu tập</label>
                        <select class="form-select rounded-pill" name="brand">
                            <option value="all">Tất cả thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Khoảng giá</label>
                        <div class="d-flex gap-2">
                            <input type="number" class="form-control rounded-pill" name="price_min" value="{{ request('price_min') }}" placeholder="Từ">
                            <input type="number" class="form-control rounded-pill" name="price_max" value="{{ request('price_max') }}" placeholder="Đến">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Lọc sản phẩm</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="shop-summary-bar d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
            <p class="m-0 text-muted">Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} trên {{ $products->total() }} sản phẩm</p>
            <form id="sortForm" action="{{ route('client.shop') }}" method="GET" class="d-flex align-items-center gap-2">
                @foreach(request()->except(['sort', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <label class="text-muted small text-nowrap">Sắp xếp theo:</label>
                <select class="form-select form-select-sm rounded-pill" name="sort" onchange="document.getElementById('sortForm').submit()">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                </select>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @forelse($products as $product)
            <div class="col">
                <div class="card h-100 card-product overflow-hidden">
                    <div class="position-relative text-center p-3" style="height: 235px;">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid h-100" style="object-fit: contain;" alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">No Image</div>
                        @endif
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">Nổi bật</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column p-3 p-xl-4">
                        <small class="text-uppercase text-muted fw-bold mb-2">{{ $product->category->name ?? '' }}</small>
                        <h6 class="card-title mb-2">
                            <a href="{{ route('client.product.detail', $product->slug) }}" class="text-decoration-none text-dark stretched-link">{{ $product->name }}</a>
                        </h6>
                        <div class="small text-muted mb-2">{{ $product->display_cake_type ?: 'Bánh ngọt' }} • {{ $product->display_flavor ?: 'Vị đặc biệt' }}</div>
                        <div class="small text-muted mb-3">{{ $product->display_size ?: 'Theo mẫu' }} @if($product->display_serving_size) • {{ $product->display_serving_size }} @endif</div>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($product->is_customizable)
                                <small class="badge text-bg-light border">Viết chữ</small>
                            @endif
                            @if($product->lead_time_hours)
                                <small class="badge text-bg-light border">Đặt trước {{ $product->lead_time_hours }}h</small>
                            @endif
                        </div>
                        <div class="mt-auto d-flex justify-content-between align-items-end gap-2">
                            <div>
                                <span class="fw-bold text-primary">{{ number_format($product->sale_price ?: $product->price, 0, ',', '.') }}đ</span>
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <div><small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}đ</small></div>
                                @endif
                            </div>
                            <a href="{{ route('client.product.detail', $product->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 position-relative z-2">Xem</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center rounded-4">Không tìm thấy sản phẩm nào phù hợp.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>
@endsection
