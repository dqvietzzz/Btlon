<?php
    $conn = mysqli_connect("localhost","root","","btlon");
    if(!$conn){
        die("Kết nối thất bại.");
    }else{
        // $TK = $_GET['TK'];
        $id = $_GET['id'];
        $str1 = "Location: http://localhost/CNPM/home/home.php?page_layout=quanlytk";

        $sql = "SELECT * FROM tblkhachhang WHERE TENDN='" .$id. "' ";

        $sql1 = "DELETE FROM tblkhachhang WHERE TENDN='" .$id. "' ";

        $sql2 = "DELETE FROM tbltaikhoan WHERE TENDN='" .$id. "' ";


        $result = mysqli_query($conn, $sql);
        if($result){
            if(mysqli_num_rows($result) > 0){
                $result1 = mysqli_query($conn, $sql1);
                $result2 = mysqli_query($conn, $sql2);
                if(!$result1 && !$result2){
                    echo "Delete error" . mysqli_error($conn);
                }
                else{
                    header($str1);
                }
            }else{
                $result2 = mysqli_query($conn, $sql2);
                if(!$result2){
                    echo "Delete error" . mysqli_error($conn);
                }
                else{
                    header($str1);
                }
            }
        }

    }
?>