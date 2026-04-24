@extends('admin.layout')
@section('title', 'Sửa Thương hiệu')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Sửa Thương hiệu: {{ $brand->name }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-outline-secondary">
                Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $brand->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Logo mới (Tùy chọn)</label>
                    <input type="file" class="form-control" name="logo" accept="image/*">
                    <div class="form-text">Chỉ chọn nếu muốn thay đổi logo hiện tại.</div>
                </div>

                @if($brand->logo)
                    <div class="mb-3">
                        <label class="form-label">Logo hiện tại:</label>
                        <div>
                            <img src="{{ asset('storage/' . $brand->logo) }}" width="100" alt="Logo hiện tại" class="img-thumbnail">
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection