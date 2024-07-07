<?php
    $conn = mysqli_connect("localhost","root","","btlon");
    if(!$conn){
        die("Kết nối thất bại.");
    }else{
        $id=$_GET['ID'];
        $sql="SELECT * FROM tbldonnhaphang WHERE MANH='$id'";
        $result=mysqli_query($conn,$sql);
        $sqla="UPDATE `tblnhaphang` SET `TINHTRANG`='1' WHERE `MANH`='$id'";
        $resulta=mysqli_query($conn,$sqla);
        while($row=mysqli_fetch_assoc($result))
        {
            $sql1="UPDATE `tblkho` SET `SOLUONG`=`SOLUONG`+".intval($row['SOLUONG'])." WHERE `TENSP`='".$row['TENSP']."'";
            $result1=mysqli_query($conn,$sql1);
            
        }
        if($result1)
        {
            echo "<script type='text/javascript'>alert('Thêm thành công')
            window.location.href='http://localhost/CNPM/home/home.php?page_layout=kho';
            </script>";
        }
        else echo"Lỗi".mysqli_error($conn);
    }
?>