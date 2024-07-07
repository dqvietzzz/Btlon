<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    
    <title>Đăng ký|CREATE ACCOUNT</title>
</head>
<body>
    <?php
        $conn = mysqli_connect("localhost","root","","btlon");
        if(!$conn){
            die("Kết nối thất bại.");
        }
    ?>

    <div class="div">
        <div class="div1">

            <div class="div2">
                <div style="padding: 8px 0 16px 0;">
                    <img width="212px" height="70px" class="" src="img/logo_2020p.png" alt="UTT">
                </div>
                <div style="font-size: 24px; line-height: 28px; font-family:Arial;">Đăng ký tại đây</div>
                <div style="padding-bottom: 12px; color: #606770;font-family:Arial;font-size: 15px;line-height: 24px;margin-bottom: 12px;">Điền đầy đủ thông tin tài khoản mới.</div>
                <img width="270px" height="180px" src="img\logo.png" alt="logo">
            </div>

            <div class="div3">
                <div style="height: 456px;width: 396px;">
                    <div style="padding-bottom: 24px; padding-top: 0px; margin: 40px; margin-top: 10px; text-align: center; display: flex; justify-content: center;">
                        <form action="" method="post">
                            <input type="text" placeholder="Họ và Tên" name="txtTen" id="txtTen"> <br>
                            <input type="text" placeholder="Tên tài khoản" name="txtTK" id="txtTK"> <br>
                            
                            <input type="text" placeholder="Địa chỉ" name="txtDiachi" id="txtDiachi"> <br>
                            <input type="text" placeholder="SĐT" name="txtSDT" id="txtSDT"> <br>
                            <input type="password" placeholder="Mật khẩu" name="txtMK" id="txtMK"> <br>
                            
                            <button class="btn1">Đăng Ký</button>    <br>
                            <a href="login.php"><-Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" ){
            if($_POST["txtTK"] === "" || $_POST["txtMK"] === "" || $_POST["txtTen"] === "" || $_POST["txtDiachi"] == "" || $_POST["txtSDT"] == ""){
                echo "<script type='text/javascript'>
                    alert('Điền đầy đủ thông tin.')  
                    </script>";
            }
            else{
                $sql = "SELECT MAKH FROM tblkhachhang ORDER BY MAKH DESC LIMIT 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Lấy giá trị ID cuối cùng
                    $row = $result->fetch_assoc();
                    $lastID = $row["MAKH"];
                    // Tách phần số từ ID cuối cùng và tăng giá trị lên 1
                    $parts = explode("-", $lastID);
                    $lastNumber = (int)$parts[1];
                    $newNumber = $lastNumber + 1;
                    $newID = "KH-" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
                } else {
                    $newID = "KH-001";
                }
                
                $TK = $_POST["txtTK"];
                $MK = $_POST["txtMK"];
                $Ten =$_POST["txtTen"];
                $Diachi = $_POST["txtDiachi"];
                $SDT = $_POST["txtSDT"];

                $sql = "SELECT * FROM tblTAIKHOAN WHERE TENDN = '$TK'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<script type='text/javascript'>
                            alert('Tài khoản đã tồn tại');
                        </script>";
                }
                else{
                    if (is_numeric($SDT)) {
                        $sql1 = "INSERT INTO tblTAIKHOAN (TENDN, MK, QUYEN) VALUES ('$TK','$MK',2)";
                        $sql2 = "INSERT INTO tblKHACHHANG (TENDN, MAKH, TENKH, DIACHI, SDT) VALUES ('$TK','$newID','$Ten','$Diachi','$SDT')";
                        $result1 = mysqli_query($conn, $sql1);
                        $result2 = mysqli_query($conn, $sql2);
                        if ($result1 && $result2) {
                            echo "<script type='text/javascript'>alert('Tạo tài khoản thành công')
                                    window.location.href='login.php';
                                </script>";
                        } else {
                            echo "Lỗi cập nhật: " . mysqli_error($conn);
                        }
                    }else {
                        echo"<script type='text/javascript'>
                                alert('SĐT phải nhập số.');
                            </script>";
                    }
                    
                     
                }
            }
            
        }
    ?>

</body>
</html>