<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- BỘ LỌC NGÀY THÁNG ---
        // 1. Lấy ngày bắt đầu và kết thúc từ request
        // Mặc định: 30 ngày gần nhất
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subDays(29);

        // Đảm bảo $endDate luôn lớn hơn $startDate
        if ($startDate->gt($endDate)) {
            $startDate = $endDate->copy()->subDays(29);
        }

        // --- 4 THẺ THỐNG KÊ (Lọc theo ngày) ---
        // Doanh thu chỉ tính đơn Hoàn thành (Status 3)
        $totalRevenue = Order::where('status', 3) 
                            ->whereBetween('updated_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                            ->sum('total_amount');

        $newOrders = Order::where('status', 0) // Chỉ tính đơn "Mới đặt" (Status 0)
                          ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                          ->count();

        // Các thống kê tổng (không lọc theo ngày)
        $totalCustomers = User::where('role', 0)->count();
        $totalProducts = Product::count();

        // --- BIỂU ĐỒ 1: DOANH THU (Lọc theo ngày) ---
        // Lấy doanh thu (đơn Hoàn thành - Status 3) theo từng ngày trong khoảng đã chọn
        $revenueData = Order::select(
                                 DB::raw('DATE(updated_at) as date'),
                                 DB::raw('SUM(total_amount) as total')
                            )
                            ->where('status', 3) // Lọc theo Status 3 (Hoàn thành)
                            ->whereBetween('updated_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                            ->groupBy('date')
                            ->orderBy('date', 'asc')
                            ->get();
        
        // Chuẩn bị mảng dữ liệu cho biểu đồ (lấp đầy các ngày không có doanh thu)
        $chartLabels = [];
        $chartData = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('d/m');
            $chartLabels[] = $dateString;

            // Tìm doanh thu cho ngày này
            $dailyRevenue = $revenueData->firstWhere('date', $currentDate->format('Y-m-d'));
            $chartData[] = $dailyRevenue ? $dailyRevenue->total : 0;
            
            $currentDate->addDay();
        }

        // --- BIỂU ĐỒ 2: TRẠNG THÁI ĐƠN HÀNG (Lọc theo ngày) ---
        $statusCounts = Order::select('status', DB::raw('COUNT(*) as count'))
                            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                            ->groupBy('status')
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->status => $item->count];
                            });

        // Cập nhật lại 5 trạng thái theo cấu trúc của người dùng (0->4)
        $statusData = [
            $statusCounts->get(0, 0), // Mới đặt (Pending)
            $statusCounts->get(1, 0), // Đang xử lý (Processing)
            $statusCounts->get(2, 0), // Đang giao hàng (Shipping)
            $statusCounts->get(3, 0), // Hoàn thành (Completed)
            $statusCounts->get(4, 0), // Đã hủy (Cancelled)
        ];
        $statusLabels = ['Mới đặt', 'Đang xử lý', 'Đang giao hàng', 'Hoàn thành', 'Đã hủy']; // Cập nhật nhãn

        // --- ĐƠN HÀNG MỚI NHẤT (Lọc theo ngày) ---
        $recentOrders = Order::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Trả dữ liệu về view
        return view('admin.dashboard', compact(
            'totalRevenue', 
            'newOrders', 
            'totalCustomers', 
            'totalProducts', 
            'recentOrders',
            'chartLabels',
            'chartData',
            'statusLabels',
            'statusData',
            'startDate', // Gửi lại ngày đã chọn để hiển thị trên form
            'endDate'
        ));
    }
}