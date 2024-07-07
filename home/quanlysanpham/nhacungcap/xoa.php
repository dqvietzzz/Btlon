<?php
    //ket noi database
    $id = $_GET["id"];
    $conn = mysqli_connect("localhost","root","","btlon");
    if($conn)
    {
        $sql = "DELETE FROM `tblncc` WHERE `MANCC` = $id";
        $result = mysqli_query($conn, $sql);

        //thong bao ket qua
        if ($result) 
        {
            echo '<script type="text/javascript">';
            echo ' alert("Xóa dữ liệu thành công") ';
            echo '</script>';
        } else 
        {
            echo '<script type="text/javascript">';
            echo ' alert("Xóa dữ liệu thất bại") ';
            echo '</script>';
        }

        mysqli_close($conn);
        
    }
    else
    {
        echo 'ket noi that bai';
    }

    header("Location: http://localhost/CNPM/home/home.php?page_layout=ncc"); 
?>