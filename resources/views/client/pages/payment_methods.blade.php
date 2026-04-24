@extends('client.layout')
@section('title', 'Phương thức thanh toán - Sweet Bakery')
@section('content')
<div class="py-4">
    <h1 class="fw-bold mb-3">Phương thức thanh toán</h1>
    <div class="row g-4">
        <div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><h5 class="fw-bold">Thanh toán khi nhận hàng (COD)</h5><p class="mb-0 text-muted">Áp dụng cho đơn nội thành và các đơn đủ điều kiện giao hàng thu tiền.</p></div></div></div>
        <div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><h5 class="fw-bold">Chuyển khoản ngân hàng</h5><p class="mb-0 text-muted">Khách có thể chuyển khoản trước để shop xác nhận và ưu tiên chuẩn bị đơn hàng.</p></div></div></div>
    </div>
</div>
@endsection
