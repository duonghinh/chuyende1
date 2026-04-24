@extends('admin.layout')
@section('title', 'Danh sách Đơn hàng')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Danh sách Đơn hàng</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Ngày đặt</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th> {{-- Thêm cột này để dễ theo dõi --}}
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    {{ $order->customer_name }}<br>
                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                </td>
                                <td class="fw-bold text-danger">{{ number_format($order->total_amount) }}đ</td>
                                
                                {{-- Cột Thanh toán --}}
                                <td>
                                    @if($order->payment_status == 'Paid')
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Đã TT</span>
                                    @else
                                        <span class="badge bg-secondary">Chưa TT</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $order->payment_method }}</small>
                                </td>

                                {{-- Cột Trạng thái (ĐÃ SỬA LOGIC HIỂN THỊ TẠI ĐÂY) --}}
                                <td>
                                    @switch($order->status)
                                        @case(0)
                                            <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                            @break
                                        @case(1)
                                            <span class="badge bg-primary">Đang xử lý</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-info text-dark">Đang giao hàng</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-success">Đã hoàn thành</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Chưa có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection