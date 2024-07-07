<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" method="post" action="">
            <!-- Textbox cho Tên Nhà Cung Cấp -->
            <label for="TENNCC">Tên Nhà Cung Cấp:</label>
            <input type="text" name="TENNCC" id="TENNCC"><br>
        
            <!-- Textbox cho Địa Chỉ -->
            <label for="DIACHI">Địa Chỉ:</label>
            <input type="text" name="DIACHI" id="DIACHI"><br>

            <!-- Textbox cho Số Điện Thoại -->
            <label for="SDT">Số Điện Thoại:</label>
            <input type="text" name="SDT" id="SDT"><br>


            <!-- Sử dụng thẻ <button> để tạo nút Gửi -->
            <button class="AlertButton" type="submit" name="submit">Lưu</button>

            <!-- Sử dụng thẻ <button> để tạo nút quay lại -->
            <a href="home.php?page_layout=ncc" class="AlertButton">Quay lại</a>
        </form>
    </div>
</div>

    
    <?php
        // Kiểm tra xem nút đã được ấn chưa
        if (isset($_POST["submit"]) && !empty($_POST)) 
        {
            $TENNCC = $_POST["TENNCC"];
            $DIACHI = $_POST["DIACHI"];
            $SDT = $_POST["SDT"];
            if (!preg_match('/[a-zA-Z]/', $TENNCC)) 
            {
                echo '<script type = "text/javascript">';
                echo ' alert("Mời nhập đủ thông tin yêu cầu") ';
                echo '</script>';

            }
            else
            {
                $sql = "INSERT INTO `tblncc`(`TENNCC`, `DIACHI`, `SDT`) VALUES ('$TENNCC','$DIACHI','$SDT')";

                $result = mysqli_query($conn,$sql);

                if ($result === false) {
                    echo '<script type = "text/javascript">';
                    echo ' alert(" thêm dữ liệu thất bại ") ';
                    echo '</script>';

                } else {
                    echo '<script type = "text/javascript">';
                    echo ' alert(" thêm dữ liệu thành công ") ';
                    echo '</script>';              
                }   

                unset($_POST);
            }
        }

        
    ?>

</body>
</html>