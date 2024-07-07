<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chi tiết sản phẩm</title>
    <link rel="stylesheet" href="chitietsanpham.css">
</head>

<body>
    <div class="main-header--top">
        <div class="content">
            <div class="logo">
                <img src="https://utt.edu.vn/home/images/stories/logo-utt-border.png" alt="" class="logo">
            </div>

            <div class="search">
                <input type="text" placeholder="Bạn cần tìm gì ?">
                <img src="img/211817_search_strong_icon.png" alt="">
            </div>
            <div class="contact">
                <a href="https://www.facebook.com/viet.dang.7146557">Liên hệ</a>
            </div>
            <div class="cart">
                <img src="img/216477_shopping_cart_icon (1).png" alt="">
                <div class="cart-countItem">
                    <?php
                        if(isset($_SESSION['cart'])) {
                            $soLuongSanPham = count($_SESSION['cart']);
                            echo $soLuongSanPham;
                        } else {
                            echo '0';
                        }        
                    ?>
                </div>
                <a href="cart.php">Giỏ hàng </a>
            </div>
            <div class="login">
                <img src="img/4092564_profile_about_mobile ui_user_icon.png" alt="">
                <a href="" class="login"> Đăng nhập</a>
                <div class="form_login">
                    <div class="triangle"></div>
                    <div class="txtHi">Xin chào, vui lòng đăng nhập</div>
                    <button class="btn_login" onclick="redirectToHome()">Đăng Nhập</button>
                    <button class="btn_signin">Đăng Kí</button>
                </div>

            </div>


        </div>
    </div>
    <button onclick="redirectToHomePage()" class="backtohome">Quay về trang chủ </button>
    <div class="item">
        <?php
            require "connect.php";
            if (isset($_GET['MASP'])) {
                $masp = $_GET['MASP'];
            }
            $qr = "Select * from tblsanpham where MASP = '".$masp."'";
            $result = mysqli_query ($connect,$qr);
            while ($row = mysqli_fetch_array($result)){
            ?>
        <img src="<?php echo $row['IMG']?>" alt="" class="">
        <div class="content">
            <div class="title "> <?php  echo$row['TENSP']?></div>
            <div class="danhmuc">Danh mục: <?php echo$row['DANHMUC']?></div>
            <div class="gia">Giá: <?php echo$row['GIA']?>đ</div>
            <div class="ncc">Hãng <?php echo$row['NCC']?></div>
            <form method="POST" id="cartForm">
                <input type="hidden" name="item_cart" value="<?php echo $row['MASP'] ?>">
                <button class="item-add" type="submit">Thêm vào giỏ hàng</button>
            </form>
            <?php
                if(isset($_POST['item_cart'])){
                    if($_SERVER["REQUEST_METHOD"] == "POST"  ){
                        $masp = $_POST['item_cart'];

                        if (!isset($_SESSION['cart'])) {
                            $_SESSION['cart'] = array();
                        }

                        $existingProduct = false;
                        foreach ($_SESSION['cart'] as $product) {
                            if ($product['MASP'] == $masp) {
                                $existingProduct = true;
                                break;
                            }
                        }

                        if ($existingProduct) {
                            echo '<script>alert("Sản phẩm này đã có sẵn trong giỏ hàng.");</script>';
                        } else {
                            // Thêm thông tin sản phẩm vào biến session
                            $productInfo = array(
                                'MASP' => $masp
                            );

                            $_SESSION['cart'][] = $productInfo;

                            echo '<script>alert("Sản phẩm đã được thêm vào giỏ hàng.");</script>';
                        }
                    }
                }
            ?>
        </div>
        <?php
            }
        ?>
    </div>
</body>
<script>
function redirectToHomePage() {
    window.location.href = 'sell_index.php';
}

function updateTotal(element) {
    var quantityInput = element.closest('.item').querySelector('.quanity input');
    var priceElement = element.closest('.item').querySelector('.price .price');
    var totalElement = element.closest('.item').querySelector('.total');

    if (quantityInput && priceElement && totalElement) {
        var quantity = parseInt(quantityInput.value);
        var price = parseFloat(priceElement.innerText);
        var total = quantity * price;

        totalElement.innerText = total;
    }
}
</script>

</html>