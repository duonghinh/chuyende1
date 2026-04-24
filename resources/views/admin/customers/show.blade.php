@extends('admin.layout')
@section('title', 'Chi tiết Khách hàng: ' . $customer->name)

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Chi tiết Khách hàng</h1>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-outline-secondary">Quay lại</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header fw-bold">Thông tin tài khoản</div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&size=128" class="rounded-circle mb-3" alt="{{ $customer->name }}">
                    <h5 class="card-title">{{ $customer->name }}</h5>
                    <p class="text-muted">{{ $customer->email }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> #{{ $customer->id }}</li>
                    <li class="list-group-item"><strong>SĐT:</strong> {{ $customer->phone ?? 'Chưa cập nhật' }}</li>
                    <li class="list-group-item"><strong>Địa chỉ:</strong> {{ $customer->address ?? 'Chưa cập nhật' }}</li>
                    <li class="list-group-item"><strong>Ngày tham gia:</strong> {{ $customer->created_at->format('d/m/Y') }}</li>
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span>Lịch sử đơn hàng</span>
                    <span class="badge bg-primary">{{ $customer->orders->count() }} đơn hàng</span>
                </div>
                <div class="card-body">
                    @if($customer->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->orders as $order)
                                    <tr>
                                        <td><a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->id }}</a></td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td>
                                            @if($order->status == 0)
                                                <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                            @elseif($order->status == 1)
                                                <span class="badge bg-info text-dark">Đang giao</span>
                                            @elseif($order->status == 2)
                                                <span class="badge bg-success">Hoàn thành</span>
                                            @else
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center my-4">Khách hàng này chưa đặt đơn hàng nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection