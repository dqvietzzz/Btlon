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
    <h2>Danh Sách Tài Khoản</h2>
    <div class="center-table">
        <?php
        $Key = $_GET["search"];
        $sql = "SELECT * FROM tbltaikhoan WHERE TENDN LIKE '%" . $Key . "%'";
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
            Thêm Tài Khoản Mới
        </button>

        <button class="cn-button" onclick="window.location.href = 'home.php?page_layout=quanlytk'">
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
    echo '<th>STT</th>';
    echo '<th>Tên đăng nhập</th>';
    echo '<th>Mật Khẩu</th>';
    echo '<th>Quyền</th>';
    echo '<th></th>';
    echo '<th></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        echo '<tr>';
        echo '<td>' . $count . '</td>';
        echo '<td>' . $row['TENDN'] . '</td>';

        echo '<td>';
        echo '<input class="MK" readonly="true" type="password" value=" ' . $row['MK'] . ' ">';
        echo '</td>';

        if ($row['QUYEN'] == 0) {
            echo '<td style="color: red;">Quản lý</td>';
        } else if ($row['QUYEN'] == 1) {
            echo '<td>Nhân viên</td>';
        } else if ($row['QUYEN'] == 2) {
            echo '<td> Khách hàng </td>';
        }

        echo '<td><a><button class="sua-xoa" onclick="suaDuLieu(\'' . $row['TENDN'] . '\')">Sửa</button></a></td>';
        echo '<td><a><button class="sua-xoa" onclick="xoaDuLieu(\'' . $row['TENDN'] . '\')">Xóa</button></a></td>';
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
            window.location.href = 'qlTK/xoa.php?id=' + id;
        }
    }
</script>

<script type='text/javascript'>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu này?");
        if (xacNhan) {
            window.location.href = 'home.php?page_layout=sua_tk&id=' + id;
        }
    }
</script>


<div class="custom-alert" id="ThemAlert">
    <div class="alert-content">
        <form action="" method="post">
            <h2>CẬP NHẬP THÊM TÀI KHOẢN</h2>

            <input type="text" name="TENDN" id="TENDN" placeholder="Nhập Tên Đăng Nhập"><br>

            <input type="text" name="MK" id="MK" placeholder="Nhập Mật Khẩu"><br>
            <label for="quyen">Quyền:</label>
            <select id="quyen" name="quyen">
                <option value="0">Quản lý </option>
                <option selected value="1">Nhân viên </option>
            </select><br>

            <button type="submit" name="Them" class="AlertButton">Lưu TK</button>
            <button class="AlertButton" id="closeThemButton">Đóng</button>
        </form>
    </div>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Them"])) {
        if ($_POST["TENDN"] === "" || $_POST["MK"] == "") {
            echo "<script type='text/javascript'>
                        alert('Điền đầy đủ thông tin.')  
                        </script>";
        } else {
            $tendn = $_POST["TENDN"];
            $mk = $_POST["MK"];
            $quyen = $_POST["quyen"];

            $sql = "INSERT INTO tbltaikhoan (TENDN, MK, QUYEN) VALUES ('$tendn','$mk','$quyen')";

            $result = mysqli_query($conn, $sql);
            if ($result) {

                echo "<script type='text/javascript'>
                                alert('Cập nhập tài khoản mới thành công');
                                window.location.href = 'home.php?page_layout=quanlytk';
                            </script>";

            } else {
                echo "Lỗi cập nhật: " . mysqli_error($conn);
            }
        }
    }
}

?>

<script type='text/javascript'>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn chặn việc gửi form một cách thông thường
        var searchValue = document.getElementById('search').value;
        window.location.href = 'home.php?page_layout=tk_tk&search=' + searchValue;
    });
</script>