<?php
    session_start(); // Bắt đầu hoặc kết nối với phiên

    // Xóa toàn bộ danh sách sản phẩm từ biến session
    unset($_SESSION['cart']);

    echo '<script>alert("Toàn bộ giỏ hàng đã được xóa.");
    window.location.href="http://localhost/CNPM/Websiteqldtt/cart.php";
    </script>';
?>