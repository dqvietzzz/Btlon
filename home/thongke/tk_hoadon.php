<div>
    <form  method="post" action="">
        <label for="timkiem">Tìm kiếm theo:</label>
        <select class="inp" name="chon" id="chon" onchange="showInput()">
            <option value="">--Chọn--</option>
            <option value="Tatca">Tất cả</option>
            <option value="MAHD">Mã hóa đơn</option>
            <option value="SDT">SĐT</option>
            <option value="NGAY">Ngày</option>
        </select>
    
        <input class="inp" type="text" name="mahoadon" id="mahoadon" placeholder="Nhập mã hóa đơn" style="display:none">
        <input class="inp" type="text" name="sdt" id="sdt" placeholder="Nhập số điện thoại" style="display:none">
        <input class="inp" type="date" name="ngay" id="ngay" style="display:none">
        <button type="submit" name="submit">Tìm kiếm</button>
    </form>
</div>

<div class="main">
    <h2>QUẢN LÝ HÓA ĐƠN</h2>
    

    <div class="center-table">
        <?php
        $tk = urldecode($_GET['TK']);
        $tk_theo=urldecode($_GET['TK_theo']);
        if($tk_theo=='NGAY'){

            $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN,tblhoadon.TINHTRANG FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH WHERE NGAY = '$tk'";
        }else if($tk_theo =='MAHD'){
            $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN,tblhoadon.TINHTRANG FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH WHERE MAHD = '$tk'";
        }else if($tk_theo =='SDT'){
            $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN,tblhoadon.TINHTRANG FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH WHERE tblkhachhang.SDT = '$tk'";
        }else{
            $sql = " SELECT tblhoadon.NGAY,tblhoadon.MAHD,tblhoadon.MAKH,tblkhachhang.TENKH,tblkhachhang.SDT,tblhoadon.THANHTIEN,tblhoadon.TINHTRANG FROM tblhoadon INNER JOIN tblkhachhang ON tblhoadon.MAKH = tblkhachhang.MAKH";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            createTable($result);
        } else {
            echo 'Danh sách trống.';
        }
        ?>
    </div>

    
</div>



<script>
    function showInput() {
        var chon = document.getElementById("chon");
        var mahoadon = document.getElementById("mahoadon");
        var sdt = document.getElementById("sdt");
        var ngay = document.getElementById("ngay");
        if (chon.value == "MAHD") {
            mahoadon.style.display = "inline-flex";
        }else{
            mahoadon.style.display = "none";
        }
        if (chon.value == "SDT") {
            sdt.style.display = "inline-flex";
        }else{
            sdt.style.display = "none";
        }
        if (chon.value == "NGAY") {
            ngay.style.display = "inline-flex";
        }else{
            ngay.style.display = "none";
        }
    }

    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();
        var tktheo = document.getElementById('chon').value;
        var tk1 = document.getElementById('mahoadon').value;
        var tk2 = document.getElementById('sdt').value;
        var tk3 = document.getElementById('ngay').value;
        var url;
        if(tktheo=='NGAY'){
            
            url = 'home.php?page_layout=tk_hoadon&TK_theo=' + tktheo + '&TK=' + tk3;
        }else if(tktheo =='MAHD'){
            url = 'home.php?page_layout=tk_hoadon&TK_theo=' + tktheo + '&TK=' + tk1;
        }else if(tktheo =='SDT'){
            url = 'home.php?page_layout=tk_hoadon&TK_theo=' + tktheo + '&TK=' + tk2;
        }else{
            url = 'home.php?page_layout=hoadon';
        }
        window.location.href = url;
    });
</script>
<?php
    function createTable($result)
    {
        echo '<table>';
        echo '<thead class="custom-class">';
        echo '<tr>';
        echo '<th>STT</th>';
        echo '<th>Ngày</th>';
        echo '<th>Mã hóa đơn</th>';
        echo '<th>Mã khách hàng</th>';
        echo '<th>Tên khách hàng</th>';
        echo '<th>Số điện thoại</th>';
        echo '<th>Tiền</th>';
        echo '<th>Tình Trạng</th>';
        echo '<th></th>';
        echo '<th></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $count ++;
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            $date = $row["NGAY"];
            $date1 = date('d-m-Y',strtotime($date));
            echo '<td>' . $date1 . '</td>';
            echo '<td>' . $row['MAHD'] . '</td>';
            echo '<td>' . $row['MAKH'] . '</td>';
            echo '<td>' . $row['TENKH'] . '</td>';
            echo '<td>' . $row['SDT'] . '</td>';
            echo '<td>' . $row['THANHTIEN'] . '</td>';
            if($row['TINHTRANG']==0){
                echo '<td style= "color: red;"> Chưa giao </td>';
            }elseif($row['TINHTRANG']==1){
                echo '<td> Đã giao </td>';
            }
            echo '<td><a href="home.php?page_layout=hoadonchitiet&mahd=' . $row["MAHD"] . '"><button class="sua-xoa">Chi tiết</button></a></td>';
            echo '<td><a href="home/thongke/xacnhan.php&mahd=' . $row["MAHD"] . '"><button class="sua-xoa">Xác nhận</button></a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
?>