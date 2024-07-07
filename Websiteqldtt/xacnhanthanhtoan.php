<?php
    if (isset($_POST['confirmPayment'])) {
        session_start();
        require "connect.php";

        $tk=$_SESSION["username"];

        $query = "SELECT MAKH FROM tblkhachhang WHERE TENDN = '$tk'";
        $result = mysqli_query($connect, $query);
        $makh = mysqli_fetch_array($result);
        $MAKH = $makh[0];
        
        $sql = "SELECT MAHD FROM tblhoadon ORDER BY MAHD DESC LIMIT 1";
        $result = $connect->query($sql);
        if ($result->num_rows > 0) {
            // Lấy giá trị ID cuối cùng
            $row = $result->fetch_assoc();
            $lastID = $row["MAHD"];
            // Tách phần số từ ID cuối cùng và tăng giá trị lên 1
            $parts = explode("-", $lastID);
            $lastNumber = (int)$parts[1];
            $newNumber = $lastNumber + 1;
            $newID = "HD-" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $newID = "HD-001";
        }

        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product) {
                $masp = $product['MASP'];
                $qrfilter = "SELECT * FROM tblsanpham WHERE MASP = '".$masp."'";
                $resultFIlter = mysqli_query($connect,$qrfilter);
                $rowSP = mysqli_fetch_array($resultFIlter);
        
                $query = "INSERT INTO tbldonhang (MAHD, MAKH, MASP, TONGTIEN) VALUES ('$newID', '$MAKH', '$masp', '".$rowSP['GIA']."' )";
                
                $result = mysqli_query($connect, $query);
            }
            $submit  = "INSERT INTO `tblhoadon`(`MAHD`, `MAKH`, `THANHTIEN`, `NGAY`) 
            SELECT MAHD, MAKH, SUM(TongTien) AS TongThanhTien, CURDATE()
            FROM tbldonhang
            WHERE MAHD = '$newID'
            GROUP BY MAHD;";
            $submitTBL = mysqli_query($connect,$submit);
            if($submitTBL){
                unset($_SESSION['cart']);
            }
            
        }
        
        header("Location: cart.php");
        exit;

    }
?>

        