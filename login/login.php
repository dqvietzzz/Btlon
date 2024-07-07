<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    
    <title>Đăng Nhập|Login</title>
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
                <div style="font-size: 24px; line-height: 28px; font-family:Arial;">Đăng nhập tại đây</div>
                <div style="padding-bottom: 12px; color: #606770;font-family:Arial;font-size: 15px;line-height: 24px;margin-bottom: 12px;">Điền đầy đủ thông tin tài khoản.</div>
                <img width="270px" height="180px" src="img\logo.png" alt="logo">
            </div>

            <div class="div3">
                <div style="height: 456px;width: 396px;">
                    <div style="padding-bottom: 24px; padding-top: 10px; margin: 40px; text-align: center; display: flex; justify-content: center;">
                        <form action="" method="post">
                            <input type="text" placeholder="Tên tài khoản" name="txtTK" id="txtTK"> <br>
                            <p></p>
                            <input type="password" placeholder="Mật khẩu" name="txtMK" id="txtMK"> <br>
                            <button type="submit" class="btn1" name="Dangnhap" id="Dangnhap">Đăng Nhập</button>    <br>
                            <hr>
                            <a class="btn2" href="create_account.php">Tạo tài khoản mới</a>
                            
                        </form>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php
        session_start();
        if(isset($_POST["Dangnhap"])){
            $TK = $_POST['txtTK'];
            $_SESSION['TENDN'] = $_POST['txtTK'];
            $_SESSION['username'] = $TK;
            $MK = $_POST['txtMK'];
            $str1 = "Location: http://localhost/CNPM/home/home.php";
            $str2 = "Location: http://localhost/CNPM/Websiteqldtt/sell_index.php";
            $TK = mysqli_real_escape_string($conn, $TK);
            $MK = mysqli_real_escape_string($conn, $MK);

            $sql = "SELECT QUYEN FROM tblTAIKHOAN WHERE TENDN = '$TK' AND MK = '$MK'";

            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                // Đăng nhập thành công, thực hiện các hành động cần thiết
                $row = $result->fetch_assoc();
                $_SESSION['QUYEN'] = $row['QUYEN'];
                $quyen = $_SESSION['QUYEN'];
                var_dump($quyen);
                if($quyen == 0 || $quyen == 1){
                    header($str1);
                    exit;
                }
                elseif($quyen == 2){
                    header($str2);
                    $_SESSION['cart'] = array();
                    exit;
                }
            } else {
                // Đăng nhập thất bại
                echo "<script type='text/javascript'>
                    alert('Tài khoản hoặc Mật khẩu sai!');
                    window.location.href='http://localhost/CNPM/login/login.php';
                </script>";
            }
        }
        
        
    ?>

</body>
</html>