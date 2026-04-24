@extends('client.layout')
@section('title', 'Tài khoản của tôi')

@section('content')
    <h2 class="fw-bold mb-4">Tài khoản của tôi</h2>

    <div class="row">
        <!-- Menu điều hướng (Tùy chọn, làm sau) -->
        <div class="col-lg-3">
             <div class="list-group mb-4 shadow-sm">
                <a href="{{ route('client.account.index') }}" class="list-group-item list-group-item-action active" aria-current="true">
                    Thông tin tài khoản
                </a>
                <a href="{{ route('client.orders.index') }}" class="list-group-item list-group-item-action">
                    Lịch sử đơn hàng
                </a>
            </div>
        </div>

        <!-- Nội dung chính -->
        <div class="col-lg-9">
            <!-- Form 1: Cập nhật thông tin -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">Cập nhật thông tin cá nhân</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success_profile'))
                        <div class="alert alert-success">{{ session('success_profile') }}</div>
                    @endif
                    <form action="{{ route('client.account.update_profile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', $user->address) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </form>
                </div>
            </div>

            <!-- Form 2: Đổi mật khẩu -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">Đổi mật khẩu</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success_password'))
                        <div class="alert alert-success">{{ session('success_password') }}</div>
                    @endif
                    <form action="{{ route('client.account.update_password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                             @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection