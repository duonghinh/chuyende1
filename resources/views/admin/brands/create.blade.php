@extends('admin.layout')
@section('title', 'Thêm Thương hiệu')
@section('content')
    <h1 class="h2">Thêm Thương hiệu</h1>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Logo</label>
                    <input type="file" class="form-control" name="logo" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Lưu thương hiệu</button>
            </form>
        </div>
    </div>
@endsection