@extends('admin.layout')

@section('title', 'Thêm Danh mục mới')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Thêm Danh mục mới</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="arrow-left"></span> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Danh mục cha (Tùy chọn)</label>
                    <select class="form-select" id="parent_id" name="parent_id">
                        <option value="">-- Không có --</option>
                        @foreach ($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lưu danh mục</button>
            </form>
        </div>
    </div>
@endsection