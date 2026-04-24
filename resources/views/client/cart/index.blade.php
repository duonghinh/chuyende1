@extends('client.layout')
@section('title', 'Giỏ hàng')

@section('css')
    @vite(['resources/css/index.css', 'resources/js/app.js'])
    {{-- Import file CSS riêng cho Cart --}}
    <link href="{{ asset('css/client-cart.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="py-4">
    {{-- 1. THÊM DÒNG NÀY: Khu vực hiển thị thông báo AJAX (Nằm đè lên góc phải) --}}
    <div id="ajax-alert" class="position-fixed top-0 end-0 p-3" style="z-index: 1060;"></div>

    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold m-0"><i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn</h3>
        @if(session('cart'))
            <span class="badge bg-primary ms-3 rounded-pill">{{ count(session('cart')) }} sản phẩm</span>
        @endif
    </div>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row">
            {{-- CỘT TRÁI: DANH SÁCH SẢN PHẨM --}}
            <div class="col-lg-8 mb-4">
                <div class="card card-cart">
                    <div class="table-responsive">
                        <table class="table cart-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 45%">Sản phẩm</th>
                                    <th style="width: 15%" class="text-center">Đơn giá</th>
                                    <th style="width: 20%" class="text-center">Số lượng</th>
                                    <th style="width: 15%" class="text-center">Thành tiền</th>
                                    <th style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('cart') as $id => $details)
                                    <tr data-id="{{ $id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-img-box me-3">
                                                    @if($details['thumbnail'])
                                                        <img src="{{ asset('storage/' . $details['thumbnail']) }}" alt="{{ $details['name'] }}">
                                                    @else
                                                        <img src="https://via.placeholder.com/80" alt="No Image">
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="fw-semibold mb-1 text-truncate" style="max-width: 280px;">
                                                        <a href="{{ route('client.product.detail', $id) }}" class="text-decoration-none text-dark">
                                                            {{ $details['name'] }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">Mã SP: #{{ $id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-semibold">
                                            {{ number_format($details['price']) }}đ
                                        </td>
                                        <td>
                                            <div class="quantity-group mx-auto">
                                                <button type="button" class="btn-quantity btn-decrease"><i class="bi bi-dash"></i></button>
                                                <input type="number" value="{{ $details['quantity'] }}" class="input-quantity quantity-input" min="1">
                                                <button type="button" class="btn-quantity btn-increase"><i class="bi bi-plus"></i></button>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-primary item-total">
                                            {{ number_format($details['price'] * $details['quantity']) }}đ
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('cart.remove', $id) }}" class="text-danger fs-5" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('client.shop') }}" class="btn btn-outline-secondary fw-semibold">
                        <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            {{-- CỘT PHẢI: TỔNG TIỀN --}}
            <div class="col-lg-4">
                <div class="summary-card p-4">
                    <h5 class="fw-bold mb-4">Thông tin đơn hàng</h5>
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span class="fw-bold cart-total">{{ number_format($total) }}đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Giảm giá:</span>
                        <span class="text-success fw-bold">0đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div class="summary-total">
                        <span class="label">Tổng cộng:</span>
                        <span class="value cart-total">{{ number_format($total) }}đ</span>
                    </div>
                    <small class="text-muted d-block mb-4 mt-2 text-end fst-italic">(Đã bao gồm VAT nếu có)</small>
                    <div class="d-grid gap-2">
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-checkout">
                            Tiến hành thanh toán <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-3 shadow-sm">
            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" alt="Empty Cart" width="150" class="mb-4 opacity-75">
            <h4 class="fw-bold text-dark">Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted mb-4">Hãy dạo một vòng và chọn cho mình những sản phẩm ưng ý nhé!</p>
            <a href="{{ route('client.shop') }}" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">
                Mua sắm ngay
            </a>
        </div>
    @endif
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        
        // 2. HÀM HIỂN THỊ THÔNG BÁO (TOAST)
        function showToast(message, type = 'success') {
            let icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
            let bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            
            // Tạo HTML cho Toast
            let html = `
                <div class="toast align-items-center text-white ${bgClass} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi ${icon} me-2"></i> ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            // Chèn vào div #ajax-alert
            $('#ajax-alert').html(html);
            
            // Tự động ẩn sau 3 giây
            setTimeout(() => {
                $('#ajax-alert .toast').removeClass('show');
                setTimeout(() => { $('#ajax-alert').empty(); }, 500); 
            }, 3000);
        }

        // --- Xử lý nút Tăng (+) ---
        $('.btn-increase').click(function() {
            let input = $(this).siblings('.quantity-input');
            let val = parseInt(input.val());
            input.val(val + 1).trigger('change'); 
        });

        // --- Xử lý nút Giảm (-) ---
        $('.btn-decrease').click(function() {
            let input = $(this).siblings('.quantity-input');
            let val = parseInt(input.val());
            if (val > 1) {
                input.val(val - 1).trigger('change'); 
            } else {
                showToast('Số lượng tối thiểu là 1', 'error'); // Gọi hàm showToast
            }
        });

        // --- AJAX Cập nhật ---
        $(".quantity-input").change(function (e) {
            e.preventDefault();

            var ele = $(this);
            var tr = ele.parents("tr");
            var quantity = ele.val();
            var id = tr.attr("data-id");

            if(quantity < 1) {
                showToast("Số lượng phải lớn hơn 0", 'error');
                ele.val(1);
                return;
            }

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: id, 
                    quantity: quantity
                },
                success: function (response) {
                    if(response.success) {
                        // Cập nhật giá tiền
                        tr.find(".item-total").text(response.itemTotal + "đ");
                        $(".cart-total").text(response.cartTotal + "đ");
                        
                        // Hiệu ứng nháy màu
                        tr.find(".item-total").css('color', '#dc3545').fadeOut(100).fadeIn(100, function() {
                            $(this).css('color', ''); 
                        });

                        // 3. GỌI HÀM HIỂN THỊ THÔNG BÁO TẠI ĐÂY
                        showToast('Đã cập nhật giỏ hàng!');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showToast('Lỗi cập nhật, vui lòng thử lại', 'error');
                }
            });
        });
    });
</script>
@endsection