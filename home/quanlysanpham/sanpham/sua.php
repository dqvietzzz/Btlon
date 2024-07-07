<?php
    $id = $_GET["id"];
    $sql = "SELECT * FROM tblsanpham WHERE MASP = $id";
    $result = mysqli_query($conn, $sql); 
    if ($result) {
        $row = mysqLi_fetch_array($result);
    } else{
        echo 'ket noi that bai';
    }
?>

<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" method="post" action="">
            <?php
                $TenDM = $row['DANHMUC'];
                $sql = "SELECT TenVT FROM tbldanhmuc WHERE TenDM = '$TenDM' ";
                $ketqua = mysqli_query($conn, $sql);
                $DANHMUC = mysqli_fetch_array($ketqua);
            ?>
                
            <!-- Textbox cho Mã Sản Phẩm -->
            <label for="MASP">Mã Sản Phẩm:</label>
            <input readonly type="text" name="MASP" id="MASP" value="<?php echo $DANHMUC['TenVT']; echo '0';  echo $row['MASP']; ?> "><br>

            <!-- Textbox cho Tên Sản Phẩm -->
            <label for="TENSP">Tên Sản Phẩm:</label>
            <input type="text" name="TENSP" id="TENSP" value="<?php echo $row['TENSP']; ?> "><br>

            <!-- Textbox cho Hình Ảnh -->
            <label for="image-url">Hình ảnh sản phẩm:</label>
            <input type="text" name="image-url" id="image-url" placeholder="Nhập đường dẫn ảnh" value="<?php echo trim($row['IMG']); ?>">
            <div id="image-container" class="hinhanh">
                <img class="img" id="displayed-image" src="" alt="Ảnh">
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

            <!-- Combobox cho Loại Sản Phẩm -->
            <label for="DANHMUC">Danh Mục:</label>
            <select name="DANHMUC" id="DANHMUC" style="width: 40.8vw; ">
            
                <?php
                    $sql = "SELECT TENDM FROM `tbldanhmuc`";
                    $result = mysqli_query($conn, $sql);
                    while ($rows = mysqli_fetch_array($result)) 
                    {
                        $selected = ($row['DANHMUC'] == $rows['TENDM']) ? 'selected' : '';
                        echo '<option value="' . $rows['TENDM'] . '" ' . $selected . '>' . $rows['TENDM'] . '</option>';
                    }
                ?>
            </select><br>

            
            <label for="GIA">Giá Thành:</label>
            <input type="text" name="GIA" id="GIA" oninput="formatCurrency(this);" value="<?php echo number_format($row['GIA']); ?>">
            <script>
                function formatCurrency(input) {
                    let value = input.value.replace(/,/g, ''); // Loại bỏ dấu phẩy cũ nếu có
                    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); // Định dạng giá thành với dấu phẩy sau mỗi ba chữ số      
                    input.value = value; // Cập nhật giá trị vào ô input
                }
            </script><br>



            <!-- Combobox cho Nhà Cung Cấp -->
            <label for="NCC">Nhà Cung Cấp:</label>
            <select name="NCC" id="NCC" style="width: 40.8vw; ">
                <?php
                    $sql = "SELECT TENNCC FROM `tblncc`";
                    $result = mysqli_query($conn, $sql);
                    echo '<option value= "">chọn nhà cung cấp</option>';
                    while ($rows = mysqli_fetch_array($result)) 
                    {
                        $selected = ($row['NCC'] == $rows['TENNCC']) ? 'selected' : '';
                        echo '<option value="' . $rows['TENNCC'] . '" ' . $selected . '>' . $rows['TENNCC'] . '</option>';
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
    if (isset($_POST["submit"])) 
    {
        $MASP = $id;
        $TENSP = $_POST["TENSP"];
        $IMG = $_POST["image-url"];
        $DANHMUC = $_POST["DANHMUC"];
        $GIA = $_POST["GIA"];
        $NCC = $_POST["NCC"];
        
        $GIA = str_replace(',', '', $GIA);
        $sql ="UPDATE `tblsanpham` SET `TENSP`='$TENSP',`IMG`='$IMG',`DANHMUC`='$DANHMUC',`GIA`='$GIA',`NCC`='$NCC' WHERE `MASP` = '$MASP' ";

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
            echo ' window.location.href = "home.php?page_layout=sanpham";';
            echo '</script>'; 
        } 
    }
?>