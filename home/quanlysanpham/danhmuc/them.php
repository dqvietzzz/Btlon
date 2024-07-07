<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" method="post" action="">
            <!-- Textbox cho Tên danh mục -->
            <label for="TENDM">Tên Danh Mục:</label>
            <input type="text" name="TENDM" id="TENDM" oninput="generateShortName()"><br>

            <!-- Textbox cho Hình Ảnh -->
            <label for="image-url">Icon đại diện:</label>
            <input type="text" name="image-url" id="image-url" placeholder="Nhập đường dẫn ảnh" >
            <div id="image-container" class="hinhanh">
                <img id="displayed-image" src="" alt="Yêu Cầu Thêm Icon đại diện">
            </div>

            <!-- Sửa đoạn script để kiểm tra và hiển thị ảnh khi trang được tải -->
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
            <br>
            
        
            <!-- Textbox cho Tên rút gọn -->
            <label for="TENVT">Tên Rút Gọn:</label>
            <input type="text" name="TENVT" id="TENVT"><br>


            <!-- Sử dụng thẻ <button> để tạo nút Gửi -->
            <button class="AlertButton" type="submit" name="submit">Lưu</button>

            <!-- Sử dụng thẻ <button> để tạo nút quay lại -->
            <a href="home.php?page_layout=danhmuc" class="AlertButton">Quay lại</a>
        </form>
    </div>
</div>

    <?php
        // Kiểm tra xem nút đã được ấn chưa
        if (isset($_POST["submit"]) && !empty($_POST)) 
        {
            $TENDM = $_POST["TENDM"];
            $TENVT = $_POST["TENVT"];
            $IMG = $_POST["image-url"];
            if (!preg_match('/[a-zA-Z]/', $TENDM)) 
            {
                echo '<script type = "text/javascript">';
                echo ' alert("Mời nhập đủ thông tin yêu cầu") ';
                echo '</script>';

            }
            else
            {
                $sql = "INSERT INTO `tbldanhmuc`(`TENDM`, `TENVT`, `IMG`) VALUES ('$TENDM','$TENVT','$IMG')";

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

