<div class="timkiem">
    <form method="get" action="timkiem.php">
        <input type="text" name="search" id="search" placeholder="Nhập tên mã SP cần tìm">
        <button type="submit"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz26pdq41lB9tCSmOLh1CD3r0bxzyFdBQVCg&usqp=CAU"></button>
    </form>
</div>

<div class="main">
    <h2>DOANH SỐ CỬA HÀNG</h2>
    <div class="center-table">
        <?php
        $sql = " SELECT *,tbldonnhaphang.SOLUONG AS soluongnhap,tbldonhang.SOLUONG AS soluongdaban,SUM(tbldonhang.TONGTIEN) AS tongtiendaban,tbldonnhaphang.GIANHAP * tbldonnhaphang.SOLUONG AS tongtiennhap FROM tbldonnhaphang JOIN tbldonhang ON tbldonnhaphang.MASP = tbldonhang.MASP JOIN tblsanpham ON tblsanpham.MASP = tbldonnhaphang.MASP";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            createTable($result);
        } else {
            echo 'Danh sách trống.';
        }
        ?>
    </div>>
</div>


<?php
function createTable($result)
{
    echo '<table>';
    echo '<thead class="custom-class">';
    echo '<tr>';
    echo '<th>STT</th>';
    echo '<th>Mã sản phẩm</th>';
    echo '<th>Tên sản phẩm</th>';
    echo '<th>Tên đăng nhập</th>';
    echo '<th>Số lượng nhập</th>';
    echo '<th>Tiền nhập</th>';
    echo '<th>Số lượng đã bán</th>';
    echo '<th>Tổng tiền đã bán</th>';
    echo '<th></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $count = 0;
    while ($rows = mysqli_fetch_assoc($result)) {
        $count++;
        echo '<tr>';
        echo '<td>' . $count . '</td>';
        echo '<td>' . $rows['MASP'] . '</td>';
        echo '<td>' . $rows['TENSP'] . '</td>';
        echo '<td>' . $rows['soluongnhap'] . '</td>';
        echo '<td>' . $rows['soluongnhap'] * $rows["GIANHAP"] . '</td>';
        echo '<td>' . $rows["soluongdaban"] . '</td>';
        echo '<td>' . $rows["soluongdaban"] * $rows["GIA"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>
