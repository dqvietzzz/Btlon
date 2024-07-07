<script lang="javascript">
    function On() {
        var DIV = document.getElementById("menu-icon");
        DIV.style.display = "block";
    }

    function Off() {
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
        <input type="text" name="search" id="search" placeholder="Tìm Kiếm: Nhập tên khách hàng cần tìm">
        <button type="submit"><img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz26pdq41lB9tCSmOLh1CD3r0bxzyFdBQVCg&usqp=CAU"></button>
    </form>
</div>

<div class="main">
    <h2>Danh Sách Khách Hàng</h2>
    <div class="center-table">
        <?php
        $Key = $_GET["search"];
        $sql = "SELECT * FROM tblkhachhang WHERE TENKH LIKE '%" . $Key . "%'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            createTable($result);
        } else {
            echo 'Danh sách trống.';
        }
        ?>
    </div>
    <div class="button-container">
        <button class="cn-button" id="showThemButton">
            Thêm Khách Hàng Mới
        </button>

        <button class="cn-button" onclick="window.location.href = 'home.php?page_layout=quanlykh'">
            Trở Lại
        </button>
    </div>
</div>

<?php
function createTable($result)
{
    echo '<table>';
    echo '<thead class="custom-class">';
    echo '<tr>';
    echo '<th>Mã KH</th>';
    echo '<th>Tên khách hàng</th>';
    echo '<th>Tên đăng nhập</th>';
    echo '<th>Địa chỉ</th>';
    echo '<th>SĐT</th>';
    echo '<th></th>';
    echo '<th></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['MAKH'] . '</td>';
        echo '<td>' . $row['TENKH'] . '</td>';
        if ($row['TENDN'] == null) {
            echo '<td style="color: red;">Chưa đăng ký</td>';
        } else {
            echo '<td>' . $row['TENDN'] . '</td>';
        }
        echo '<td>' . $row['DIACHI'] . '</td>';
        echo '<td>' . $row['SDT'] . '</td>';
        echo '<td><a><button class="sua-xoa" onclick="suaDuLieu(\'' . $row['MAKH'] . '\')">Sửa</button></a></td>';
        echo '<td><a><button class="sua-xoa" onclick="xoaDuLieu(\'' . $row['MAKH'] . '\')">Xóa</button></a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>

</div>
</div>

</div>

<script type='text/javascript'>
    function xoaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn xóa dữ liệu này?");
        if (xacNhan) {
            // Gửi yêu cầu xóa đến trang xử lý PHP
            alert("Xóa thành công");
            window.location.href = 'qlKhachHang/xoa.php?id=' + id;
        }
    }
</script>

<script type='text/javascript'>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu này?");
        if (xacNhan) {
            window.location.href = 'home.php?page_layout=sua_kh&id=' + id;
        }
    }
</script>



<div class="custom-alert" id="ThemAlert">
    <div class="alert-content">
        <form action="" method="post">
            <h2>CẬP NHẬP THÊM KHÁCH HÀNG</h2>

            <input type="text" name="HoTen" id="HoTen" placeholder="Nhập họ tên khách hàng"><br>

            <input type="text" name="Diachi" id="Diachi" placeholder="Nhập Địa chỉ"><br>

            <input type="text" name="SDT" id="SDT" placeholder="Nhập SĐT"><br>

            <button type="submit" name="Them" class="AlertButton">Lưu KH</button>
            <button class="AlertButton" id="closeThemButton">Đóng</button>
        </form>
    </div>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Them"])) {
        if ($_POST["HoTen"] === "" || $_POST["Diachi"] == "" || $_POST["SDT"] == "") {
            echo "<script type='text/javascript'>
                        alert('Điền đầy đủ thông tin.')  
                        </script>";
        } else {
            $sql = "SELECT MAKH FROM tblkhachhang ORDER BY MAKH DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Lấy giá trị ID cuối cùng
                $row = $result->fetch_assoc();
                $lastID = $row["MAKH"];
                // Tách phần số từ ID cuối cùng và tăng giá trị lên 1
                $parts = explode("-", $lastID);
                $lastNumber = (int) $parts[1];
                $newNumber = $lastNumber + 1;
                $newID = "KH-" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            } else {
                $newID = "KH-001";
            }

            $HoTen = $_POST["HoTen"];
            $Diachi = $_POST["Diachi"];
            $SDT = $_POST["SDT"];

            if (is_numeric($SDT)) {

                $sql = "INSERT INTO tblKHACHHANG (MAKH, TENKH, DIACHI, SDT) VALUES ('$newID','$HoTen','$Diachi','$SDT')";

                $result = mysqli_query($conn, $sql);
                if ($result) {

                    echo "<script type='text/javascript'>
                                    alert('Cập nhập khách hàng mới thành công');
                                    window.location.href = 'qlKH.php';
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
}

?>

<script type='text/javascript'>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn chặn việc gửi form một cách thông thường
        var searchValue = document.getElementById('search').value;
        window.location.href = 'home.php?page_layout=tk_kh&search=' + searchValue;
    });
</script>
</body>

</html>