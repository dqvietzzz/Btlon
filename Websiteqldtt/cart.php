<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
</head>
<link rel="stylesheet" href="cart.css">

<body>
    <button onclick="redirectToHomePage()" class="backtohome">Quay về trang chủ </button>
    <div class="deleteAll" id="deleteAllButton">Xóa toàn bộ</div>
    <div class="submit">
        <div class="number">
            <label for="">Sđt: </label>
            <div class="numberContent">
                <?php
                require "connect.php";
                session_start();
                $username = $_SESSION['username'];
                $qrMAKH = "Select SDT from tblkhachhang where TENDN = '".$username."'";
                $resultMAKH = mysqli_query($connect,$qrMAKH);
                $rowMAKH = mysqli_fetch_array($resultMAKH);
                echo $rowMAKH[0];
              

                ?>
            </div>
        </div>
        <div class="timesubmit">
            <label for="" style="margin-right: 10px;">Ngày mua: </label>
            <div id="time"></div>
        </div>
        <div class="address">
            <label for="">Địa chỉ </label>
            <div class="addressContent">
                <?php
            
          
                $username = $_SESSION['username'];
                $qrMAKH = "Select DIACHI from tblkhachhang where TENDN = '".$username."'";
                $resultMAKH = mysqli_query($connect,$qrMAKH);
                $rowMAKH = mysqli_fetch_array($resultMAKH);
                echo $rowMAKH[0];
              

                ?>
            </div>

        </div>
        <div class="count">
            <label for="">Số sản phẩm: </label>
            <div class="countItem">
                <?php
                    if(isset($_SESSION['cart'])) {
                        $soLuongSanPham = count($_SESSION['cart']);
                        echo $soLuongSanPham;
                    } else {
                        echo '0';
                    }  
                ?>
            </div>
        </div>

        <div class="priceTotalSubmit">

            <label for="">Tổng tiền:</label>
            <div id="totalValue"></div> đ


        </div>
        <form action="xacnhanthanhtoan.php" method="post">
            <input type="submit" onclick="confirmPayment()" name="confirmPayment" value="Xác nhận thanh toán">
        </form>


        <div id="updateTotalButton">Cập nhật</div>


    </div>
    <div class="content">
        <table class="list-item">
            <thead class="header">
                <td>Delete</td>
                <td>Image</td>
                <td>Product</td>
                <td>Price</td>


            </thead>
            <tbody>
                <?php
                    require "connect.php";

                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $product) {

                            $masp = $product['MASP'];

                            $query = "SELECT * FROM tblsanpham WHERE    MASP = '$masp'";
                            $result = mysqli_query($connect, $query);

                            if ($result) {

                                $row = mysqli_fetch_array($result);
                            
                ?>
                <tr class="item">

                    <td><?php echo '<a href="cart-delete.php/?TENSP='.$row["TENSP"].'"'?>>Xóa</a></td>
                    <td class="img"> <img src="<?php echo$row['IMG']?>" alt=""></td>
                    <td class="name"> <span><?php echo $row['TENSP']?></span></td>
                    <td class="pricerow"> <span>Giá </span><span class="price"
                            id="price"><?php echo$row['GIA']?>đ</span>
                    </td>


                </tr>

                <?php
                    }
                }
            }
            ?>
            </tbody>
        </table>



    </div>
</body>
<script type="text/javascript">
// Lấy thẻ div có id là "time"
var timeElement = document.getElementById('time');

var currentDate = new Date();

var dateString = currentDate.toLocaleDateString();


timeElement.innerText = dateString;

function confirmPayment() {

    var confirmSubmit = confirm("Bạn có chắc chắn muốn xác nhận thanh toán?");

    if (confirmSubmit) {
        return true;
    } else {

        return false;
    }
}

var deleteAllButton = document.getElementById('deleteAllButton');


deleteAllButton.addEventListener('click', function() {

    var confirmDelete = confirm("Bạn có chắc chắn muốn xóa toàn bộ dữ liệu không?");


    if (confirmDelete) {

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_all.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {

                console.log(xhr.responseText);
            } else {
                console.error('Lỗi trong quá trình xóa dữ liệu.');
            }
        };
        xhr.send('deleteAll=true');
    }
    location.reload();
});


document.getElementById('updateTotalButton').addEventListener('click', function() {
    location.reload();
});
var total = parseInt(localStorage.getItem('total')) || 0;
var priceElements = document.querySelectorAll('.price');
var updateTotalButton = document.getElementById('updateTotalButton');
var totalValue = document.getElementById('totalValue');
totalValue.innerText = total;
updateTotalButton.addEventListener('click', function() {
    total = 0;
    priceElements.forEach(function(element) {
        var price = parseFloat(element.innerText.replace(/,/g, ''));
        total += price;
    });
    totalValue.innerText = total;
    localStorage.setItem('total', total.toString());
});

function redirectToHomePage() {
    window.location.href = 'Sell_index.php';
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