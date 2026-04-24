@extends('admin.layout')
@section('title', 'Thêm sản phẩm bánh ngọt')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Thêm sản phẩm bánh ngọt</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Quay lại</a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên bánh <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại bánh</label>
                            <input type="text" class="form-control" name="cake_type" value="{{ old('cake_type') }}" placeholder="Bánh kem, mousse, cheesecake...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dịp sử dụng</label>
                            <input type="text" class="form-control" name="occasion" value="{{ old('occasion') }}" placeholder="Sinh nhật, tiệc trà, kỷ niệm...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kích cỡ</label>
                            <input type="text" class="form-control" name="size" value="{{ old('size') }}" placeholder="Mini, 14cm, 16cm, hộp 6 cái...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Khẩu phần</label>
                            <input type="text" class="form-control" name="serving_size" value="{{ old('serving_size') }}" placeholder="4-6 người, 1 phần, set 6 cái...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hương vị chính</label>
                            <input type="text" class="form-control" name="flavor" value="{{ old('flavor') }}" placeholder="Dâu, socola, matcha...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bộ sưu tập nội bộ</label>
                            <input type="text" class="form-control" name="collection" value="{{ old('collection') }}" placeholder="Signature, Party Box...">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Thành phần nổi bật</label>
                            <textarea class="form-control" name="ingredients" rows="3" placeholder="Ví dụ: cốt vani, kem tươi, dâu tươi, sốt chanh dây...">{{ old('ingredients') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thông tin dị ứng</label>
                            <input type="text" class="form-control" name="allergens" value="{{ old('allergens') }}" placeholder="Sữa, trứng, gluten, hạnh nhân...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời gian đặt trước</label>
                            <input type="number" min="0" class="form-control" name="lead_time_hours" value="{{ old('lead_time_hours', 2) }}" placeholder="Số giờ cần đặt trước">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bảo quản</label>
                            <input type="text" class="form-control" name="storage_instructions" value="{{ old('storage_instructions') }}" placeholder="Bảo quản lạnh 2-4°C">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hạn dùng / thời điểm ngon nhất</label>
                            <input type="text" class="form-control" name="shelf_life" value="{{ old('shelf_life') }}" placeholder="Ngon nhất trong ngày / 24 giờ">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Mẫu lời nhắn gợi ý trên bánh</label>
                            <input type="text" class="form-control" name="custom_message" value="{{ old('custom_message') }}" placeholder="Happy Birthday, Chúc mừng sinh nhật...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" name="description" rows="5">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thương hiệu / bộ sưu tập <span class="text-danger">*</span></label>
                        <select class="form-select" name="brand_id" required>
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Giá & tồn kho</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Mã SKU <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sku" required value="{{ old('sku') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá niêm yết <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="price" required value="{{ old('price') }}" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá khuyến mãi</label>
                        <input type="number" class="form-control" name="sale_price" value="{{ old('sale_price') }}" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng tồn</label>
                        <input type="number" class="form-control" name="quantity" value="{{ old('quantity', 0) }}" min="0">
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_customizable" value="1" {{ old('is_customizable') ? 'checked' : '' }}>
                        <label class="form-check-label">Cho phép tùy chỉnh/viết chữ</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label">Sản phẩm nổi bật</label>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Ảnh đại diện</div>
                <div class="card-body">
                    <input type="file" class="form-control" name="thumbnail" accept="image/*">
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg mb-5">Lưu sản phẩm</button>
</form>
@endsection
