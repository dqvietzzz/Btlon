<?php
require "connect.php";
    $TENSP = $_GET['TENSP'];
    $sql = "DELETE FROM tblhoadon WHERE TENSP = '$TENSP' limit 1 ";
    $result = mysqli_query($connect, $sql);
    if(!$result){
        echo "Delete error" . mysqli_error($conn);
    }
    else{
        echo "
            <script type='text/javascript'>
                alert('Xóa dữ liệu thành công');
                window.location.href='http://localhost/CNPM/Websiteqldtt/hoadon.php';
            </script>";
    }
?>