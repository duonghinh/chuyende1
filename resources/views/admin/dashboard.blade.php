@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tổng quan</h1>
    </div>

    <!-- 4 Thẻ thống kê nhanh -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Đơn hàng mới</h5>
                    <p class="card-text display-6 fw-bold">{{ $newOrders }}</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.orders.index') }}" class="text-white text-decoration-none small stretched-link">Xem chi tiết</a>
                    <div class="text-white small"><span data-feather="arrow-right"></span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="card-text display-6 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.orders.index', ['status' => 3]) }}" class="text-white text-decoration-none small stretched-link">Xem chi tiết</a>
                    <div class="text-white small"><span data-feather="arrow-right"></span></div>
                </div>
            </div>
        </div>
         <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning h-100 shadow">
                <div class="card-body text-dark">
                     <h5 class="card-title">Khách hàng</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalCustomers }}</p>
                </div>
                 <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.customers.index') }}" class="text-dark text-decoration-none small stretched-link">Xem chi tiết</a>
                    <div class="text-dark small"><span data-feather="arrow-right"></span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalProducts }}</p>
                </div>
                 <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.products.index') }}" class="text-white text-decoration-none small stretched-link">Xem chi tiết</a>
                    <div class="text-white small"><span data-feather="arrow-right"></span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BIỂU ĐỒ -->
    <div class="row">
        <!-- Biểu đồ doanh thu -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    Biểu đồ doanh thu (7 ngày gần nhất)
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Biểu đồ tròn Trạng thái đơn hàng -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    Tỷ lệ Trạng thái Đơn hàng
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="max-height: 300px;">
                         <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng mới nhất -->
    <h2 class="h4">Đơn hàng mới nhất</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                    <td>
                        {{-- CẬP NHẬT LOGIC HIỂN THỊ 5 TRẠNG THÁI --}}
                        @if($order->status == 0)
                            <span class="badge bg-warning text-dark">Mới đặt</span>
                        @elseif($order->status == 1)
                            <span class="badge bg-info text-dark">Đang xử lý</span>
                        @elseif($order->status == 2)
                            <span class="badge bg-primary">Đang giao</span>
                        @elseif($order->status == 3)
                            <span class="badge bg-success">Hoàn thành</span>
                        @elseif($order->status == 4)
                            <span class="badge bg-danger">Đã hủy</span>
                        @else
                            <span class="badge bg-secondary">Không rõ</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Chưa có đơn hàng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dữ liệu từ Controller
        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);
        const statusLabels = @json($statusLabels);
        const statusData = @json($statusData);

        // 1. Biểu đồ Doanh thu (Line Chart)
        const ctxLine = document.getElementById('revenueChart');
        if (ctxLine) {
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: chartData,
                        fill: true,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. Biểu đồ Trạng thái (Pie Chart) - ĐÃ CẬP NHẬT ĐỦ 5 MÀU
        const ctxPie = document.getElementById('orderStatusChart');
        if (ctxPie) {
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Số lượng đơn',
                        data: statusData,
                        backgroundColor: [
                            'rgb(255, 193, 7)',   // 0: Mới đặt (Vàng)
                            'rgb(13, 202, 240)',  // 1: Đang xử lý (Xanh lơ)
                            'rgb(13, 110, 253)',  // 2: Đang giao (Xanh dương đậm)
                            'rgb(25, 135, 84)',   // 3: Hoàn thành (Xanh lá)
                            'rgb(220, 53, 69)'    // 4: Đã hủy (Đỏ)
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        }
    </script>
@endsection