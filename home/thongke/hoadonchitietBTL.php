<style>
    .center-table {
        position: absolute;
        left: 4.375vw;
        top:2.75vh;
        bottom: 2.5vh;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        width: 50%;
        overflow: auto;
    }
    .thongtin{
        margin: 20px;
        width: 40%;
        display: flex;
        height: 6vw;
        font-size: 20px;
        padding: 5px 5px;
        line-height: 16px;
    }
    .tt{
        width: auto;
        margin-right: 10px;
    }
    .tt1{
        margin: 10px;
    }

</style>
<?php
    if (isset($_GET["mahd"])) {
        $mahd = $_GET["mahd"];
        $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH WHERE MAHD='$mahd' ";
        $qr = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($qr);
        $mahd=$rows["MAHD"];
        $ngay=$rows["NGAY"];
        $tenkh=$rows["TENKH"];
        $makh=$rows["MAKH"];
        $sdt=$rows["SDT"];
        $tongtien = $rows["THANHTIEN"];
    }
?>
<h2 style="margin: 20px">HÓA ĐƠN CHI TIẾT</h2>
<div class="thongtin">
    <div class="tt">
        <div>
            <div class="tt1">Tên khách hàng: <?php echo $rows["TENKH"]; ?></div>
            <div class="tt1">SĐT: <?php echo $rows["SDT"]; ?></div>
            <div class="tt1">Mã KH: <?php echo $rows["MAKH"]; ?></div>
        </div>
    </div>

    <div class="tt">
        <div class="tt1">Mã hóa đơn: <?php echo $rows["MAHD"]; ?></div>
        <div class="tt1">Ngày:
            <?php 
                $date = $rows["NGAY"];
                $date1 = date('d-m-Y',strtotime($date));
                echo $date1;
            ?>
        </div>
    </div>
</div>
<div class="main">      
    <div class="center-table">
        <table>
            <thead>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Đơn vị</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </thead>
            <tbody>
                <?php
                    $sql = " SELECT tbldonhang.MAHD, tbldonhang.MASP, tblsanpham.TENSP, tblsanpham.GIA FROM tbldonhang JOIN tblsanpham ON tbldonhang.MASP = tblsanpham.MASP WHERE tbldonhang.MAHD = '$mahd'";
                    $qr = mysqli_query($conn, $sql);
                    $count = 0;
                    while ( $rows = mysqli_fetch_assoc($qr) ){
                        $count ++;
                    ?>
                    <tr>
                        <td> <?php echo $count; ?></td>
                        <td> <?php echo $rows["TENSP"]; ?></td>
                        <td> <?php echo "Chiếc"; ?></td>
                        <td> <?php echo '1'; ?></td>
                        <td> <?php echo ($rows["GIA"]); ?></td>
                        <td> <?php echo $rows["GIA"]; ?></td>
                    </tr>
                    <?php
                    }
                ?>
            </tbody>

        </table>
        <h3>Tổng tiền:<?php echo $tongtien ?></h3>
    </div>
    <?php
        $url = "thongke/xacnhan.php?mahd=" . $_GET['mahd'];
    ?>
    <div class="button-container">
        <button onclick="window.location.href = '<?php echo $url; ?>'" class="cn-button">
            Xác Nhận
        </button>

        <button onclick="window.location.href = 'home.php?page_layout=hoadon'" class="cn-button">
            Quay lại
        </button>
    </div>
</div>