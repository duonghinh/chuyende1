@extends('client.layout')
@section('title', 'Đăng nhập & Đăng ký')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth-style.css') }}">
<link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="wrapper {{ session('show_register') ? 'active' : '' }}">
        <span class="rotate-bg"></span>
        <span class="rotate-bg2"></span>

        {{-- FORM ĐĂNG NHẬP --}}
        <div class="form-box login">
            <h2 class="title animation" style="--i:0; --j:21">Đăng nhập</h2>

            @if(session('error'))
                <div class="alert alert-danger text-center mb-2 animation" style="--i:1; --j:22">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-box animation" style="--i:1; --j:22">
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder=" ">
                    <label>Email</label>
                    <i class='bx bxs-envelope'></i>
                </div>

                <div class="input-box animation" style="--i:2; --j:23">
                    <input type="password" name="password" required placeholder=" ">
                    <label>Mật khẩu</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="animation text-end forgot-pass-box" style="--i:2.5; --j:23.5;">
                    <a href="{{ route('password.request') }}" class="forgot-pass-link">
                        Quên mật khẩu?
                    </a>
                </div>
                <button type="submit" class="btn btn-auth animation" style="--i:3; --j:24">Đăng nhập</button>

                <div class="linkTxt animation" style="--i:5; --j:25">
                    <p>Chưa có tài khoản? <a href="#" class="register-link">Đăng ký ngay</a></p>
                </div>
            </form>
        </div>

        <div class="info-text login">
            <h2 class="animation" style="--i:0; --j:20">Chào mừng trở lại!</h2>
            <p class="animation" style="--i:1; --j:21">Đăng nhập để tiếp tục mua sắm nhé!</p>
        </div>

        {{-- FORM ĐĂNG KÝ --}}
        <div class="form-box register">
            <h2 class="title animation" style="--i:17; --j:0">Đăng ký</h2>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="input-box animation" style="--i:18; --j:1">
                    {{-- THÊM placeholder=" " VÀO ĐÂY --}}
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder=" ">
                    <label>Họ và tên</label>
                    <i class='bx bxs-user'></i>
                    @error('name') <span class="text-danger" style="font-size: 12px; position: absolute; bottom: -20px; left:0">{{ $message }}</span> @enderror
                </div>

                <div class="input-box animation" style="--i:19; --j:2">
                    {{-- THÊM placeholder=" " VÀO ĐÂY --}}
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder=" ">
                    <label>Email</label>
                    <i class='bx bxs-envelope'></i>
                    @error('email') <span class="text-danger" style="font-size: 12px; position: absolute; bottom: -20px; left:0">{{ $message }}</span> @enderror
                </div>

                <div class="input-box animation" style="--i:20; --j:3">
                    {{-- THÊM placeholder=" " VÀO ĐÂY --}}
                    <input type="password" name="password" required placeholder=" ">
                    <label>Mật khẩu</label>
                    <i class='bx bxs-lock-alt'></i>
                    @error('password') <span class="text-danger" style="font-size: 12px; position: absolute; bottom: -20px; left:0">{{ $message }}</span> @enderror
                </div>

                <div class="input-box animation" style="--i:20; --j:3">
                    {{-- THÊM placeholder=" " VÀO ĐÂY --}}
                    <input type="password" name="password_confirmation" required placeholder=" ">
                    <label>Nhập lại mật khẩu</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <button type="submit" class="btn btn-auth animation" style="--i:21;--j:4">Đăng ký</button>

                <div class="linkTxt animation" style="--i:22; --j:5">
                    <p>Đã có tài khoản? <a href="{{ route('login') }}" class="login-link">Đăng nhập</a></p>
                </div>
            </form>
        </div>

        <div class="info-text register">
            <h2 class="animation" style="--i:17; --j:0;">Bạn là người mới?</h2>
            <p class="animation" style="--i:18; --j:1;">Tạo tài khoản để trải nghiệm mua sắm tốt nhất nhé!</p>
        </div>
    </div>
</div>

<script src="{{ asset('js/auth-script.js') }}"></script>
@endsection