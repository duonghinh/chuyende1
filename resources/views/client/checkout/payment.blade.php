@extends('client.layout')
@section('title', 'Thanh toán chuyển khoản')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0 fw-bold text-white">THANH TOÁN CHUYỂN KHOẢN</h4>
                    <p class="mb-0 opacity-75">Đơn hàng #{{ $order->id }}</p>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- CỘT TRÁI: MÃ QR -->
                        <div class="col-md-6 text-center border-end">
                            <p class="fw-bold text-secondary mb-2">Quét mã QR bằng App Ngân hàng</p>
                            
                            {{-- TẠO QR CODE VIETQR --}}
                            @php
                                $bankId = 'MB'; // Mã ngân hàng (MB, VCB, TCB...)
                                $accountNo = '0386248487'; // Số tài khoản CỦA BẠN
                                $accountName = 'PHAN TRUONG'; // Tên chủ tài khoản
                                $amount = $order->total_amount;
                                $content = 'DH' . $order->id; // Nội dung CK: DH123
                                
                                // Link tạo ảnh QR tự động
                                $qrSrc = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$amount}&addInfo={$content}&accountName={$accountName}";
                            @endphp

                            <img src="{{ $qrSrc }}" alt="QR Code" class="img-fluid border rounded shadow-sm mb-3" style="max-width: 280px;">
                            
                            <div class="alert alert-info small py-2">
                                <i class="bi bi-info-circle-fill"></i> Hệ thống đã tự động điền Số tiền và Nội dung chuyển khoản trong mã QR.
                            </div>
                        </div>

                        <!-- CỘT PHẢI: THÔNG TIN & XÁC NHẬN -->
                        <div class="col-md-6 ps-md-4 d-flex flex-column justify-content-center">
                            <h5 class="fw-bold text-dark mb-3">Thông tin chuyển khoản</h5>
                            
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Ngân hàng:</span>
                                    <span class="fw-bold">MB Bank</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Số tài khoản:</span>
                                    <span class="fw-bold text-primary">{{ $accountNo }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Chủ tài khoản:</span>
                                    <span class="fw-bold">{{ $accountName }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="text-muted">Số tiền:</span>
                                    <span class="fw-bold text-danger fs-5">{{ number_format($amount) }}đ</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 bg-light p-2 rounded mt-2">
                                    <span class="text-muted">Nội dung CK:</span>
                                    <span class="fw-bold text-success">{{ $content }}</span>
                                </li>
                            </ul>

                            <hr>

                            <!-- FORM XÁC NHẬN (QUAN TRỌNG) -->
                            <form action="{{ route('checkout.confirm_payment', $order->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nhập mã giao dịch (Nếu có):</label>
                                    <input type="text" name="transaction_code" class="form-control" placeholder="VD: FT2305...">
                                    <div class="form-text">Nhập mã giao dịch ngân hàng để chúng tôi xác nhận nhanh hơn.</div>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                                    <i class="bi bi-check-circle-fill me-2"></i> TÔI ĐÃ CHUYỂN KHOẢN
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection