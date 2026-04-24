@extends('client.layout')
@section('title', 'Khuyến mãi bánh ngọt - Sweet Bakery')

@section('content')
<div class="sale-banner">
    <span class="badge bg-light text-dark px-3 py-2 rounded-pill mb-3 position-relative" style="z-index:1;">Bakery Flash Sale</span>
    <h1 class="sale-title position-relative" style="z-index:1;">Ưu đãi bánh ngọt hôm nay</h1>
    <p class="sale-desc position-relative" style="z-index:1;">Giảm trực tiếp cho các mẫu bánh nổi bật, bánh sinh nhật theo mùa và những sản phẩm phù hợp đặt làm quà tặng hoặc tiệc nhỏ.</p>
</div>

@if(isset($products) && $products->count())
    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card-sale">
                    <a href="{{ route('client.product.detail', $product->slug) }}" class="card-sale-img text-decoration-none">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x300/F8BBD0/6D4C41?text=Sweet+Bakery" alt="{{ $product->name }}">
                        @endif
                        @php $discount = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                        <span class="discount-badge">-{{ $discount }}%</span>
                    </a>
                    <div class="card-sale-body">
                        <small class="text-uppercase text-muted fw-bold mb-2">{{ $product->category->name ?? 'Bánh ngọt' }}</small>
                        <a href="{{ route('client.product.detail', $product->slug) }}" class="product-name">{{ $product->name }}</a>
                        <div class="small text-muted mb-2">{{ $product->display_cake_type ?: 'Bánh ngọt' }} • {{ $product->display_flavor ?: 'Hương vị đặc biệt' }}</div>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($product->is_customizable)
                                <span class="badge text-bg-light border">Nhận viết chữ</span>
                            @endif
                            @if($product->lead_time_hours)
                                <span class="badge text-bg-light border">Đặt trước {{ $product->lead_time_hours }}h</span>
                            @endif
                        </div>
                        <div class="price-wrap">
                            <span class="sale-price">{{ number_format($product->sale_price, 0, ',', '.') }}đ</span>
                            <small class="original-price">{{ number_format($product->price, 0, ',', '.') }}đ</small>
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-buy-now">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@else
    <div class="empty-state">
        <i class="bi bi-ticket-perforated"></i>
        <div class="fw-bold mb-2">Hiện chưa có sản phẩm khuyến mãi</div>
        <div>Hãy thêm giá sale trong trang quản trị để khu vực ưu đãi hiển thị sinh động hơn.</div>
    </div>
@endif
@endsection
