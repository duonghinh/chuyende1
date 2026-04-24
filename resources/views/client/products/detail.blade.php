@extends('client.layout')
@section('title', $product->name . ' - Sweet Bakery')

@section('content')
<nav aria-label="breadcrumb" class="my-4">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('client.shop', ['category' => $product->category_id]) }}" class="text-decoration-none text-muted">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row mb-5 g-4 align-items-start">
    <div class="col-lg-5">
        <div class="product-image-box position-relative">
            @if($product->thumbnail)
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x600/F8BBD0/6D4C41?text=Sweet+Bakery" alt="No Image">
            @endif
            @if($product->sale_price && $product->sale_price < $product->price)
                @php $discount = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                <span class="position-absolute top-0 start-0 m-3 badge bg-danger fs-6 px-3 py-2 rounded-pill shadow">-{{ $discount }}%</span>
            @endif
            @if($product->is_featured)
                <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill shadow">Nổi bật</span>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="badge text-bg-light border">{{ $product->category->name }}</span>
            @if($product->occasion)<span class="badge text-bg-light border">{{ $product->occasion }}</span>@endif
            @if($product->collection)<span class="badge text-bg-light border">{{ $product->collection }}</span>@endif
            @if($product->is_customizable)<span class="badge text-bg-primary">Nhận viết chữ</span>@endif
        </div>
        <h1 class="product-title fw-bold">{{ $product->name }}</h1>
        <div class="d-flex align-items-center flex-wrap gap-3 mb-4 text-muted small">
            <span><i class="bi bi-tag-fill text-primary"></i> Bộ sưu tập: <strong>{{ $product->brand->name }}</strong></span>
            <span class="border-start ps-3">Mã bánh: <strong>{{ $product->sku }}</strong></span>
            <span class="border-start ps-3">Tình trạng: <span class="{{ $product->quantity > 0 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">{{ $product->quantity > 0 ? 'Có thể đặt' : 'Tạm hết' }}</span></span>
        </div>

        <div class="price-box">
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="current-price">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                <span class="old-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @else
                <span class="current-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @endif
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="bakery-soft-card p-3 h-100"><div class="fw-bold mb-1">Khẩu phần</div><div class="text-muted small">{{ $product->display_serving_size ?: 'Theo cỡ bánh' }}</div></div></div>
            <div class="col-md-4"><div class="bakery-soft-card p-3 h-100"><div class="fw-bold mb-1">Đặt trước</div><div class="text-muted small">{{ $product->lead_time_hours ? $product->lead_time_hours . ' giờ' : 'Linh hoạt' }}</div></div></div>
            <div class="col-md-4"><div class="bakery-soft-card p-3 h-100"><div class="fw-bold mb-1">Bảo quản</div><div class="text-muted small">{{ $product->display_storage_instructions ?: 'Theo hướng dẫn của tiệm' }}</div></div></div>
        </div>

        <div class="specs-container mb-4">
            <h6 class="fw-bold mb-3 text-uppercase text-secondary"><i class="bi bi-info-circle me-2"></i>Thông tin chiếc bánh</h6>
            <div class="specs-grid">
                @if($product->display_cake_type)
                    <div class="spec-item"><i class="bi bi-cake2"></i><div><span class="spec-label">Loại bánh</span>{{ $product->display_cake_type }}</div></div>
                @endif
                @if($product->display_size)
                    <div class="spec-item"><i class="bi bi-rulers"></i><div><span class="spec-label">Kích cỡ</span>{{ $product->display_size }}</div></div>
                @endif
                @if($product->display_serving_size)
                    <div class="spec-item"><i class="bi bi-people"></i><div><span class="spec-label">Khẩu phần</span>{{ $product->display_serving_size }}</div></div>
                @endif
                @if($product->display_flavor)
                    <div class="spec-item"><i class="bi bi-droplet-half"></i><div><span class="spec-label">Hương vị</span>{{ $product->display_flavor }}</div></div>
                @endif
                @if($product->ingredients)
                    <div class="spec-item"><i class="bi bi-list-check"></i><div><span class="spec-label">Thành phần</span>{{ $product->ingredients }}</div></div>
                @endif
                @if($product->allergens)
                    <div class="spec-item"><i class="bi bi-exclamation-triangle"></i><div><span class="spec-label">Lưu ý dị ứng</span>{{ $product->allergens }}</div></div>
                @endif
                @if($product->display_storage_instructions)
                    <div class="spec-item"><i class="bi bi-snow"></i><div><span class="spec-label">Bảo quản</span>{{ $product->display_storage_instructions }}</div></div>
                @endif
                @if($product->display_shelf_life)
                    <div class="spec-item"><i class="bi bi-calendar-heart"></i><div><span class="spec-label">Hạn dùng</span>{{ $product->display_shelf_life }}</div></div>
                @endif
            </div>
        </div>

        <div class="bakery-note-box p-4 mb-4">
            <div class="fw-bold mb-2">Lưu ý khi đặt bánh</div>
            <ul class="mb-0 ps-3 text-muted">
                <li>Nên đặt trước ít nhất {{ $product->lead_time_hours ?? 2 }} giờ để tiệm chuẩn bị tốt nhất.</li>
                @if($product->is_customizable)
                    <li>Tiệm hỗ trợ viết chữ/trang trí cơ bản. Bạn có thể ghi chú ở bước thanh toán.</li>
                @endif
                @if($product->custom_message)
                    <li>Gợi ý lời nhắn: {{ $product->custom_message }}</li>
                @endif
                <li>Sản phẩm ngon nhất khi dùng đúng hướng dẫn bảo quản của tiệm.</li>
            </ul>
        </div>

        <div class="action-buttons d-flex gap-3 flex-wrap">
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                @csrf
                <button type="submit" class="btn btn-outline-primary w-100 btn-lg" {{ $product->quantity > 0 ? '' : 'disabled' }}>
                    <i class="bi bi-cart-plus me-2"></i> THÊM VÀO GIỎ
                </button>
            </form>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                @csrf
                <button type="submit" class="btn btn-primary w-100 btn-lg text-white" {{ $product->quantity > 0 ? '' : 'disabled' }}>
                    ĐẶT NGAY
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-lg-8">
        <h3 class="section-title">Mô tả chi tiết</h3>
        <div class="content-box mb-5">{!! nl2br(e($product->description)) !!}</div>

        <h3 class="section-title" id="reviews">Đánh giá khách hàng</h3>
        <div class="content-box">
            <div class="review-form-card p-4 mb-4">
                <h5 class="fw-bold mb-3 text-primary">Viết đánh giá của bạn</h5>
                <form id="review-form" action="{{ route('reviews.store', ['productId' => $product->id]) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tên hiển thị</label>
                            <input type="text" name="reviewer_name" value="{{ auth()->user()->name ?? old('reviewer_name') }}" class="form-control rounded-4" placeholder="Nhập tên của bạn" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Đánh giá sao</label>
                            <select name="rating" class="form-select rounded-4" required>
                                <option value="5">★★★★★ (Tuyệt vời)</option>
                                <option value="4">★★★★☆ (Hài lòng)</option>
                                <option value="3">★★★☆☆ (Bình thường)</option>
                                <option value="2">★★☆☆☆ (Tệ)</option>
                                <option value="1">★☆☆☆☆ (Rất tệ)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nội dung đánh giá</label>
                            <textarea name="comment" rows="3" class="form-control rounded-4" placeholder="Chia sẻ cảm nhận của bạn về chiếc bánh này..." required>{{ old('comment') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">Gửi đánh giá</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="review-list">
                @forelse ($product->reviews as $review)
                    <div class="review-item mb-3">
                        <div class="d-flex">
                            <div class="avatar-circle me-3">{{ strtoupper(substr($review->reviewer_name ?? $review->user->name, 0, 1)) }}</div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h6 class="fw-bold mb-0">{{ $review->reviewer_name ?? $review->user->name }}</h6>
                                    <small class="text-muted fst-italic">- {{ $review->created_at->format('d/m/Y') }}</small>
                                </div>
                                <div class="text-warning small mb-2">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                                <p class="mb-0 text-secondary">{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-chat-square-text fs-1 d-block mb-2 opacity-50"></i>
                        Chưa có đánh giá nào. Hãy là người đầu tiên!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
        <h3 class="section-title">Sản phẩm liên quan</h3>
        <div class="content-box p-0 bg-transparent shadow-none border-0">
            @if(isset($relatedProducts) && count($relatedProducts) > 0)
                <div class="row row-cols-1 g-3">
                    @foreach($relatedProducts as $related)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-row align-items-center p-2 bg-white">
                                <a href="{{ route('client.product.detail', $related->slug) }}" class="d-block" style="width: 90px; height: 90px;">
                                    @if($related->thumbnail)
                                        <img src="{{ asset('storage/' . $related->thumbnail) }}" class="w-100 h-100 rounded-3" style="object-fit: cover;" alt="{{ $related->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/90x90/F8BBD0/6D4C41?text=Cake" class="w-100 h-100 rounded-3" alt="{{ $related->name }}">
                                    @endif
                                </a>
                                <div class="ps-3 flex-grow-1">
                                    <a href="{{ route('client.product.detail', $related->slug) }}" class="text-dark text-decoration-none fw-semibold d-block mb-1">{{ $related->name }}</a>
                                    <small class="text-muted d-block mb-2">{{ $related->display_flavor ?: ($related->category->name ?? 'Bánh ngọt') }}</small>
                                    <strong class="text-primary">{{ number_format($related->sale_price ?: $related->price, 0, ',', '.') }}đ</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-light rounded-4">Chưa có sản phẩm liên quan.</div>
            @endif
        </div>
    </div>
</div>
@endsection
