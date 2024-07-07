
    <script lang="javascript">
        function On(){
            var DIV = document.getElementById("menu-icon");
            DIV.style.display = "block";
        }

        function Off(){
            var DIV = document.getElementById("menu-icon");
            DIV.style.display = "none";
        }

        document.addEventListener("DOMContentLoaded", function () {
            var showAlertButton = document.getElementById("showAlertButton");
            var customAlert = document.getElementById("customAlert");
            var closeAlertButton = document.getElementById("closeAlertButton");

            showAlertButton.addEventListener("click", function () {
                customAlert.style.display = "flex";
            });

            closeAlertButton.addEventListener("click", function () {
                customAlert.style.display = "none";
            });


            var showThemButton = document.getElementById("showThemButton");
            var ThemAlert = document.getElementById("ThemAlert");
            var closeThemButton = document.getElementById("closeThemButton");

            showThemButton.addEventListener("click", function () {
                ThemAlert.style.display = "flex";
            });

            closeThemButton.addEventListener("click", function () {
                ThemAlert.style.display = "none";
            });
        });

    </script>
              
<div class="timkiem">
    <form method="get" action="timkiem.php">
        <input type="text" name="search" id="search" placeholder="Tìm Kiếm: Nhập tên nhân viên cần tìm">
        <button type="submit"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz26pdq41lB9tCSmOLh1CD3r0bxzyFdBQVCg&usqp=CAU"></button>
    </form>
</div>

<div class="main">
    <h2>Danh Sách Nhân Sự</h2>
    <div class="center-table">
        <?php
            $sql = "SELECT * FROM tblnhanvien";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0){
                createTable($result);
            } else {
                echo 'Danh sách trống.';
            }
        ?>
    </div>
    <div class="button-container">
        <button class="cn-button" id="showThemButton">
            Thêm Nhân Viên Mới
        </button>

        <button onclick="window.location.href = 'home.php'" class="cn-button" >
            HOME
        </button>
    </div>
</div>
            
                
<?php
    function createTable($result) 
    {
        echo '<table>' ;
            echo '<thead class="custom-class">';
            echo    '<tr>';
            echo       '<th>Mã NV</th>';
            echo       '<th>Tên nhân viên</th>';
            echo       '<th>Giới tính</th>';
            echo       '<th>Ngày sinh</th>';
            echo       '<th>Địa chỉ</th>';
            echo       '<th>SĐT</th>';
            echo       '<th>Chức vụ</th>';
            echo       '<th></th>';
            echo       '<th></th>';
            echo    '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_assoc($result)){
                echo '<tr>' ;
                echo    '<td>' . $row['MANV'] . '</td>' ;
                echo    '<td>' . $row['TENNV'] . '</td>' ;
                
                if($row['SEX'] == 0){
                    echo    '<td>Nam</td>' ;
                }else if($row['SEX'] == 1){
                    echo    '<td>Nữ</td>' ;
                }

                echo '<td>'; 
                    $ngaySinhMoi = date("d-m-Y", strtotime($row['NGAYSINH']));
                    echo $ngaySinhMoi;
                echo '</td>' ;
                
                echo    '<td>' . $row['DIACHI'] . '</td>' ;
                echo    '<td>' . $row['SDT'] . '</td>' ;
                
                if($row['CHUCVU'] == 0){
                    echo    '<td>Quản lý</td>' ;
                }else if($row['CHUCVU'] == 1){
                    echo    '<td>Nhân viên</td>' ;
                }
                echo    '<td><a><button class="sua-xoa" onclick="suaDuLieu(\'' . $row['MANV'] . '\')">Sửa</button></a></td>';
                echo    '<td><a><button class="sua-xoa" onclick="xoaDuLieu(\'' . $row['MANV'] . '\')">Xóa</button></a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
    }
?>


<script type='text/javascript'>
    function xoaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn xóa dữ liệu này?");
        if (xacNhan) {
            // Gửi yêu cầu xóa đến trang xử lý PHP
            alert("Xóa thành công");
            window.location.href = 'qlNhanSu/xoa.php?id='+id;
        }
    }
</script>

<script type='text/javascript'>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu này?");
        if (xacNhan) {
            window.location.href = 'home.php?page_layout=sua_nv&id='+id;
        }
    }
</script>

    
    <div class="custom-alert" id="ThemAlert">
        <div class="alert-content">
            <form action="" method="post">
                <h2>CẬP NHẬP THÊM NHÂN VIÊN</h2>
                
                <input type="text" name="HoTen" id="HoTen" placeholder="Nhập họ tên Nhân viên"><br>

                <input type="date" name="Ngaysinh" id="Ngaysinh"><br>

                <label  for="GioiTinh">Giới Tính: </label>
                <label class="sex" for="nam">Nam</label>
                <input class="sex" type="radio" id="nam" name="GioiTinh" checked value=0> 
                <label class="sex" for="nu">Nữ</label>
                <input class="sex" type="radio" id="nu" name="GioiTinh" value=1><br>
                
                <input type="text" name="Diachi" id="Diachi" placeholder="Nhập Địa chỉ"><br>

                <input type="text" name="SDT" id="SDT" placeholder="Nhập SĐT"><br>

                <label for="cv">Chức vụ:</label>
                <select id="cv" name="cv">
                    <option selected value="0">Quản lý </option>
                    <option selected value="1">Nhân viên </option>
                </select> <br>

                <button type="submit" name="Them" class="AlertButton" >Lưu NV</button>
                <button class="AlertButton" id="closeThemButton">Đóng</button>
            </form>
        </div>
    </div>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["Them"])){
                if($_POST["HoTen"] === "" || $_POST["Diachi"] == "" || $_POST["SDT"] == "" || $_POST["Ngaysinh"] == ""){
                    echo "<script type='text/javascript'>
                        alert('Điền đầy đủ thông tin.')  
                        </script>";
                }
                else{
                    $sql = "SELECT MANV FROM tblnhanvien ORDER BY MANV DESC LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // Lấy giá trị ID cuối cùng
                        $row = $result->fetch_assoc();
                        $lastID = $row["MANV"];
                        // Tách phần số từ ID cuối cùng và tăng giá trị lên 1
                        $parts = explode("-", $lastID);
                        $lastNumber = (int)$parts[1];
                        $newNumber = $lastNumber + 1;
                        $newID = "NV-" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
                    } else {
                        $newID = "NV-001";
                    }
                    
                    $HoTen =$_POST["HoTen"];
                    $Diachi = $_POST["Diachi"];
                    $SDT = $_POST["SDT"];
                    
                    $ngaysinh = $_POST['Ngaysinh'];
                    $sex = $_POST["GioiTinh"];
                    
                    $chucvu =$_POST["cv"];
    
                    if (is_numeric($SDT)) {
    
                        $sql = "INSERT INTO tblnhanvien (MANV, TENNV, DIACHI, SDT, NGAYSINH, SEX, CHUCVU) VALUES ('$newID','$HoTen','$Diachi','$SDT','$ngaysinh','$sex','$chucvu')";
    
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            
                            echo "<script type='text/javascript'>
                                    alert('Cập nhập nhân viên mới thành công');
                                    window.location.href = 'home.php?page_layout=quanlynv';
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
            }
        }
        
    ?>

    <script type='text/javascript'>
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault(); // Ngăn chặn việc gửi form một cách thông thường
            var searchValue = document.getElementById('search').value;
            window.location.href = 'home.php?page_layout=tk_nv&search=' + searchValue;
        });
    </script>
