<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>@yield('title', 'Sweet Bakery')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @yield('css')
    @vite(['resources/css/index.css', 'resources/js/app.js'])
</head>
<body>
    <div class="banner-ad-float banner-left">
        <a href="{{ route('client.sale') }}" title="Khuyến mãi bánh ngọt">
            <img src="https://images.unsplash.com/photo-1486427944299-d1955d23e34d?q=80&w=800&auto=format&fit=crop" 
                 alt="Khuyến mãi bánh ngọt"
                 onerror="this.src='https://via.placeholder.com/160x450/f8bbd0/6d4c41?text=BAKERY+SALE';">
        </a>
    </div>

    <div class="banner-ad-float banner-right">
        <a href="{{ route('client.shop') }}" title="Bánh sinh nhật">
            <img src="https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?q=80&w=800&auto=format&fit=crop" 
                 alt="Bánh sinh nhật"
                 onerror="this.src='https://via.placeholder.com/160x450/ffe0b2/6d4c41?text=CAKE';">
        </a>
    </div>

    <header class="header-wrapper fixed-top shadow-sm">
        <div class="top-header bg-white py-2 border-bottom">
            <div class="container d-flex align-items-center justify-content-between gap-3">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Sweet Bakery Logo" style="height: 50px; width: auto; object-fit: contain;">            
                    <span class="fw-bold text-primary ms-2 fs-3">Sweet Bakery</span>
                </a>

                <div class="search-bar-container flex-grow-1 mx-lg-5 mx-3 d-none d-lg-block">
                    <form action="{{ route('client.shop') }}" method="GET">
                        <div class="input-group shadow-sm rounded-pill overflow-hidden">
                            <input type="text" class="form-control border-0 bg-light px-4 py-2" placeholder="Tìm bánh ngọt, bánh kem, combo tiệc..." name="search">
                            <button class="btn btn-primary px-4 fw-bold border-0" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="header-actions d-flex align-items-center gap-3 gap-xl-4">
                    <div class="d-none d-xl-flex align-items-center gap-2 text-dark text-decoration-none">
                        <div class="icon-box bg-primary bg-opacity-10 rounded-circle p-2 text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-telephone fs-5"></i>
                        </div>
                        <div class="d-flex flex-column lh-1">
                            <span class="small text-muted" style="font-size: 0.8rem;">Đặt bánh nhanh</span>
                            <span class="fw-bold">1900.5678</span>
                        </div>
                    </div>

                    <a href="{{ route('cart.index') }}" class="text-dark text-decoration-none border-0 p-0">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box bg-primary bg-opacity-10 rounded-circle p-2 text-primary position-relative d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-cart3 fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light shadow-sm">
                                    {{ count((array) session('cart')) }}
                                </span>
                            </div>
                            <div class="d-none d-md-block d-flex flex-column lh-1 text-start">
                                <span class="small text-muted" style="font-size: 0.8rem;">Giỏ hàng</span>
                                <span class="fw-bold">Của bạn</span>
                            </div>
                        </div>
                    </a>

                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none text-dark gap-2" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="User" width="40" height="40" class="rounded-circle border shadow-sm">
                                <div class="d-none d-md-flex flex-column lh-1">
                                    <span class="small text-muted" style="font-size: 0.8rem;">Xin chào,</span>
                                    <span class="fw-bold text-truncate" style="max-width: 100px;">{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-3 overflow-hidden">
                                @if(Auth::user()->role == 1)
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Trang quản trị</a></li>
                                    <li><hr class="dropdown-divider my-0"></li>
                                @endif
                                <li><a class="dropdown-item py-2" href="{{ route('client.orders.index') }}"><i class="bi bi-bag-check me-2"></i> Đơn hàng</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('client.account.index') }}"><i class="bi bi-person-gear me-2"></i> Tài khoản</a></li>
                                <li><hr class="dropdown-divider my-0"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                             <div class="icon-box bg-primary bg-opacity-10 rounded-circle p-2 text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-person fs-5"></i>
                            </div>
                            <div class="d-none d-md-flex flex-column lh-1">
                                <span class="small text-muted" style="font-size: 0.8rem;">Đăng nhập</span>
                                <span class="fw-bold">Tài khoản</span>
                            </div>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="main-menu bg-primary shadow-sm">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-dark p-0">
                    <button class="navbar-toggler my-2 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="d-lg-none w-100 px-2 pb-2">
                        <form action="{{ route('client.shop') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-start-pill" placeholder="Tìm bánh ngọt..." name="search">
                                <button class="btn btn-light rounded-end-pill" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="collapse navbar-collapse" id="mainNav">
                        <ul class="navbar-nav me-auto align-items-center">
                            <li class="nav-item dropdown me-2">
                                <a class="nav-link dropdown-toggle fw-bold text-white bg-black bg-opacity-25 px-4 py-3" href="#" data-bs-toggle="dropdown" style="min-width: 250px;">
                                    <i class="bi bi-list me-2 fs-5 vertical-align-middle"></i> DANH MỤC BÁNH NGỌT
                                </a>
                                <ul class="dropdown-menu shadow-lg border-0 mt-0 rounded-0 rounded-bottom-3 p-2 w-100">
                                    @forelse(($categories_list ?? []) as $cat)
                                        <li>
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('client.shop', ['category' => $cat->id]) }}">
                                                <i class="fas fa-cookie-bite me-3 text-secondary" style="width: 20px;"></i>{{ $cat->name }}
                                            </a>
                                        </li>
                                    @empty
                                        <li><span class="dropdown-item text-muted">Chưa có danh mục</span></li>
                                    @endforelse
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link px-3 py-3 text-white fw-semibold text-uppercase" href="{{ route('home') }}">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 py-3 text-white fw-semibold text-uppercase" href="{{ route('client.shop') }}">Cửa hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 py-3 text-white fw-semibold text-uppercase" href="{{ route('client.sale') }}">Khuyến mãi</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle px-3 py-3 text-white fw-semibold text-uppercase" href="#" data-bs-toggle="dropdown">Hỗ trợ</a>
                                <ul class="dropdown-menu shadow border-0 mt-0 rounded-3 p-2">
                                    <li><a class="dropdown-item py-2 rounded-2" href="{{ route('client.shopping_guide') }}">Hướng dẫn đặt bánh</a></li>
                                    <li><a class="dropdown-item py-2 rounded-2" href="{{ route('client.warranty_policy') }}">Chính sách đổi trả</a></li>
                                    <li><a class="dropdown-item py-2 rounded-2" href="{{ route('client.payment_methods') }}">Phương thức thanh toán</a></li>
                                    <li><a class="dropdown-item py-2 rounded-2" href="{{ route('client.shipping_policy') }}">Vận chuyển & giao nhận</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2 rounded-2" href="{{ route('client.orders.index') }}">Tra cứu đơn hàng</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 py-3 text-white fw-semibold text-uppercase" href="#footer-contact">Liên hệ</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main style="margin-top: 155px; min-height: 600px;">
        <div class="container pb-5"> 
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <div class="chat-widget">
        <button class="chat-button" onclick="toggleChat()" title="Chat tư vấn bánh"><i class="bi bi-chat-dots-fill"></i></button>
        <div class="chat-window" id="chatWindow">
            <div class="chat-header">
                <span><i class="bi bi-robot me-2"></i> Trợ lý Sweet Bakery</span>
                <button type="button" class="btn-close btn-close-white" onclick="toggleChat()"></button>
            </div>
            <div class="chat-body" id="chatBody">
                <div class="message bot">Xin chào! Mình có thể tư vấn bánh sinh nhật, bánh mì ngọt, combo tiệc trà và hỗ trợ đặt hàng cho bạn.</div>
            </div>
            <div class="typing-indicator ps-3" id="typingIndicator">
                <div class="spinner-grow spinner-grow-sm text-secondary" role="status"></div>
                <small class="ms-1">AI đang nhập...</small>
            </div>
            <div class="chat-footer">
                <input type="text" id="chatInput" class="form-control rounded-pill" placeholder="Nhập câu hỏi...">
                <button class="btn btn-primary rounded-circle" id="btnChatSend" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-send-fill"></i></button>
            </div>
        </div>
    </div>

    <footer class="footer-custom py-5" id="footer-contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white fw-bold mb-3">Sweet Bakery</h4>
                    <p class="mb-3">Tiệm bánh ngọt hiện đại chuyên bánh sinh nhật, bánh mousse, tiramisu, cookie và combo tiệc trà.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>THÔNG TIN LIÊN HỆ</h5>
                    <ul class="list-unstyled footer-links">
                        <li><i class="bi bi-geo-alt-fill"></i> 123 Nguyễn Trãi, Quận 1, TP.HCM</li>
                        <li><i class="bi bi-telephone-fill"></i> Hotline: 1900 5678</li>
                        <li><i class="bi bi-envelope-fill"></i> Email: hello@sweetbakery.vn</li>
                        <li><i class="bi bi-clock-fill"></i> Giờ mở cửa: 7:00 - 22:00</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>HỖ TRỢ KHÁCH HÀNG</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('client.shopping_guide') }}">Hướng dẫn đặt bánh online</a></li>
                        <li><a href="{{ route('client.warranty_policy') }}">Chính sách đổi trả</a></li>
                        <li><a href="{{ route('client.payment_methods') }}">Phương thức thanh toán</a></li>
                        <li><a href="{{ route('client.shipping_policy') }}">Vận chuyển & giao nhận</a></li>
                        <li><a href="{{ route('client.orders.index') }}">Tra cứu đơn hàng</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>ĐĂNG KÝ NHẬN TIN</h5>
                    <div class="input-group mb-3">
                        <input type="email" id="newsletterEmail" class="form-control" placeholder="Email của bạn">
                        <button class="btn btn-primary" type="button" onclick="subscribeNewsletter()"><i class="bi bi-send-fill"></i></button>
                    </div>
                    <small id="newsletterMessage" class="d-block mt-2"></small>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-bottom text-center text-secondary py-3">
        <p class="mb-0">&copy; {{ date('Y') }} Sweet Bakery. Website bán bánh ngọt.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.appConfig = {
            routes: {
                chat: '{{ route("chat.send") }}',
                newsletter: '{{ route("newsletter.subscribe") }}'
            }
        };
    </script>
    <script src="{{ asset('js/client-newsletter.js') }}"></script>
    <script src="{{ asset('js/client-chat.js') }}"></script>
    <script src="{{ asset('js/client-banner.js') }}"></script>
    @yield('js')
</body>
</html>
