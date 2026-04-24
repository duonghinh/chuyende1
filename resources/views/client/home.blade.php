@extends('client.layout')
@section('title', 'Trang chủ - Sweet Bakery')

@section('content')
<div id="heroCarousel" class="carousel slide mb-5 home-hero-card" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active position-relative">
            <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?q=80&w=1600&auto=format&fit=crop" class="d-block w-100 object-fit-cover hero-img" style="height: 540px;" alt="Bánh sinh nhật">
            <div class="overlay-gradient"></div>
            <div class="carousel-caption text-start" style="bottom: 16%; left: 7%; right: auto; max-width: 610px;">
                <span class="badge bg-light text-dark mb-3 px-3 py-2 rounded-pill home-hero-badge">Signature Cakes • Premium Bakery</span>
                <h1 class="display-4 fw-bold text-white mb-3">Tiệm bánh online hiện đại, dễ bán bánh theo mẫu và theo dịp</h1>
                <p class="lead text-white mb-4">Giao diện nổi bật hơn cho bánh sinh nhật, mousse, cheesecake, combo tiệc trà và đơn đặt trước có lời chúc riêng.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('client.shop') }}" class="btn btn-light btn-lg rounded-pill px-4">Khám phá menu</a>
                    <a href="{{ route('client.sale') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">Ưu đãi hôm nay</a>
                </div>
            </div>
        </div>
        <div class="carousel-item position-relative">
            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1600&auto=format&fit=crop" class="d-block w-100 object-fit-cover hero-img" style="height: 540px;" alt="Bánh mousse">
            <div class="overlay-gradient"></div>
            <div class="carousel-caption text-start" style="bottom: 16%; left: 7%; right: auto; max-width: 610px;">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill home-hero-badge">Fresh Everyday</span>
                <h1 class="display-4 fw-bold text-white mb-3">Hiển thị đúng thông tin mà khách đặt bánh thực sự quan tâm</h1>
                <p class="lead text-white mb-4">Loại bánh, khẩu phần, hương vị, thành phần, dị ứng, bảo quản và thời gian đặt trước đều hiện rõ ràng hơn.</p>
                <a href="{{ route('client.shop') }}" class="btn btn-light btn-lg rounded-pill px-4">Xem sản phẩm</a>
            </div>
        </div>
        <div class="carousel-item position-relative">
            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1600&auto=format&fit=crop" class="d-block w-100 object-fit-cover hero-img" style="height: 540px;" alt="Bánh mì ngọt">
            <div class="overlay-gradient"></div>
            <div class="carousel-caption text-start" style="bottom: 16%; left: 7%; right: auto; max-width: 610px;">
                <span class="badge bg-success mb-3 px-3 py-2 rounded-pill home-hero-badge">Order Friendly</span>
                <h1 class="display-4 fw-bold text-white mb-3">Tối ưu cho tiệm bánh nhận đơn quà tặng, sinh nhật và sự kiện nhỏ</h1>
                <p class="lead text-white mb-4">Khách nhìn là hiểu ngay bánh nào nhận viết chữ, cần đặt trước bao lâu và phù hợp cho dịp nào.</p>
                <a href="{{ route('client.shop') }}" class="btn btn-light btn-lg rounded-pill px-4">Đặt bánh ngay</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
</div>

<div class="promo-strip p-3 p-lg-4 mb-5">
    <div class="row g-3 align-items-center">
        <div class="col-lg-4"><div class="promo-item h-100"><div class="fw-bold mb-1"><i class="bi bi-truck me-2 text-primary"></i>Giao bánh nhanh trong ngày</div><div class="text-muted small">Ưu tiên đơn nội thành, có hỗ trợ gọi trước khi giao.</div></div></div>
        <div class="col-lg-4"><div class="promo-item h-100"><div class="fw-bold mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Nhận viết lời chúc trên bánh</div><div class="text-muted small">Phù hợp đơn sinh nhật, kỷ niệm, chúc mừng khai trương.</div></div></div>
        <div class="col-lg-4"><div class="promo-item h-100"><div class="fw-bold mb-1"><i class="bi bi-gift me-2 text-primary"></i>Combo tiệc trà và quà tặng</div><div class="text-muted small">Dễ tạo bộ sưu tập theo mùa, theo sự kiện và theo ngân sách.</div></div></div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="benefit-card h-100 p-4">
            <div class="benefit-icon mb-3"><i class="bi bi-cake2 fs-2"></i></div>
            <h5 class="fw-bold mb-2">Thông tin bánh rõ ràng</h5>
            <p class="text-muted mb-0">Mỗi sản phẩm có loại bánh, kích cỡ, khẩu phần, vị và thành phần nổi bật để khách chọn nhanh hơn.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="benefit-card h-100 p-4">
            <div class="benefit-icon mb-3"><i class="bi bi-stars fs-2"></i></div>
            <h5 class="fw-bold mb-2">Giao diện đúng chất bakery</h5>
            <p class="text-muted mb-0">Màu sắc, card sản phẩm, khu vực sale và trình bày chi tiết đã được làm theo phong cách tiệm bánh cao cấp hơn.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="benefit-card h-100 p-4">
            <div class="benefit-icon mb-3"><i class="bi bi-clock-history fs-2"></i></div>
            <h5 class="fw-bold mb-2">Hỗ trợ đơn đặt trước</h5>
            <p class="text-muted mb-0">Phù hợp bán bánh theo mẫu, nhận lời nhắn riêng và quản lý đơn theo dịp sử dụng chuyên nghiệp hơn.</p>
        </div>
    </div>
</div>

@if(isset($categoriesWithProducts) && $categoriesWithProducts->count())
    @foreach($categoriesWithProducts as $category)
        <section class="category-showcase mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <span class="bakery-chip mb-3"><i class="bi bi-heart-fill"></i> Bộ sưu tập nổi bật</span>
                    <h2 class="home-section-title mb-2">{{ $category->name }}</h2>
                    <p class="category-mini-note mb-0">Các mẫu bánh được trình bày theo đúng ngữ cảnh tiệm bánh, phù hợp để bán lẻ hoặc nhận đơn theo dịp.</p>
                </div>
                <a href="{{ route('client.shop', ['category' => $category->id]) }}" class="btn btn-outline-primary rounded-pill px-4">Xem tất cả</a>
            </div>
            <div class="row g-4">
                @foreach($category->products->take(8) as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="home-product-card h-100">
                            <a href="{{ route('client.product.detail', $product->slug) }}" class="home-product-media d-flex align-items-center justify-content-center p-3 position-relative text-decoration-none">
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid h-100" style="object-fit: contain;" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/400x300/F8BBD0/6D4C41?text=Sweet+Bakery" class="img-fluid h-100" style="object-fit: cover;" alt="{{ $product->name }}">
                                @endif
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">Best Seller</span>
                                @endif
                            </a>
                            <div class="p-3 p-xl-4 d-flex flex-column h-100">
                                <div class="small text-uppercase fw-bold text-muted mb-2">{{ $category->name }}</div>
                                <h6 class="home-product-title mb-2"><a href="{{ route('client.product.detail', $product->slug) }}" class="text-dark text-decoration-none fw-bold">{{ $product->name }}</a></h6>
                                <div class="small text-muted mb-1">{{ $product->display_cake_type ?: 'Bánh ngọt' }} @if($product->display_size) • {{ $product->display_size }} @endif</div>
                                <div class="small text-muted mb-3">{{ $product->display_flavor ?: 'Hương vị đặc biệt' }} @if($product->display_serving_size) • {{ $product->display_serving_size }} @endif</div>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @if($product->is_customizable)
                                        <span class="badge text-bg-light border">Viết chữ</span>
                                    @endif
                                    @if($product->lead_time_hours)
                                        <span class="badge text-bg-light border">Đặt trước {{ $product->lead_time_hours }}h</span>
                                    @endif
                                </div>
                                <div class="mt-auto">
                                    <div class="mb-3">
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <span class="fw-bold text-danger fs-5">{{ number_format($product->sale_price) }}đ</span>
                                            <small class="text-decoration-line-through text-muted ms-2">{{ number_format($product->price) }}đ</small>
                                        @else
                                            <span class="fw-bold text-dark fs-5">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary w-100 rounded-pill fw-bold"><i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
@else
    <div class="alert alert-info rounded-4 shadow-sm">Hiện chưa có sản phẩm mẫu. Bạn có thể thêm bánh trong trang quản trị để hiển thị ngoài website.</div>
@endif
@endsection
