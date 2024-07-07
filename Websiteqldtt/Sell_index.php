<?php
require "connect.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siêu thị điện máy</title>
</head>
<link rel="stylesheet" href="Sell_index.css">

<body>

    <div class="main-header--top">
        <div class="content">
            <div class="logo">
                <img src="http://utt.edu.vn/home/images/stories/logo-utt-border.png" alt="" class="logo">
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
            <div class="cart">
                <div class="cart-countItem">
                    <?php
                        $username = $_SESSION['username'];
                        $qrMAKH = "Select MAKH from tblkhachhang where TENDN = '".$username."'";
                        $resultMAKH = mysqli_query($connect,$qrMAKH);
                        $rowMAKH = mysqli_fetch_array($resultMAKH);

                        $query = "SELECT COUNT(*) FROM tbldonhang where MAKH = '". $rowMAKH[0]."'";
                        $result = mysqli_query($connect, $query);
                        if ($result) 
                            $row = mysqli_fetch_row($result);
                            $numRows = $row[0];
                            echo $numRows;                    
                    ?>
                </div>
                <a href="hoadon.php">Đơn hàng </a>
            </div>

            <?php
                echo "  <div class='login'>
                        <a href='http://localhost/CNPM/login/login.php' class='login'> Đăng Xuất</a>
                        </div>";
            ?>
        </div>
    </div>
    <div class="main-body">
        <div class="nav">
            <form action="Sell_index.php" method="POST" id="nav-search">

                <ul class="nav">
                    <li class="nav" onclick="submitForm('TENDM','All'),submitNav()" onclick>
                        <img src="https://cdn1.iconfinder.com/data/icons/akar-vol-2/24/three-line-horizontal-256.png"
                            alt="">
                        Tất cả
                        <div hidden="true" style="display: none;" id="All">
                            All</div>
                    </li>
                    <?php
                    $sql = " Select * from tbldanhmuc ";
                    $qr = mysqli_query($connect, $sql);
                    while($row = mysqli_fetch_assoc($qr)){
          
                ?>

                    <li class="nav" onclick="submitForm('TENDM','<?php echo$row['TENDM'] ?>')">
                        <img class="icon_danhmuc" src="<?php echo$row["IMG"]?>" alt="">
                        <?php
                    echo$row["TENDM"];
                    
                  
                    ?>
                        <div hidden="true" style="display: none;" id="<?php echo$row["TENDM"]?>">
                            <?php echo$row['TENDM']?></div>


                    </li>

                    <?php }
                 
                ?>

                </ul>

            </form>


        </div>

        <div class="view-item">
            <?php
                 $TENDM = "All";
                 if(isset($_POST['TENDM'])){
                    $TENDM=$_POST['TENDM'];
                 }
            
                 $tendm = trim($TENDM);
         
            
            ?>

            <div class="list-item" id="list-item">
                <?php
            
             if( $tendm === "All"){
                $sql ="SELECT * FROM tblsanpham ";

             }
             else {
                $sql ="SELECT * FROM tblsanpham WHERE DANHMUC ='".$tendm."'";
             }
               
                $qr = mysqli_query($connect, $sql);
                $numRows = mysqli_num_rows($qr);
          
                if (isset($_GET['$i'])) {
                    $page = $_GET['$i'];
               
                } else {
              
                    $page = 1;
                }
               
                    for($i = 0; $i <= (($page-1) * 8);$i++){
                        mysqli_fetch_array($qr);
                    }
       
                for($i = ($page - 1 ) * 8 + 1; $i <= ($page * 8 ); $i++){
            
                    $row = mysqli_fetch_array($qr);
                
                    if ($row) {
                ?>
                <div class="item">
                    <img src="<?php echo $row["IMG"] ?>" alt="">
                    <form method="POST" id="cartForm" action="chitietsanpham.php">
                        <div class="title" onclick="redirectToChiTietSanPham('<?php echo$row['MASP'] ?>')">
                            <?php echo $row["TENSP"] ?></div>
                    </form>
                    <div class="price">Giá: <?php echo $row["GIA"] ?>đ</div>
                    <form method="POST" id="cartForm">
                        <input type="hidden" name="item_cart" value="<?php echo $row['MASP'] ?>">
                        <button class="item-add" type="submit" onclick="submitCart()">Thêm vào giỏ hàng</button>
                    </form>
                </div>
                <?php 
                 } else {
                  
                    break;
                }

                }
            ?>
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

                            echo '<script>alert("Sản phẩm đã được thêm vào giỏ hàng.");    
                            </script>';
                        }
                    }
                }
            ?>
            </div>
            <ul class="pagination" id="pagination">
                <!-- Thanh điều hướng trang sẽ được thêm vào đây bằng JavaScript -->
            </ul>
        </div>
    </div>
</body>
<script>
function redirectToChiTietSanPham(masp) {
    window.location.href = 'chitietsanpham.php?MASP=' + encodeURIComponent(masp);
}

function submitCart() {
    document.getElementById("nav-search").onsubmit = function(event) {
        event.preventDefault();
        alert("Thêm vào giỏ hàng thành công ");
    };


    document.getElementById("cartForm").submit();
}

function submitNav() {
    document.getElementById("cartForm").onsubmit = function(event) {
        event.preventDefault();
    };
    document.getElementById("nav-search").submit();
}

function redirectToHome() {
    window.location.href = 'http://localhost/Websiteqldtt/home/home.php';
}

function submitForm(inputName, id) {
    var inputValue = document.getElementById(id);
    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("name", "TENDM");
    hiddenInput.setAttribute("value", inputValue.innerText);
    document.getElementById("nav-search").appendChild(hiddenInput);
    document.getElementById("nav-search").submit();

}
const maxLength = 40;
const arrTitle = document.getElementsByClassName("title");
for (let i = 0; i < arrTitle.length; i++) {
    const div = arrTitle[i];
    const text = div.innerText;

    if (text.length > maxLength) {
        const truncatedText = text.slice(0, maxLength - 3) + "...";
        div.innerText = truncatedText;
    }
}
var totalProducts =
    <?php
 if( $tendm === "All"){
                $sql ="SELECT * FROM tblsanpham ";

             }
             else {
                $sql ="SELECT * FROM tblsanpham WHERE DANHMUC ='".$tendm."'";
             }
               
                $qr = mysqli_query($connect, $sql);
                echo $numRows = mysqli_num_rows($qr);
?>;
const productsPerPage = 8;
const totalPages = Math.ceil(totalProducts / productsPerPage);

function addProductToPage(page) {
    var productsContainer = document.getElementById("list-item");

    productsContainer.innerHTML = "";
    for (let i = (page - 1) * productsPerPage + 1; i <= page * productsPerPage; i++) {
        if (i > totalProducts) break;
        const product = document.createElement("div");

        product.classList.add("item");
        product.innerHTML = ``;
        productsContainer.appendChild(product);
    }
    var newURL = "http://localhost/CNPM/Websiteqldtt/Sell_index.php" + "?$i=" + page;


    window.location.href = newURL;
}

function createPagination() {
    const paginationContainer = document.getElementById("pagination");
    for (let page = 1; page <= totalPages; page++) {
        const listItem = document.createElement("li");
        listItem.innerHTML = `<a href="#" onclick="addProductToPage(${page});">${page}</a>`;

        paginationContainer.appendChild(listItem);
    }
}
createPagination();
</script>


</html>