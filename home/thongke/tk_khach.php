<div>
    <form  method="post" action="">
        <label for="timkiem">Tìm kiếm theo:</label>
        <input type="text" class="inp" name="sdt" id="sdt" placeholder="Nhập số điện thoại">
        <button type="submit" name="submit">Tìm kiếm</button>
    </form>
</div>
<b>Tổng số lượng khách mua hàng:
    <?php
        $sql = " SELECT COUNT(SDT) AS sokhach FROM tblkhachhang";
        $qr = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($qr);
        $sokhach = $rows["sokhach"];
        echo $sokhach;  
    ?>
</b>
<div class="main">
    <h2>THỐNG KÊ SỐ LƯỢNG KHÁCH MUA HÀNG</h2>
    
    <div class="center-table">
        <?php
        $tk = urldecode($_GET['TK']);
        $sql = "SELECT * FROM tblkhachhang WHERE SDT = '$tk'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            createTable($result);
        } else {
            echo 'Danh sách trống.';
        }
        ?>
    </div>

</div>

<?php
    function createTable($result)
    {
        echo '<table>';
        echo '<thead class="custom-class">';
        echo '<tr>';
        echo '<th>STT</th>';
        echo '<th>Mã khách hàng</th>';
        echo '<th>Tên khách hàng</th>';
        echo '<th>Số điện thoại</th>';
        echo '<th>Số hóa đơn</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $count ++;
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['MAKH'] . '</td>';
            echo '<td>' . $row['TENKH'] . '</td>';
            echo '<td>' . $row['SDT'] . '</td>';
            $conn = mysqli_connect("localhost","root","","btlon");
            $sql="SELECT MAKH, COUNT(MAHD) AS SoLuongHoaDon FROM tblhoadon WHERE MAKH = '" . $row['MAKH'] . "' GROUP BY MAKH;";
            $qr = mysqli_query($conn, $sql);
            if (mysqli_num_rows($qr) > 0) {
                $rows = mysqli_fetch_assoc($qr);
                echo '<td>' . $rows['SoLuongHoaDon'] . '</td>';
            }else{
                echo '<td>0</td>';
            }
            
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
?>

<script>
document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();
        var tk = document.getElementById('sdt').value;
        url = 'home.php?page_layout=tk_khach&TK=' + tk;
        window.location.href = url;
    });
</script>