<div class="timkiem">
    <form method="get" action="timkiem.php">
        <input type="text" name="search" id="search" placeholder="Tìm Kiếm: Nhập tên nhà cung cấp cần tìm">
        <button type="submit"><img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz26pdq41lB9tCSmOLh1CD3r0bxzyFdBQVCg&usqp=CAU"></button>
    </form>
</div>

<div class="main">
    <h2>Danh Sách nhà cung cấp </h2>
    <div class="center-table">
        <?php
        // Thực hiện truy vấn SQL và lưu kết quả vào biến $result
        $sql = "SELECT * FROM `tblncc`";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            createTable($result);
        } else {
            echo 'Không tìm thấy kết quả nào';
        }
        ?>
    </div>
    <div class="button-container">
        <button class="cn-button" onclick="window.location.href = 'home.php?page_layout=them_ncc'">
            Thêm Nhà Cung Cấp Mới
        </button>
    </div>
</div>

<?php
function createTable($result)
{
    echo '<table border="1" style="border-collapse: collapse">';
    echo '<tr class="custom-class">';
    echo '<td>Mã Nhà Cung Cấp</td>';
    echo '<td>Tên Nhà Cung Cấp</td>';
    echo '<td>Địa Chỉ</td>';
    echo '<td>Số Điện Thoại</td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '</tr>';
    while ($rows = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . "NCC" . "0" . $rows['MANCC'] . '</td>';
        echo '<td>' . $rows['TENNCC'] . '</td>';
        echo '<td>' . $rows['DIACHI'] . '</td>';
        echo '<td>' . $rows['SDT'] . '</td>';
        echo '<td><a><button type="submit" class="sua-xoa" onclick="suaDuLieu(' . $rows['MANCC'] . ')">Sửa</button></a></td>';
        echo '<td><a><button type="submit" class="sua-xoa" onclick="xoaDuLieu(' . $rows['MANCC'] . ')">Xóa</button></a></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>';
}
?>

<script type='text/javascript'>
    function xoaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn xóa dữ liệu này?");
        if (xacNhan) {
            // Gửi yêu cầu xóa đến trang xử lý PHP
            alert("Xóa thành công");
            window.location.href = 'quanlysanpham/nhacungcap/xoa.php?id='+id;
        }
    }
</script>

<script type='text/javascript'>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu này?");
        if (xacNhan) {
            window.location.href = 'home.php?page_layout=sua_ncc&id='+id;
        }
    }
</script>

<script type='text/javascript'>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn chặn việc gửi form một cách thông thường
        var searchValue = document.getElementById('search').value;
        window.location.href = 'home.php?page_layout=tk_ncc&search=' + searchValue;
    });
</script>