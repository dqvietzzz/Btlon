<?php
    session_start(); // Bắt đầu hoặc kết nối với phiên

    $masp_to_remove = $_GET['MASP'];

    if(isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['TENSP'] == $masp_to_remove) {
                unset($_SESSION['cart'][$key]);
                echo '<script>alert("Sản phẩm ' . $masp_to_remove . ' đã được xóa khỏi giỏ hàng.");
                window.location.href="http://localhost/CNPM/Websiteqldtt/cart.php";
                </script>';
                break;
            }
        }
    }
?>