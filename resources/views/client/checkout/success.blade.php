@extends('client.layout')
@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
        </div>
        <h1 class="fw-bold mb-3">Đặt hàng thành công!</h1>
        <p class="lead text-muted mb-5">
            Cảm ơn bạn đã mua hàng tại Sweet Bakery.<br>
            Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">
            Tiếp tục mua sắm
        </a>
    </div>
@endsection