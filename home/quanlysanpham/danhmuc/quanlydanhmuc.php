<div class="timkiem">
    <form method="get" action="timkiem.php">
        <input type="text" name="search" id="search" placeholder="Tìm Kiếm: Nhập tên loại sản phẩm cần tìm">
        <button type="submit"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz26pdq41lB9tCSmOLh1CD3r0bxzyFdBQVCg&usqp=CAU"></button>
    </form>
</div>

<div class="main">
    <h2>Danh Sách Các Loại Sản Phẩm </h2>
    <div class="center-table">
        <?php
            // Thực hiện truy vấn SQL và lưu kết quả vào biến $result
            $sql = "SELECT * FROM `tbldanhmuc`";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                createTable($result);
            } else {
                echo 'Không tìm thấy kết quả nào';
            }
        ?>  
    </div>
    <div class="button-container">
        <button class="cn-button" onclick="window.location.href = 'home.php?page_layout=them_dm'">
            Thêm Loại Sản Phẩm Mới
        </button>
    </div>
</div>


<?php
    
    function createTable($result) 
    {
        echo '<table border="1" style="border-collapse: collapse">';
            echo '<tr class="custom-class">';
            echo '<td>Mã Danh Mục</td>';
            echo '<td>Tên Danh Mục</td>';
            echo '<td>ICON</td>';
            echo '<td>Tên Rút Gọn</td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';
            while ($rows = mysqli_fetch_array($result)) 
            {    
                echo '<tr>';
                echo '<td>'. "DM" . "0" . $rows['MADM'] . '</td>';
                echo '<td>' . $rows['TENDM'] . '</td>';
                echo '<td><img src="' . $rows['IMG'] . '" alt="Ảnh" width="50" height="50"></td>';
                echo '<td>' . $rows['TENVT'] . '</td>';
                echo '<td><a><button type="submit" class="sua-xoa" onclick="suaDuLieu(' . $rows['MADM'] . ')">Sửa</button></a></td>';                
                echo '<td><a><button type="submit" class="sua-xoa" onclick="xoaDuLieu(' . $rows['MADM'] . ')">Xóa</button></a></td>';
                echo '</tr>';

            }
        echo '</table>';
        echo '<br>';
    }
?>

<!-- <script>
    function xoaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn xóa dữ liệu với ID: " + id + "?");

        if (xacNhan) {
            // Gửi yêu cầu Ajax để thiết lập giá trị id trong session
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Chuyển trang sau khi thiết lập giá trị id trong session
                    alert("Xóa thành công");
                    window.location.href = "home.php?page_layout=quanlykh";
                }
            };
            xhttp.open("GET", "set_session.php?id=" + id, true);
            xhttp.send();
        }
    }
</script> -->

<!-- <script>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu với ID: " + id + "?");

        if (xacNhan) {
            // Gửi yêu cầu Ajax để thiết lập giá trị id trong session
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Chuyển trang sau khi thiết lập giá trị id trong session
                    window.location.href = "home.php?page_layout=sua_dm";
                }
            };
            xhttp.open("GET", "set_session.php?id=" + id, true);
            xhttp.send();
        }
    }
</script> -->
<script type='text/javascript'>
    function xoaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn xóa dữ liệu này?");
        if (xacNhan) {
            // Gửi yêu cầu xóa đến trang xử lý PHP
            alert("Xóa thành công");
            window.location.href = 'quanlysanpham/danhmuc/xoa.php?id='+id;
        }
    }
</script>

<script type='text/javascript'>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu này?");
        if (xacNhan) {
            window.location.href = 'home.php?page_layout=sua_dm&id='+id;
        }
    }
</script>

<script type='text/javascript'>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn chặn việc gửi form một cách thông thường
        var searchValue = document.getElementById('search').value;
        window.location.href = 'home.php?page_layout=tk_dm&search=' + searchValue;
    });
</script>