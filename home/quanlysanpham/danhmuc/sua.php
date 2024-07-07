<?php
    $id = $_GET["id"];
    $sql = "SELECT * FROM tbldanhmuc WHERE MADM = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqLi_fetch_array($result);
    }   
    else
    {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
    }
?>

<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" method="post" action="">
            <!-- Textbox cho MÃ Danh Mục -->
            <label for="MADM">Mã Danh Mục:</label>
            <input readonly type="text" name="MADM" id="MADM" value="<?php echo 'DM'; echo '0'; echo  $row['MADM']; ?> "><br>

            <!-- Textbox cho Tên Danh Mục  -->
            <label for="TENDM">Tên Danh Mục:</label>
            <input readonly type="text" name="TENDM" id="TENDM" oninput="generateShortName()" value="<?php echo $row['TENDM']; ?> "><br>
            
            <label for="image-url">Icon đại diện:</label>
                <input type="text" name="image-url" id="image-url" placeholder="Nhập đường dẫn ảnh" value="<?php echo trim($row['IMG']); ?>">
                <div id="image-container" class="hinhanh">
                    <img width="100px" height="100px" id="displayed-image" src="" alt="Ảnh">
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const imageUrlInput = document.getElementById('image-url');
                        const displayedImage = document.getElementById('displayed-image');

                        function displayImage() {
                            const imageUrl = imageUrlInput.value;
                            if (imageUrl) {
                                displayedImage.src = imageUrl;
                                // Đặt kích thước thực tế của ảnh sau khi nó được tải
                                displayedImage.onload = function() {
                                    displayedImage.width = this.width;
                                    displayedImage.height = this.height;
                                };
                            } else {
                                
                            }
                        }

                        // Gọi hàm displayImage khi trang được tải
                        displayImage();
                        
                        // Bắt sự kiện input để cập nhật hiển thị ảnh khi có sự thay đổi trong ô textbox
                        imageUrlInput.addEventListener('input', displayImage);
                    });
                </script>

            <!-- Textbox cho Tên Rút Gọn -->
            <label for="TENVT">Tên Rút Gọn:</label>
            <input type="text" name="TENVT" id="TENVT" value="<?php echo $row['TENVT']; ?> "><br>

            <!-- Sử dụng thẻ <button> để tạo nút Gửi -->
            <button class="AlertButton" type="submit" name="submit">Lưu</button>

            <!-- Sử dụng thẻ <button> để tạo nút quay lại -->
            <a href="home.php?page_layout=danhmuc" class="AlertButton">Quay lại</a>
        </form>
    </div>
</div>


    <?php
    if (isset($_POST["submit"])) 
    {
        $MADM = $id;
        $TENDM = $_POST["TENDM"];
        $TENVT = $_POST["TENVT"];
        $IMG = $_POST["image-url"];

        $sql ="UPDATE `tbldanhmuc` SET `TENDM`='$TENDM',`TENVT`='$TENVT',`IMG`='$IMG' WHERE `MADM` = '$MADM' ";

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
            echo ' window.location.href = "home.php?page_layout=danhmuc";';
            echo '</script>'; 
        } 
    }
    ?>

    <script>
        function generateShortName() {
            const fullNameInput = document.getElementById('TENDM');
            const shortNameInput = document.getElementById('TENVT');

            // Lấy giá trị từ "Tên Danh Mục" và tạo "Tên Rút Gọn"
            const fullName = fullNameInput.value;
            let shortName = '';

            if (fullName) {
                // Tách các từ bằng dấu cách
                const words = fullName.split(' ');

                // Lấy chữ cái đầu của mỗi từ và viết hoa
                shortName = words.map(word => word.charAt(0).toUpperCase()).join('');
            }

            // Đặt giá trị cho "Tên Rút Gọn"
            shortNameInput.value = shortName;
        }
    </script>
</body>
</html>