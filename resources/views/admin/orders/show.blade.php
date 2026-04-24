@extends('admin.layout')
@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Chi tiết đơn hàng #{{ $order->id }}</h1>
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <!-- CỘT TRÁI: THÔNG TIN ĐƠN HÀNG -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-box me-1"></i> Sản phẩm đã đặt
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($detail->product && $detail->product->thumbnail)
                                                <img src="{{ asset('storage/' . $detail->product->thumbnail) }}" width="50" class="me-2 rounded">
                                            @endif
                                            <div>
                                                {{ $detail->product_name }} <br>
                                                <small class="text-muted">SKU: {{ $detail->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ number_format($detail->price) }}đ</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td class="fw-bold">{{ number_format($detail->price * $detail->quantity) }}đ</td>
                                </tr>
                            @endforeach
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="fw-bold text-danger fs-5">{{ number_format($order->total_amount) }}đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-user me-1"></i> Thông tin khách hàng
                </div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: TRẠNG THÁI & HÀNH ĐỘNG -->
        <div class="col-md-4">
            
            {{-- TRẠNG THÁI THANH TOÁN --}}
            <div class="card mb-4 border-{{ $order->payment_status == 'Paid' ? 'success' : 'warning' }}">
                <div class="card-header fw-bold bg-{{ $order->payment_status == 'Paid' ? 'success' : 'warning' }} text-white">
                    <i class="fas fa-money-bill-wave me-1"></i> Thanh toán
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">
                        @if($order->payment_status == 'Paid')
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> ĐÃ THANH TOÁN</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> CHƯA THANH TOÁN</span>
                        @endif
                    </h5>
                    <p class="mt-2 mb-1">Phương thức: <strong>{{ $order->payment_method }}</strong></p>
                    
                    @if($order->transaction_code)
                        <div class="alert alert-info py-2 mt-2 mb-0 small">
                            Khách ghi chú mã GD: <strong>{{ $order->transaction_code }}</strong>
                        </div>
                    @endif

                    {{-- NÚT XÁC NHẬN THANH TOÁN (Chỉ hiện khi chưa thanh toán) --}}
                    @if($order->payment_status != 'Paid')
                        <hr>
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="confirm_payment" value="1" class="btn btn-success w-100" onclick="return confirm('Bạn đã kiểm tra tài khoản ngân hàng chưa?')">
                                <i class="fas fa-check"></i> Xác nhận đã nhận tiền
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- TRẠNG THÁI ĐƠN HÀNG --}}
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-truck me-1"></i> Trạng thái đơn hàng
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Mới đặt (Pending)</option>
                                <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang xử lý (Processing)</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đang giao hàng (Shipping)</option>
                                <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Hoàn thành (Completed)</option>
                                <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Đã hủy (Cancelled)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection