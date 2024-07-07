<?php
  require "connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng</title>
    <link rel="stylesheet" href="hoadon.css">
</head>

<body>
    <div class="content">
        <button onclick="redirectToHomePage()" class="backtohome">Quay về trang chủ </button>
        <table class="list-item">
            <thead class="header">
                <td>Delete</td>
                <td>Product</td>
                <td>Price</td>
                <td>Mã hóa đơn</td>
                <td>Date</td>


            </thead>
            <tbody>
                <?php
                 session_start();
             
                $username = $_SESSION['username'];
                $qrMAKH = "Select MAKH from tblkhachhang where TENDN = '".$username."'";
                $resultMAKH = mysqli_query($connect,$qrMAKH);
                $rowMAKH = mysqli_fetch_array($resultMAKH);
              
                $qr = "Select * from tbldonhang where MAKH = '". $rowMAKH[0]."'";
                $result = mysqli_query($connect,$qr);
                while ($row = mysqli_fetch_array($result)){
                 ?>
                <tr class="item">

                    <td><?php echo '<a href="hoadon-delete.php/?MASP='.$row["MASP"].'">'?>Xóa</a></td>
                    
                    <?php
                        $query ="SELECT tbldonhang.MASP, tblsanpham.TENSP as tensp
                                FROM tbldonhang
                                JOIN tblsanpham ON tbldonhang.MASP = tblsanpham.MASP
                                WHERE tbldonhang.MADH = '".$row["MADH"]."' ";
                        $resultSP = mysqli_query($connect,$query);
                        $rowSP = mysqli_fetch_array($resultSP);
                    ?>

                    <td class="name"> <span><?php echo $rowSP['tensp']?></span></td>
                    <td class="pricerow"> <span>Giá </span><span class="price"
                            id="price"><?php echo$row['TONGTIEN']?>đ</span>
                    </td>
                    <td class="quanity"><?php echo$row['MAHD']?> </td>
                    <?php
                        $query2 ="SELECT tbldonhang.MAHD, tblhoadon.NGAY as ngay
                                FROM tbldonhang
                                JOIN tblhoadon ON tbldonhang.MAHD = tblhoadon.MAHD
                                WHERE tbldonhang.MAHD = '".$row["MAHD"]."' ";
                        $resultDT = mysqli_query($connect,$query2);
                        $rowDT = mysqli_fetch_array($resultDT);
                    ?>
                    <td class="date">
                        <?php echo$rowDT['ngay']?>
                    </td>


                </tr>


                <?php
            }
            ?>
            </tbody>
        </table>



    </div>
</body>
<script>
function redirectToHomePage() {
    window.location.href = 'Sell_index.php';
}

var dateElements = document.querySelectorAll('.date');


dateElements.forEach(function(element) {
    var originalDate = element.textContent.trim();
    var parts = originalDate.split('-');
    var newDate = parts[2] + '-' + parts[1] + '-' + parts[0];
    element.textContent = newDate;
});
</script>

</html>