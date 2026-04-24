@extends('client.layout')
@section('title', 'Chi tiết Đơn hàng #' . $order->id)

@section('css')
    {{-- 1. CSS Chung cho đơn hàng (Badges, Card cơ bản) --}}
    <link href="{{ asset('css/client-order.css') }}" rel="stylesheet">
    
    {{-- 2. CSS Riêng cho trang Chi tiết (Timeline, Info box, Bảng chi tiết) --}}
    <link href="{{ asset('css/client-order-detail.css') }}" rel="stylesheet">
    
    {{-- CSS Inline Fix lỗi tràn trên Mobile --}}
    <style>
        /* Tạo thanh cuộn cho timeline trên màn hình nhỏ */
        .timeline-wrapper {
            overflow-x: auto;
            padding-bottom: 10px; /* Chừa chỗ cho thanh cuộn đẹp hơn */
        }
        .order-timeline {
            min-width: 600px; /* Đảm bảo timeline không bị co quá nhỏ */
        }
    </style>
@endsection

@section('content')
<div class="container py-5">
    
    {{-- Header: Tiêu đề & Nút quay lại --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-primary">
                Chi tiết đơn hàng <span class="text-dark">#{{ $order->id }}</span>
            </h2>
            <p class="text-muted small m-0">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('client.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    {{-- Phần Timeline Trạng thái --}}
    @if($order->status != 4)
        <div class="card card-order mb-4">
            <div class="card-body py-4">
                {{-- WRAPPER ĐỂ FIX LỖI TRÀN TIMELINE --}}
                <div class="timeline-wrapper">
                    <div class="order-timeline">
                        {{-- Bước 1: Chờ xác nhận --}}
                        <div class="timeline-step {{ $order->status >= 0 ? 'active' : '' }}">
                            <div class="step-icon"><i class="bi bi-clipboard-check"></i></div>
                            <div class="step-label">Đã đặt hàng</div>
                        </div>
                        {{-- Bước 2: Đang xử lý --}}
                        <div class="timeline-step {{ $order->status >= 1 ? 'active' : '' }}">
                            <div class="step-icon"><i class="bi bi-box-seam"></i></div>
                            <div class="step-label">Đang xử lý</div>
                        </div>
                        {{-- Bước 3: Đang giao hàng --}}
                        <div class="timeline-step {{ $order->status >= 2 ? 'active' : '' }}">
                            <div class="step-icon"><i class="bi bi-truck"></i></div>
                            <div class="step-label">Đang giao hàng</div>
                        </div>
                        {{-- Bước 4: Hoàn thành --}}
                        <div class="timeline-step {{ $order->status == 3 ? 'active' : '' }}">
                            <div class="step-icon"><i class="bi bi-star"></i></div>
                            <div class="step-label">Hoàn thành</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger mb-4 d-flex align-items-center shadow-sm border-0">
            <i class="bi bi-x-circle-fill fs-3 me-3"></i>
            <div>
                <strong class="fs-5">Đơn hàng đã bị hủy</strong>
                <p class="m-0">Đơn hàng này đã bị hủy và quy trình xử lý đã dừng lại.</p>
            </div>
        </div>
    @endif

    <div class="row g-4">
        {{-- CỘT TRÁI: THÔNG TIN KHÁCH HÀNG & GIAO HÀNG --}}
        <div class="col-lg-4">
            {{-- Thêm div wrapper với position: sticky để cột này trôi theo khi cuộn --}}
            <div style="position: sticky; top: 100px;">
                {{-- Thông tin người nhận --}}
                <div class="info-box mb-4">
                    <div class="info-box-title">
                        <i class="bi bi-person-bounding-box text-primary"></i> Thông tin nhận hàng
                    </div>
                    <div class="info-row">
                        <span class="info-label">Họ tên:</span>
                        <span class="fw-bold text-dark text-break">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Điện thoại:</span>
                        <span>{{ $order->customer_phone }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="text-break">{{ $order->customer_email ?? 'Không có' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Địa chỉ:</span>
                        <span class="text-break">{{ $order->shipping_address }}</span>
                    </div>
                </div>

                {{-- Thông tin bổ sung --}}
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="bi bi-info-circle text-primary"></i> Thông tin khác
                    </div>
                    <div class="info-row">
                        <span class="info-label">Thanh toán:</span>
                        <span class="badge {{ $order->payment_status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $order->payment_status == 'Paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Hình thức:</span>
                        <span class="text-break">{{ $order->payment_method }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ghi chú:</span>
                        <span class="fst-italic text-muted text-break">{{ $order->note ?? 'Không có ghi chú' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: DANH SÁCH SẢN PHẨM --}}
        <div class="col-lg-8">
            <div class="card card-order h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold m-0"><i class="bi bi-bag-check me-2 text-primary"></i>Danh sách sản phẩm</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-detail mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Sản phẩm</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->details as $detail)
                                    <tr>
                                        <td>
                                            <div class="product-item">
                                                {{-- Xử lý ảnh sản phẩm --}}
                                                @php
                                                    $thumbnail = $detail->product->thumbnail ?? null; 
                                                @endphp
                                                @if($thumbnail)
                                                    <img src="{{ asset('storage/' . $thumbnail) }}" alt="{{ $detail->product_name }}">
                                                @else
                                                    <img src="https://via.placeholder.com/60" alt="No Image">
                                                @endif
                                                
                                                <div>
                                                    <div class="fw-bold text-dark text-break">{{ $detail->product_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                        <td class="text-center">x{{ $detail->quantity }}</td>
                                        <td class="text-end fw-bold text-dark">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Footer Tổng tiền --}}
                <div class="detail-footer">
                    <div class="row justify-content-end">
                        <div class="col-md-7 col-lg-6">
                            <div class="summary-item">
                                <span>Tổng tiền hàng:</span>
                                <span class="fw-bold">{{ number_format($order->total_amount) }}đ</span>
                            </div>
                            <div class="summary-item">
                                <span>Phí vận chuyển:</span>
                                <span class="text-success">Miễn phí</span>
                            </div>
                            <div class="summary-item">
                                <span>Giảm giá:</span>
                                <span>0đ</span>
                            </div>
                            <div class="summary-item total">
                                <span>TỔNG THANH TOÁN:</span>
                                <span>{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection