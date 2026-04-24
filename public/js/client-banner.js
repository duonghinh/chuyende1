document.addEventListener("DOMContentLoaded", function () {
    const footer = document.querySelector('.footer-custom');
    const banners = document.querySelectorAll('.banner-ad-float');
    
    // Nếu không có footer hoặc banner thì dừng luôn
    if (!footer || banners.length === 0) return;

    function checkBannerPosition() {
        // Lấy thông tin vị trí của Footer
        const footerRect = footer.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        
        // Khoảng cách an toàn giữa đáy banner và footer (để trông thoáng hơn)
        const gap = 30;

        banners.forEach(banner => {
            const bannerHeight = banner.offsetHeight;
            
            // Tính vị trí đáy của banner khi nó đang ở trạng thái bình thường (giữa màn hình)
            // Công thức: (Chiều cao màn hình / 2) + (Chiều cao banner / 2)
            const normalBannerBottom = (windowHeight / 2) + (bannerHeight / 2);

            // Logic chính:
            // footerRect.top là khoảng cách từ đỉnh màn hình đang xem đến mép trên footer.
            // Nếu footerRect.top NHỎ HƠN vị trí đáy banner => Footer đang đè lên banner.
            if (footerRect.top < normalBannerBottom + gap) {
                
                // Tính toán xem cần đẩy banner lên bao nhiêu pixel
                const shiftAmount = (normalBannerBottom + gap) - footerRect.top;
                
                // Dịch chuyển banner lên trên bằng transform
                // -50% là căn giữa gốc, trừ thêm shiftAmount để đẩy lên cao hơn
                banner.style.transform = `translateY(calc(-50% - ${shiftAmount}px))`;
            } else {
                // Nếu chưa chạm footer, trả về vị trí căn giữa mặc định
                banner.style.transform = 'translateY(-50%)';
            }
        });
    }

    // Lắng nghe sự kiện cuộn trang
    window.addEventListener('scroll', checkBannerPosition);
    // Lắng nghe sự kiện thay đổi kích thước màn hình (resize)
    window.addEventListener('resize', checkBannerPosition);
    
    // Gọi hàm 1 lần ngay khi tải trang để set vị trí ban đầu
    checkBannerPosition();
});