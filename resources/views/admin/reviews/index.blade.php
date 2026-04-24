@extends('admin.layout') {{-- Kế thừa từ layout admin của bạn --}}

@section('title', 'Quản lý Đánh giá')

@section('content')
    {{-- Cấu trúc tiêu đề giống hệt trang Product --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý Đánh giá</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            {{-- (Không có nút thêm mới cho đánh giá) --}}
        </div>
    </div>

    {{-- Thông báo (nếu có) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Bảng dữ liệu --}}
    <div class="table-responsive">
        {{-- class table giống hệt trang Product --}}
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    {{-- Bỏ cột ID, thêm cột Sản phẩm --}}
                    <th>Sản phẩm</th>
                    <th>Người đánh giá</th>
                    <th>Rating</th>
                    <th>Bình luận</th>
                    <th>Ngày</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr>
                        <td>
                            {{ $review->product->name ?? 'Sản phẩm không tồn tại' }}<br>
                            <small class="text-muted">ID: {{ $review->product->id ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $review->reviewer_name ?? ($review->user->name ?? 'N/A') }}</td>
                        <td>
                            <span class="text-warning">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </span>
                        </td>
                        <td>{{ $review->comment }}</td>
                        <td>{{ $review->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có đánh giá nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Phân trang -->
        {{ $reviews->links() }}
    </div>
@endsection