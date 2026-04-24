$(document).ready(function(){
    // Kích hoạt Owl Carousel cho class .product-slider
    $(".product-slider").owlCarousel({
        loop: false, // Không lặp vô tận (để người dùng biết đâu là điểm đầu/cuối)
        margin: 15,  // Khoảng cách giữa các item
        nav: true,   // Hiển thị nút mũi tên Prev/Next
        dots: false, // Ẩn các chấm tròn bên dưới
        autoplay: true, // Tự động chạy
        autoplayTimeout: 4000, // 4 giây chuyển 1 lần
        autoplayHoverPause: true, // Di chuột vào thì dừng
        navText: [
            '<i class="bi bi-chevron-left"></i>', 
            '<i class="bi bi-chevron-right"></i>'
        ],
        responsive: {
            0: {
                items: 1 // Mobile: 1 sản phẩm
            },
            576: {
                items: 2 // Tablet nhỏ: 2 sản phẩm
            },
            768: {
                items: 3 // Tablet: 3 sản phẩm
            },
            992: {
                items: 4 // Desktop nhỏ: 4 sản phẩm
            },
            1200: {
                items: 5 // Desktop lớn: 5 sản phẩm
            }
        }
    });
});