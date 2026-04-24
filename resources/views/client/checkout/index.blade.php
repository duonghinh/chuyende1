@extends('client.layout')
@section('title', 'Thanh toán')

@section('content')
<div class="py-4">
    <div class="shop-hero mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="bakery-chip mb-3"><i class="bi bi-bag-heart"></i> Hoàn tất đơn bánh</span>
                <h2 class="mb-2 fw-bold">Xác nhận thông tin và nhận bánh</h2>
                <p class="text-muted mb-0">Lựa chọn giao bánh tận nơi hoặc đến nhận trực tiếp tại cửa hàng.</p>
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary rounded-pill px-4"><i class="bi bi-arrow-left me-2"></i>Quay lại giỏ hàng</a>
        </div>
    </div>
    
    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <div class="card bakery-soft-card border-0 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="mb-4 p-3 rounded-4 border bg-white">
                            <label class="form-label fw-bold d-block mb-3 text-secondary text-uppercase small">Bạn muốn nhận bánh bằng cách nào?</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping_method" id="method_delivery" value="delivery" checked>
                                    <label class="form-check-label fw-semibold" for="method_delivery">
                                        <i class="bi bi-truck me-1"></i> Giao bánh tận nơi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shipping_method" id="method_pickup" value="pickup">
                                    <label class="form-check-label fw-semibold" for="method_pickup">
                                        <i class="bi bi-shop me-1"></i> Nhận tại cửa hàng
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Họ tên người nhận <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-4" name="customer_name" value="{{ auth()->user()->name ?? '' }}" required placeholder="Nhập họ tên người nhận">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-4" name="customer_phone" value="{{ auth()->user()->phone ?? '' }}" required placeholder="Nhập số điện thoại">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email (Để nhận thông báo)</label>
                                <input type="email" class="form-control rounded-4" name="customer_email" value="{{ auth()->user()->email ?? '' }}" placeholder="example@gmail.com">
                            </div>
                        </div>

                        <div class="mb-3" id="address_box">
                            <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea class="form-control rounded-4" name="shipping_address" id="shipping_address" rows="2" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện...">{{ auth()->user()->address ?? '' }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Ghi chú đơn hàng (Tùy chọn)</label>
                            <textarea class="form-control rounded-4" name="note" rows="3" placeholder="Ví dụ: Viết chữ “Happy Birthday”, giao đúng 18:00..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card bakery-soft-card border-0">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-cart-check-fill me-2"></i>Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($cart as $item)
                                <li class="list-group-item d-flex justify-content-between lh-sm align-items-center px-0 py-3 bg-transparent">
                                    <div>
                                        <h6 class="my-0 text-dark fw-bold">{{ $item['name'] }}</h6>
                                        <small class="text-muted">Đơn giá: {{ number_format($item['price']) }}đ x {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="text-dark fw-semibold">{{ number_format($item['price'] * $item['quantity']) }}đ</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center mt-2 rounded-4 px-3 py-3" style="background:#fff5f7; border:1px solid rgba(217,108,138,0.08);">
                                <span class="fw-bold">Tổng cộng (VND)</span>
                                <strong class="text-danger fs-4">{{ number_format($total) }}đ</strong>
                            </li>
                        </ul>

                        <div class="bakery-note-box p-3 mb-4">
                            <div class="fw-bold mb-1">Mẹo cho đơn bánh đẹp hơn</div>
                            <div class="text-muted small">Nếu nhận tại cửa hàng, quý khách vui lòng đến sau 30-60 phút kể từ khi đặt đơn.</div>
                        </div>

                        <h6 class="mb-3 fw-bold text-uppercase">Phương thức thanh toán</h6>
                        
                        <div class="form-check mb-2 p-3 border rounded-4 bg-white">
                            <input id="payment_cod" name="payment_method" type="radio" class="form-check-input" value="COD" checked>
                            <label class="form-check-label fw-semibold" for="payment_cod">
                                <i class="bi bi-cash-coin me-2 text-success"></i> Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>

                        <div class="form-check mb-4 p-3 border rounded-4 bg-light">
                            <input id="payment_bank" name="payment_method" type="radio" class="form-check-input" value="BANK">
                            <label class="form-check-label fw-semibold" for="payment_bank">
                                <i class="bi bi-qr-code-scan me-2 text-primary"></i> Chuyển khoản VietQR
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-5 text-uppercase shadow rounded-pill">
                            ĐẶT HÀNG NGAY <i class="bi bi-arrow-right-circle ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- SCRIPT ĐIỀU KHIỂN ẨN HIỆN ĐỊA CHỈ --}}
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodDelivery = document.getElementById('method_delivery');
        const methodPickup = document.getElementById('method_pickup');
        const addressBox = document.getElementById('address_box');
        const addressInput = document.getElementById('shipping_address');

        function toggleAddress() {
            if (methodPickup.checked) {
                addressBox.style.display = 'none';
                addressInput.removeAttribute('required');
            } else {
                addressBox.style.display = 'block';
                addressInput.setAttribute('required', 'required');
            }
        }

        methodDelivery.addEventListener('change', toggleAddress);
        methodPickup.addEventListener('change', toggleAddress);
    });
</script>
@endsection
@endsection