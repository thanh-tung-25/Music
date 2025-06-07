import './bootstrap';
document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.querySelector('.preloader');
    
    if (preloader) {
        // Hiển thị preloader khi trang bắt đầu tải
        preloader.style.display = 'flex';
        
        // Ẩn preloader khi trang tải xong
        window.addEventListener('load', function() {
            preloader.style.display = 'none';
        });
    }
});