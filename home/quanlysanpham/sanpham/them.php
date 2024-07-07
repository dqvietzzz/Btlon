<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" method="post" action="">
            <!-- Textbox cho Tên Sản Phẩm -->
            <label for="TENSP">Tên Sản Phẩm:</label>
            <input type="text" name="TENSP" id="TENSP"><br>

            <!-- Textbox cho Hình Ảnh -->
            <label for="image-url">Hình ảnh sản phẩm:</label>
            <input type="text" name="image-url" id="image-url" placeholder="Nhập đường dẫn ảnh" >
            <div id="image-container" class="hinhanh">
                <img id="displayed-image" class="img" src="" alt="Yêu Cầu Thêm Hinh Ảnh Sản Phẩm">
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

            <!-- Combobox cho Loại Sản Phẩm -->
            <label for="DANHMUC">Loại Sản Phẩm:</label>
            <select name="DANHMUC" id="DANHMUC" style="width: 40.8vw; ">
            
                <?php
                    $sql = "SELECT TENDM FROM `tbldanhmuc`";
                    $result = mysqli_query($conn, $sql);
                    echo '<option value= "">chọn loại sản phẩm</option>';
                    while ($rows = mysqli_fetch_array($result)) 
                    {
                        echo '<option value= "' . $rows['TENDM'] . '">' . $rows['TENDM'] . '</option>';
                    }
                ?>
            </select><br>

            
            <!-- Textbox cho Giá Thành -->
            <label for="GIA">Giá Bán:</label>
            <input type="text" name="GIA" id="GIA" oninput="formatCurrency(this);" title="Chỉ nhập số ở định dạng không dùng unikey ">
            <br>

            <script>
                function formatCurrency(input) {
                    let value = input.value.replace(/,/g, ''); // Loại bỏ dấu phẩy cũ nếu có    
                    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); // Định dạng giá thành với dấu phẩy sau mỗi ba chữ số
                    input.value = value; // Cập nhật giá trị vào ô input
                    console.log("value:" + value);
                }
            </script>


            <!-- Combobox cho Nhà Cung Cấp -->
            <label for="NCC">Nhà Cung Cấp:</label>
            <select name="NCC" id="NCC" style="width: 40.8vw; ">
                <?php
                    $sql = "SELECT TenNCC FROM `tblncc`";
                    $result = mysqli_query($conn, $sql);
                    echo '<option value= "">chọn nhà cung cấp</option>';
                    while ($rows = mysqli_fetch_array($result)) 
                    {
                        echo '<option value= "' . $rows['TenNCC'] . '">' . $rows['TenNCC'] . '</option>';
                    }
                ?>
            </select><br>

            <!-- Sử dụng thẻ <button> để tạo nút Gửi -->
            <button class="AlertButton" type="submit" name="submit">Lưu</button>

            <!-- Sử dụng thẻ <button> để tạo nút quay lại -->
            <a href="home.php?page_layout=sanpham" class="AlertButton">Quay lại</a>
        </form>
    </div>
</div>

    
<?php
    // Kiểm tra xem nút đã được ấn chưa
    if (isset($_POST["submit"]) && !empty($_POST)) 
    {
        $TENSP = $_POST["TENSP"];
        $IMG = $_POST["image-url"];
        $DANHMUC = $_POST["DANHMUC"];
        $GIA = $_POST["GIA"];
        $NCC = $_POST["NCC"];
        if (empty($TENSP) || empty($IMG) || empty($DANHMUC) || empty($GIA) || empty($NCC)) 
        {
            echo '<script type = "text/javascript">';
            echo ' alert("Mời nhập đủ thông tin yêu cầu") ';
            echo '</script>';
        }
        else
        {
            $GIA = str_replace(',', '', $GIA);
            $sql = "INSERT INTO `tblsanpham`(`TENSP`, `IMG`, `DANHMUC`, `GIA`, `NCC`) VALUES ('$TENSP','$IMG','$DANHMUC','$GIA','$NCC')";

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