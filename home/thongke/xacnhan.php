<?php
$conn = mysqli_connect("localhost","root","","btlon");
if(!$conn){
    die("Kết nối thất bại.");
}else{
    $ID = $_GET["mahd"];
    $updateSql = "UPDATE tblhoadon SET TINHTRANG = '1' WHERE MAHD = '$ID'";
    $result = mysqli_query($conn, $updateSql);
    if ($result) {
        echo "<script type='text/javascript'>alert('Xác nhận thành công')
                            window.location.href='http://localhost/CNPM/home/home.php?page_layout=hoadon';
                        </script>";
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }

}
?>