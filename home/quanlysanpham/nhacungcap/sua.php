<?php
//ket noi database
    $id = $_GET["id"];
    $sql = "SELECT * FROM tblncc WHERE MANCC = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqLi_fetch_array($result);
    } else {
        echo 'ket noi that bai';
    } 
?>
<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" method="post" action="">

            <!-- Textbox cho Mã Nhà Cung Cấp -->
            <label for="MANCC">Mã Nhà Cung Cấp:</label>
            <input readonly type="text" name="MANCC" id="MANCC" value="<?php echo 'NCC'; echo '0';  echo $row['MANCC']; ?> " ><br>

            <!-- Textbox cho Tên Nhà Cung Cấp -->
            <label for="TENNCC">Tên Nhà Cung Cấp:</label>
            <input readonly type="text" name="TENNCC" id="TENNCC" value="<?php echo $row['TENNCC']; ?> " ><br>

            <!-- Textbox cho Địa Chỉ -->
            <label for="DIACHI">Địa Chỉ:</label>
            <input type="text" name="DIACHI" id="DIACHI" value="<?php echo $row['DIACHI']; ?> " ><br>

            <!-- Textbox cho Số Điện Thoại -->
            <label for="SDT">Số Điện Thoại:</label>
            <input type="text" name="SDT" id="SDT" value="<?php echo $row['SDT']; ?> " ><br>


            <!-- Sử dụng thẻ <button> để tạo nút Gửi -->
            <button class="AlertButton" type="submit" name="submit">Lưu</button>

            <!-- Sử dụng thẻ <button> để tạo nút quay lại -->
            <a href="home.php?page_layout=ncc" class="AlertButton">Quay lại</a>
        </form>
    </div>
</div>


<?php
    if (isset($_POST["submit"])) 
    {
        $MANCC = $id;
        $TENNCC = $_POST["TENNCC"];
        $DIACHI = $_POST["DIACHI"];
        $SDT = $_POST["SDT"];

        $sql ="UPDATE `tblncc` SET `TENNCC`='$TENNCC',`DIACHI`='$DIACHI',`SDT`='$SDT' WHERE `MANCC` = '$MANCC' ";

        $ketqua = mysqli_query($conn, $sql);
        
        if ($ketqua === false) {
            echo '<script type = "text/javascript">';
            echo ' alert(" cập nhật dữ liệu thất bại ") ';
            echo '</script>';

        } else {
            echo '<script type = "text/javascript">';
            echo ' alert(" cập nhật dữ liệu thành công ") ';
            echo '</script>'; 

            echo '<script type = "text/javascript">';
            echo ' window.location.href = "home.php?page_layout=ncc";';
            echo '</script>'; 
        } 
    }
?>

