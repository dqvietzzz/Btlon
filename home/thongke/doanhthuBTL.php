<?php
    $today1 = date('Y-m-d');
    $today = date('d-m-Y');
?>
<div><h1 style="text-align: center;">BÁO CÁO DOANH THU</h1></div>
<div style="display: flex;">
<form method="post">
<h3 style="margin-left:70px">
    <label for="ngayChon">Lọc:</label>
    <input type="date" id="ngayChon" name="ngayChon">
    <button type="submit" name="submit">Xác nhận</button>
</h3>
</form>
    <form method="post" action="doanhthuBTL.php">
        <h3 style="margin-left:8px">
            <button type="huy">Hủy</button>
        </h3>
    </form>
</div>
<div class="head">
    <div class="sanpham">
        <div>
            <p style="font-size:150%;margin:10px 0 0 10px">Sản phẩm</p>
            <div style="font-size:200%;margin:20px 0 0 20px;color:blue">
                <?php
                    if (isset($_POST['submit'])) {
                        $ngayChon = $_POST["ngayChon"];
                        $sql = " SELECT SUM(SOLUONG) AS tongsp FROM tblhoadon WHERE tblhoadon.NGAY = '$ngayChon'";
                        $qr = mysqli_query($connect, $sql);
                        $row = mysqli_fetch_assoc($qr);
                        $tongsp = $row["tongsp"];
                        if($row["tongsp"]>0){
                            echo $tongsp;
                        }
                        else {
                            echo '0';
                        }
                    }else{
                    $sql = " SELECT SUM(SOLUONG) AS tongsp FROM tblhoadon WHERE tblhoadon.NGAY = '$today1'";
                    $qr = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($qr);
                    $tongsp = $row["tongsp"];
                    if($row["tongsp"]>0){
                        echo $tongsp;
                    }
                    else {
                            echo '0';
                    }
                }
                ?>
            </div>
            <div>
                <p style="font-size:100%;margin:20px 0 0 10px">Số sản phẩm đã bán</p>
            </div>
        </div>
    </div>
    <div class="donhang">
        <div>
            <p style="font-size:150%;margin:10px 0 0 10px">Đơn hàng</p>
            <div style="font-size:200%;margin:20px 0 0 20px;color:blue">
                <?php
                    if (isset($_POST['submit'])) {
                        $ngayChon = $_POST["ngayChon"];
                        $sql = " SELECT SUM(SOLUONG) AS tongdh FROM tblhoadon WHERE tblhoadon.NGAY = '$ngayChon'";
                        $qr = mysqli_query($connect, $sql);
                        $row = mysqli_fetch_assoc($qr);
                        $tongdh = $row["tongdh"];
                        if($row["tongdh"]>0){
                            echo $tongdh;
                        }
                        else {
                                echo '0';
                        }
                    }else{
                    $sql = " SELECT COUNT(*) AS tongdh FROM tblhoadon WHERE tblhoadon.NGAY = '$today1'";
                    $qr = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_assoc($qr);
                    $tongdh = $row["tongdh"];
                    if($row["tongdh"]>0){
                        echo $tongdh;
                    }
                    else {
                            echo '0';
                    }
                    }
                ?>
            </div>
            <div>
                <p style="font-size:100%;margin:20px 0 0 10px">Đơn hàng trong ngày</p>
            </div>
        </div>
    </div>
    <div class="doanhthu">
        <div>
            <p style="font-size:150%;margin:10px 0 0 10px">Doanh thu</p>
            <div style="font-size:200%;margin:20px 0 0 20px;color:blue">
            <?php
                    if (isset($_POST['submit'])) {
                        $ngayChon = $_POST["ngayChon"];
                        $sql = " SELECT SUM(THANHTIEN) AS thanhtien FROM tblhoadon WHERE tblhoadon.NGAY = '$ngayChon'";
                        $qr = mysqli_query($connect, $sql);
                        $row = mysqli_fetch_assoc($qr);
                        $thanhtien = $row["thanhtien"];
                        if($row["thanhtien"]>0){
                            echo $thanhtien;
                        }
                        else {
                                echo '0';
                        }
                    }else{
                    $sql = " SELECT SUM(THANHTIEN) AS thanhtien FROM tblhoadon WHERE tblhoadon.NGAY = '$today1'";
                    $qr = mysqli_query($connect, $sql);
                    $row = mysqli_fetch_assoc($qr);
                    $thanhtien = $row["thanhtien"];
                    if($row["thanhtien"]>0){
                        echo $thanhtien;
                    }
                    else {
                            echo '0';
                    }
                }
                ?>
            </div>
            <div>
                <p style="font-size:100%;margin:20px 0 0 10px">Số tiền hôm nay</p>
            </div>
        </div>
    </div>
</div>
<div style=" margin: 10px 50px 30px 50px;font-size:120%">
    <b style="margin-left:70px">
            <?php
            if (isset($_POST['submit'])) {
                $ngayChon = $_POST["ngayChon"];
                $ngayChon1 = date('d-m-Y',strtotime($ngayChon));
                echo "Hóa đơn ngày:".$ngayChon1;
            }else{
            echo "Hóa đơn ngày:".$today;
            }
            ?>
    </b>
</div>
<div style="margin-left:200px">
    <table style=" border: 1px black solid;">
        <thead style="background-color: aqua;"> 
            <th style="width:70px;">STT</th>
            <th style="width:130px;">Ngày</th>
            <th style="width:100px;">Mã hóa đơn</th>
            <th style="width:150px;">Mã khách hàng</th>
            <th style="width:250px;">Tên khách hàng</th>
            <th style="width:150px;">Số điện thoại</th>
            <th style="width:150px;">Tiền</th>
        </thead>
        <tbody>
        <?php
            if (isset($_POST['submit'])) {
                $ngayChon = $_POST["ngayChon"];
                $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH WHERE tblhoadon.NGAY = '$ngayChon'";
                $qr = mysqli_query($connect, $sql);
                $count = 0;
                while ( $rows = mysqli_fetch_assoc($qr) ){
                    $count ++;
                ?>
                <tr>
                    <td> <?php echo $count; ?></td>
                    <td>
                        <?php
                            echo $ngayChon1;
                        ?>
                    </td>
                    <td>
                        <?php echo $rows["MAHD"]; ?>
                    </td>
                    <td>
                        <?php echo $rows["MAKH"]; ?>
                    </td>
                    <td>
                        <?php echo $rows["TENKH"]; ?>
                    </td>
                    <td>
                        <?php echo $rows["SDT"]; ?>
                    </td>
                    <td>
                        <?php echo $rows["THANHTIEN"]; ?>
                    </td>
                </tr>
                
                <?php }
            }else{
            $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH WHERE tblhoadon.NGAY = '$today1'";
            $qr = mysqli_query($connect, $sql);
            $count = 0;
        while ( $rows = mysqli_fetch_assoc($qr) ){
            $count ++;
        ?>
        <tr>
            <td> <?php echo $count; ?></td>
            <td>
                <?php
                    echo $today1;
                ?>
            </td>
            <td>
                <?php echo $rows["MAHD"]; ?>
            </td>
            <td>
                <?php echo $rows["MAKH"]; ?>
            </td>
            <td>
                <?php echo $rows["TENKH"]; ?>
            </td>
            <td>
                <?php echo $rows["SDT"]; ?>
            </td>
            <td>
                <?php echo $rows["THANHTIEN"]; ?>
            </td>
        </tr>
        <?php }
            }
        ?>
        </tbody>
</div>