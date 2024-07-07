<?php
$id = $_GET["id"];
$sql = "SELECT * FROM tblkhachhang WHERE MAKH = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $TenDN = $row["TENDN"];
    $HoTen = $row["TENKH"];
    $Diachi = $row["DIACHI"];
    $SDT = $row["SDT"];

} else {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>
<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" action="" method="post">
            <h2>CẬP NHẬP THÔNG TIN KHÁCH HÀNG:
                <?php echo $id ?>
            </h2>
            <table class=tbl1>
                <tr>
                    <td><label for="HoTen">Họ tên: </label></td>
                    <td><input type="text" name="HoTen" id="HoTen" placeholder="Nhập họ tên khách hàng"
                            value="<?php echo $HoTen ?>"><br></td>
                </tr>
                <tr>
                    <td><label for="Diachi">Địa chỉ: </label></td>
                    <td><input type="text" name="Diachi" id="Diachi" placeholder="Nhập Địa chỉ"
                            value="<?php echo $Diachi ?>"><br></td>
                </tr>
                <tr>
                    <td><label for="SDT">SĐT:</label></td>
                    <td><input type="text" name="SDT" id="SDT" placeholder="Nhập SĐT" value="<?php echo $SDT ?>"><br></td>
                </tr>

            </table>
            <a class="AlertButton" href="http://localhost/CNPM/home/home.php?page_layout=quanlykh">Quay lại</a>
            <button type="submit" name="Sua" class="AlertButton">Cập Nhập</button>

        </form>
        <!-- <button class="AlertButton" onclick="DK()">Đăng ký tài khoản</button> -->
    </div>
</div>


<?php
if (isset($_POST["Sua"])) {
    $ID = $_GET["id"];
    $Ten = $_POST["HoTen"];
    $Diachi = $_POST["Diachi"];
    $SDT = $_POST["SDT"];
    if ($_POST["HoTen"] === "" || $_POST["Diachi"] == "" || $_POST["SDT"] == "") {
        echo "<script type='text/javascript'>
                    alert('Điền đầy đủ thông tin.')  
                    </script>";
    }else{
        if (is_numeric($SDT)) {
            $updateSql = "UPDATE tblkhachhang SET TENKH = '$Ten', DIACHI = '$Diachi', SDT = '$SDT' WHERE MAKH= '$ID'";
            $result = mysqli_query($conn, $updateSql);
            if ($result) {
                echo "Cập nhật thành công!";
                echo "<script type='text/javascript'>alert('Cập nhập thành công')
                                    window.location.href='home.php?page_layout=quanlykh';
                                </script>";
            } else {
                echo "Lỗi cập nhật: " . mysqli_error($conn);
            }
        } else {
            echo "<script type='text/javascript'>
                                alert('SĐT phải nhập số.');
                            </script>";
        }
    }
}
?>