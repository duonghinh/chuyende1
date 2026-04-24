@extends('client.layout')
@section('title', 'Lịch sử đơn hàng')

@section('css')
    {{-- Import CSS riêng cho đơn hàng --}}
    <link href="{{ asset('css/client-order.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11"> {{-- Tăng độ rộng lên chút cho thoáng --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold m-0 text-dark">Lịch sử đơn hàng</h2>
                    <p class="text-muted small m-0">Quản lý và theo dõi quá trình vận chuyển</p>
                </div>
                <a href="{{ route('client.shop') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-cart-plus me-2"></i>Tiếp tục mua sắm
                </a>
            </div>

            <div class="card card-order">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-order mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">Mã đơn</th>
                                    <th>Thời gian đặt</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Tổng tiền</th>
                                    <th class="text-center">Thanh toán</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="text-center">
                                            <span class="order-id">#{{ $order->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $order->created_at->format('d/m/Y') }}</span>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            {{-- Hiển thị tóm tắt tên sản phẩm đầu tiên --}}
                                            <span class="text-truncate d-block" style="max-width: 200px;" title="Bấm xem chi tiết">
                                                Xem chi tiết...
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <span class="total-price">{{ number_format($order->total_amount) }}đ</span>
                                        </td>
                                        
                                        {{-- Trạng thái Thanh toán --}}
                                        <td class="text-center">
                                            @if($order->payment_status == 'Paid')
                                                <div class="payment-status paid fw-bold">
                                                    <i class="bi bi-check-circle-fill"></i> Đã thanh toán
                                                </div>
                                            @else
                                                <div class="payment-status unpaid fw-bold">
                                                    <i class="bi bi-circle"></i> Chưa thanh toán
                                                </div>
                                            @endif
                                            <div class="small text-muted fst-italic mt-1">{{ $order->payment_method }}</div>
                                        </td>

                                        {{-- Trạng thái Đơn hàng (Badges đẹp) --}}
                                        <td class="text-center">
                                            @switch($order->status)
                                                @case(0)
                                                    <span class="status-badge status-pending">
                                                        <i class="bi bi-hourglass-split"></i> Chờ xác nhận
                                                    </span>
                                                    @break
                                                @case(1)
                                                    <span class="status-badge status-processing">
                                                        <i class="bi bi-gear-wide-connected"></i> Đang xử lý
                                                    </span>
                                                    @break
                                                @case(2)
                                                    <span class="status-badge status-shipping">
                                                        <i class="bi bi-truck"></i> Đang giao
                                                    </span>
                                                    @break
                                                @case(3)
                                                    <span class="status-badge status-completed">
                                                        <i class="bi bi-check-all"></i> Hoàn thành
                                                    </span>
                                                    @break
                                                @case(4)
                                                    <span class="status-badge status-cancelled">
                                                        <i class="bi bi-x-circle"></i> Đã hủy
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="status-badge status-default">Không xác định</span>
                                            @endswitch
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('client.orders.show', $order->id) }}" class="btn-view-detail" title="Xem chi tiết đơn hàng">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No Orders" width="80" class="mb-3 opacity-50">
                                            <p class="text-muted fs-5 m-0">Bạn chưa có đơn hàng nào.</p>
                                            <a href="{{ route('client.shop') }}" class="btn btn-sm btn-primary mt-3">Mua sắm ngay</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Phân trang --}}
                @if($orders->hasPages())
                    <div class="card-footer py-3">
                        <div class="d-flex justify-content-center">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection