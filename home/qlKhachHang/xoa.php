<?php
    $conn = mysqli_connect("localhost","root","","btlon");
    if(!$conn){
        die("Kết nối thất bại.");
    }else{
   
        $id = $_GET['id'];
        $str1 = "Location: http://localhost/CNPM/home/home.php?page_layout=quanlykh";

        $sql =  "SELECT * FROM tblkhachhang WHERE MAKH='" .$id. "'";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $TenDN = $row["TENDN"];
        }

        $sql1 = "DELETE FROM tblkhachhang WHERE MAKH='" .$id. "' ";

        $sql2 = "DELETE FROM tbltaikhoan WHERE TENDN='" .$TenDN. "' ";

        $result1 = mysqli_query($conn, $sql1);
        $result2 = mysqli_query($conn, $sql2);
        if(!$result1 && !$result2){
            echo "Delete error" . mysqli_error($conn);
        }
        else{
            header($str1);
        }
    }
?>