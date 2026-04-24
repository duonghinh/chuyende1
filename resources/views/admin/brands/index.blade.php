@extends('admin.layout')
@section('title', 'Danh sách Thương hiệu')
@section('content')
    <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-primary">+ Thêm mới</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Tên thương hiệu</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
            <tr>
                <td>{{ $brand->id }}</td>
                <td>
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" width="50" alt="{{ $brand->name }}">
                    @else
                        <span class="text-muted">Không có logo</span>
                    @endif
                </td>
                <td>{{ $brand->name }}</td>
                <td>
                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection