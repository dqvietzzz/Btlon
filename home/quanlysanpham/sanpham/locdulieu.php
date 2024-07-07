<?php
    $tendm = $_GET['tendm'];
?>
<div class="head"></div>

<div class="timkiem">
    <form method="get" action="timkiem.php">
        <input type="text" name="search" id="search" placeholder="Tìm Kiếm: Nhập tên sản phẩm cần tìm">
        <button type="submit"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRz26pdq41lB9tCSmOLh1CD3r0bxzyFdBQVCg&usqp=CAU"></button>
    </form>
</div>

<div class="main">
    <h2>Danh Sách sản phẩm </h2>
    <div class="center-table">
        
        <?php
            // Thực hiện truy vấn SQL và lưu kết quả vào biến $result
            $sql = "SELECT * FROM `tblsanpham` WHERE `DANHMUC` = '$tendm'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                createTable($result, $conn);
            } else {
                echo 'Không tìm thấy kết quả nào';
            }
        ?>
        
    </div>

    <div class="button-container">
        <button class="cn-button" onclick="window.location.href = 'home.php?page_layout=them_sp'">
            Thêm Sản Phẩm Mới
        </button>

        <div class="dropdown">
            <button class="cn-button">Lọc Sản Phẩm Theo Loại</button>
            <div class="dropdown-content">
                <?php
                    $sql = "SELECT TENDM FROM `tbldanhmuc`";
                    $result = mysqli_query($conn, $sql);
                    while ($rows = mysqli_fetch_array($result)) 
                    {
                        echo '<a href="#" value= "' . $rows['TENDM'] . '" onclick="chuyenTrang(\'' . $rows['TENDM'] . '\')"> ' . $rows['TENDM'] . ' </a>';
                    }
                ?>
                
            </div>
        </div>
        <button class="cn-button" onclick="window.location.href = 'home.php?page_layout=sanpham'">
            Quay lại
        </button>           
        
    </div>
    
</div>

<?php
    function createTable($result, $conn) 
    {
        echo '<table border="1" style="border-collapse: collapse">';
            echo '<tr class="custom-class">';
            echo '<td>Mã Sản Phẩm</td>';
            echo '<td>Hình Ảnh</td>';
            echo '<td>Tên Sản Phẩm</td>';
            echo '<td>Danh Mục</td>';
            echo '<td>Giá Thành</td>';
            echo '<td>Nhà Cung Cấp</td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';
            while ($rows = mysqli_fetch_array($result)) 
            {   
                $TENDM = $rows['DANHMUC'];
                $sql = "SELECT TENVT FROM tbldanhmuc WHERE TENDM = '$TENDM' ";
                $ketqua = mysqli_query($conn, $sql);
                $TENVT = mysqli_fetch_array($ketqua);
                echo '<tr>';
                echo '<td>'. $TENVT['TENVT'] . "0" . $rows['MASP'] . '</td>';
                echo '<td><img class="img" src="' . $rows['IMG'] . '" alt="Ảnh" ></td>';
                echo '<td>' . $rows['TENSP'] . '</td>';
                echo '<td>' . $rows['DANHMUC'] . '</td>';
                echo '<td>' . number_format($rows['GIA']) . " đ" .'</td>';
                echo '<td>' . $rows['NCC'] . '</td>';
                echo '<td><button type="submit" class="sua-xoa" onclick="suaDuLieu(' . $rows['MASP'] . ')">Sửa</button></td>';                
                echo '<td><button type="submit" class="sua-xoa" onclick="xoaDuLieu(' . $rows['MASP'] . ')">Xóa</button></td>';
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
            window.location.href = 'quanlysanpham/sanpham/xoa.php?id='+id;
        }
    }
</script>

<script type='text/javascript'>
    function suaDuLieu(id) {
        var xacNhan = confirm("Bạn có chắc chắn muốn sửa dữ liệu này?");
        if (xacNhan) {
            window.location.href = 'home.php?page_layout=sua_sp&id='+id;
        }
    }
</script>

<script type='text/javascript'>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn chặn việc gửi form một cách thông thường
        var searchValue = document.getElementById('search').value;
        window.location.href = 'home.php?page_layout=tk_sp&search=' + searchValue;
    });
</script>

<script>
    function chuyenTrang(tendm) {
        window.location.href = 'home.php?page_layout=loc_sp&tendm=' + tendm;
    }
</script>