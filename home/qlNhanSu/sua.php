<?php
    $id = $_GET["id"];
    $sql = "SELECT * FROM tblnhanvien WHERE MANV = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        $hoten = $row["TENNV"];
        $ngaysinh = $row["NGAYSINH"];
        $sex = $row["SEX"];
        $diachi = $row["DIACHI"];
        $SDT = $row["SDT"];
        $chucvu = $row["CHUCVU"];
        
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }
?>
<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" action="" method="post">
            <h2>CẬP NHẬP THÔNG TIN KHÁCH HÀNG: <?php echo $id ?></h2>
            <table class="tbl1">
                <tr>
                    <td><label for="HoTen">Họ tên:  </label></td>
                    <td><input type="text" name="HoTen" id="HoTen" placeholder="Nhập họ tên khách hàng" value="<?php echo $hoten ?>"><br></td>
                </tr>
                <tr>
                    <td><label for="ns">Ngày Sinh:</label></td>
                    <td><input type="date" name="ns" id="ns" value="<?php echo $ngaysinh; ?>"></td>
                </tr>
                
                <tr class="an">
                    <td><label  for="GioiTinh">Giới Tính: </label></td>
                    <td>
                        <label class="sex" for="nam">Nam</label>
                        <input class="sex" type="radio" id="nam" name="GioiTinh" <?php if($sex == 0) echo 'checked' ?> value=0> 
                        <label class="sex" for="nu">Nữ</label>
                        <input class="sex" type="radio" id="nu" name="GioiTinh" <?php if($sex == 1) echo 'checked' ?> value=1>
                        
                    </td>
                </tr>
                <tr>
                    <td><label for="SDT">SĐT:</label></td>
                    <td><input type="text" name="SDT" id="SDT" placeholder="Nhập SĐT" value="<?php echo $SDT ?>"></td>
                </tr>
                <tr>
                    <td><label for="diachi">Địa chỉ</label></td>
                    <td><input type="text" name="diachi" id="diachi" placeholder="Nhập Địa chỉ" value="<?php echo $diachi ?>"></td>
                </tr>
                <tr>
                    <td><label for="cv">Chức vụ:</label></td>
                    <td><select id="cv" name="cv">
                            <option <?php if($chucvu == 0) echo 'selected' ?> value="0">Quản lý </option>
                            <option <?php if($chucvu == 1) echo 'selected' ?> value="1">Nhân viên </option>
                        </select>
                    </td>
                </tr>
            </table>
            <a class="AlertButton" href="http://localhost/CNPM/home/home.php?page_layout=quanlynv">Quay lại</a>
            <button type="submit" name="Sua" class="AlertButton">Cập Nhập</button>
            
        </form>
        
    </div>
</div>

 
<?php
    if (isset($_POST["Sua"])) {
        $ID = $_GET["id"];

        $hoten = $_POST['HoTen'];
        $ngaysinh = $_POST['ns'];
        $sex = $_POST["GioiTinh"];
        $diachi = $_POST["diachi"];
        $SDT = $_POST["SDT"];
        $chucvu =$_POST["cv"];

        if (is_numeric($SDT)){
            $updateSql = "UPDATE tblnhanvien SET TENNV = '$hoten', NGAYSINH = '$ngaysinh', SEX = '$sex', DIACHI = '$diachi', SDT = '$SDT', CHUCVU = '$chucvu' WHERE MANV= '$ID'";
            $result = mysqli_query($conn, $updateSql);
            if ($result) {
                echo "Cập nhật thành công!";
                echo "<script type='text/javascript'>alert('Cập nhập thành công')
                        window.location.href='home.php?page_layout=quanlynv';
                    </script>";
            } else {
                echo "Lỗi cập nhật: " . mysqli_error($conn);
            }
        }else {
                echo"<script type='text/javascript'>
                        alert('SĐT phải nhập số.');
                    </script>";
            }
        
        
    }
?>
