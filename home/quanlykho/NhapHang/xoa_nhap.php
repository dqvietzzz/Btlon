<?php
    $conn = mysqli_connect("localhost","root","","btlon");
    if(!$conn){
        die("Kết nối thất bại.");
    }else{
        $id=$_GET['ID'];
        $sql="DELETE FROM tblnhaphang WHERE MANH='$id'";
        $sql1="DELETE FROM tbldonnhaphang WHERE MANH='$id'";
        $result=mysqli_query($conn,$sql);
        $result1=mysqli_query($conn,$sql1);
        if($result&&$result1)
        {
            echo "<script type='text/javascript'>alert('Xóa thành công')
            window.location.href='http://localhost/CNPM/home/home.php?page_layout=nhaphang';
            </script>";
        }
        else echo"Lỗi".mysqli_error($conn);
    }
?>