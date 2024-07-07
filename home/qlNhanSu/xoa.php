<?php
    $conn = mysqli_connect("localhost","root","","btlon");
    if(!$conn){
        die("Kết nối thất bại.");
    }else{

        $id = $_GET['id'];
        $str1 = "Location: http://localhost/CNPM/home/home.php?page_layout=quanlynv";

        $sql = "DELETE FROM tblnhanvien WHERE MANV='" .$id. "' ";


        $result = mysqli_query($conn, $sql);
        if(!$result){
            echo "Delete error" . mysqli_error($conn);
        }
        else{
            header($str1);
        }
    }
?>