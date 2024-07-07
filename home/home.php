<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>QUẢN LÝ SIÊU THỊ ĐIỆN MÁY</title>
    <script lang="javascript">
        function On(){
            var DIV = document.getElementById("menu-icon");
            DIV.style.display = "block";
        }

        function Off(){
            var DIV = document.getElementById("menu-icon");
            DIV.style.display = "none";
        }

        document.addEventListener("DOMContentLoaded", function () {
            var showAlertButton = document.getElementById("showAlertButton");
            var customAlert = document.getElementById("customAlert");
            var closeAlertButton = document.getElementById("closeAlertButton");

            showAlertButton.addEventListener("click", function () {
                customAlert.style.display = "flex";
            });

            closeAlertButton.addEventListener("click", function () {
                customAlert.style.display = "none";
            });
        });

    </script>
</head>


<body>
    <?php 
        $conn = mysqli_connect("localhost","root","","btlon");
        if(!$conn){
            die("Kết nối thất bại.");
        }

        session_start();

        if(isset($_SESSION['TENDN'])){
            $TK = $_SESSION['TENDN'];
            $sql = "SELECT * FROM tbltaikhoan WHERE TENDN = '$TK'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $MK_bandau = $row["MK"];
                }
        }else {
            $TK = " ";
        }

        $str1 = "Location: http://localhost/CNPM/home/home.php";

        if(isset($_POST["DoiMK"])){
            $MK_cu = $_POST['txtMK-cu'];
            $MK = $_POST['txtMK'];
            $MK_lai = $_POST['txtMK-lai'];
            if($MK_bandau === $MK_cu){
                if($MK === $MK_lai){
                    $updateSql = "UPDATE tbltaikhoan SET MK = '$MK' WHERE TENDN = '$TK'";
                    $result = mysqli_query($conn, $updateSql);
                    if ($result) {
                        echo "<script type='text/javascript'>alert('Đổi mật khẩu thành công')
                                
                            </script>";
                        
                    } else {
                        echo "Lỗi cập nhật: " . mysqli_error($conn);
                    }
                }else{
                    echo "<script type='text/javascript'>alert('Mật khẩu mới không trùng khớp')
                            </script>";
                }
            }else{
                echo "<script type='text/javascript'>alert('Mật khẩu cũ không đúng')
                    </script>";
            } 
        }
        
    ?>

    <div class="div">
        <div class="div1">
            <div class="logo">
                <img width="90%" height="50px" src="img\logo_2020p.png" alt="logo.png">
            </div>
            <div class="menu">
                <ul>  
                    <li><a href="home.php?page_layout=quanlytk">Quản lí tài khoản</a></li>
                    <li><a href="home.php?page_layout=quanlynv">Quản lí nhân sự</a></li>
                    <li><a href="home.php?page_layout=quanlykh">Quản lí khách hàng</a></li>

                    <li><a href="home.php?page_layout=sanpham">Sản Phẩm</a></li>
                    <li><a href="home.php?page_layout=ncc">Nhà Cung Cấp</a></li>
                    <li><a href="home.php?page_layout=danhmuc">Danh Mục</a></li>

                    <li><a href="home.php?page_layout=nhaphang">Nhập hàng</a></li>
                    <li><a href="home.php?page_layout=kho">Kho</a></li>

                    <li><a href="home.php?page_layout=hoadon">Hóa đơn</a></li>
                    <li><a href="#">Thống kê</a>
                        <ul>
                            <li><a href="home.php?page_layout=doanhthu">Doanh thu</a></li>
                            <li><a href="home.php?page_layout=doanhso">Doanh số</a></li>
                            <li><a href="home.php?page_layout=khachhang">Thống kê khách hàng</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="div2">
            <div class="header">
                <div class="header-right">
                    <img width="35px" height="35px" src="img/134216_menu_lines_hamburger_icon.png" alt="icon-menu">
                </div>
                
                <div class="header-left">
                    <div class="user-icon">
                        <div style="font-family:Arial; color: #ffffff; margin: 10px; font-size: 17px;">
                            <?php echo $TK ?>
                        </div>
                        <img onclick="On()" src="img/172626_user_male_icon.png" alt="icon-user">
                        <div class="menu-icon" id="menu-icon">
                            <ul>
                                <li><a id="showAlertButton" href="#">Đổi mật khẩu</a></li>
                                <li><a href="http://localhost/CNPM/login/login.php">Đăng xuất</a></li>
                                <li><a onclick="Off()" href="#">Thoát</a></li>
                            </ul>
                        </div>
                    </div>  
                </div>

            </div>

            <div onclick="Off()" class="body">
                <?php
                if(isset($_GET['page_layout'])){
                    switch($_GET['page_layout']){
                        case 'quanlykh':include_once './qlKhachHang/qlKH.php';
                            break;
                        case 'sua_kh':include_once './qlKhachHang/sua.php';
                            break;
                        case 'tk_kh':include_once './qlKhachHang/timkiem.php';
                            break;

                        case 'quanlytk':include_once './qlTK/indexTK.php';
                            break;
                        case 'sua_tk':include_once './qlTK/sua.php';
                            break;
                        case 'tk_tk':include_once './qlTK/timkiem.php';
                            break;

                        case 'quanlynv':include_once './qlNhanSu/indexNS.php';
                            break;
                        case 'sua_nv':include_once './qlNhanSu/sua.php';
                            break;
                        case 'tk_nv':include_once './qlNhanSu/timkiem.php';
                            break;
   
                        case 'nhaphang':include_once './quanlykho/NhapHang/index_nhap.php';
                            break;
                        case 'sua_nhap':include_once './quanlykho/NhapHang/sua_nhap.php';
                            break;
                        case 'xem_nhap':include_once './quanlykho/NhapHang/xem_nhap.php';
                            break;
                        case 'them_nhap':include_once './quanlykho/NhapHang/them_nhap.php';
                            break;
                        case 'tk_nhap':include_once './quanlykho/NhapHang/timkiem_nhap.php';
                            break;

                        case 'kho':include_once './quanlykho/kho/index_kho.php';
                            break;
                        case 'sua_kho':include_once './quanlykho/kho/sua_kho.php';
                            break;
                        case 'nhap_kho':include_once './quanlykho/kho/nhap_kho.php';
                            break;

                        case 'ncc':include_once './quanlysanpham/nhacungcap/quanlynhacungcap.php';
                            break;
                        case 'sua_ncc':include_once './quanlysanpham/nhacungcap/sua.php';
                            break;
                        case 'them_ncc':include_once './quanlysanpham/nhacungcap/them.php';
                            break;
                        case 'tk_ncc':include_once './quanlysanpham/nhacungcap/timkiem.php';
                            break;

                        case 'danhmuc':include_once './quanlysanpham/danhmuc/quanlydanhmuc.php';
                            break;
                        case 'them_dm':include_once './quanlysanpham/danhmuc/them.php';
                            break;
                        case 'sua_dm':include_once './quanlysanpham/danhmuc/sua.php';
                            break;
                        case 'tk_dm':include_once './quanlysanpham/danhmuc/timkiem.php';
                            break;

                        case 'sanpham':include_once './quanlysanpham/sanpham/quanlysanpham.php';
                            break;
                        case 'sua_sp':include_once './quanlysanpham/sanpham/sua.php';
                            break;
                        case 'them_sp':include_once './quanlysanpham/sanpham/them.php';
                            break;
                        case 'tk_sp':include_once './quanlysanpham/sanpham/timkiem.php';
                            break;
                        case 'loc_sp':include_once './quanlysanpham/sanpham/locdulieu.php';
                            break;

                        case 'doanhso':include_once './thongke/doanhsoBTL.php';
                            break;
                        case 'doanhthu':include_once './thongke/doanhthuBTL.php';
                            break;
                        case 'hoadon':include_once './thongke/hoadonBTL.php';
                            break;
                        case 'tk_hoadon':include_once './thongke/tk_hoadon.php';
                            break;
                        case 'hoadonchitiet':include_once './thongke/hoadonchitietBTL.php';
                            break;
                        case 'khachhang':include_once './thongke/khachhangBTL.php';
                            break;
                        case 'tk_khach':include_once './thongke/tk_khach.php';
                            break;


                        default:include_once './defaul.php';
                            break;
                    }
                }else{include_once './defaul.php';}
                    
                ?>
            </div>
        </div>

    </div>





    
    <div class="custom-alert" id="customAlert">
        <div class="alert-content">
            <form action="" method="post">
                <h2>ĐỔI MẬT KHẨU</h2>
                <input type="password" placeholder="Nhập mật khẩu cũ" name="txtMK-cu" id="txtMK-cu"> <br>
                
                <input type="password" placeholder="Mật khẩu mới" name="txtMK" id="txtMK"> <br>
                <input type="password" placeholder="Nhập lại mật khẩu mới" name="txtMK-lai" id="txtMK-lai"> <br>
                <button type="submit" name="DoiMK" class="AlertButton">Đổi mật khẩu</button>
                <button class="AlertButton" id="closeAlertButton">Đóng</button>
            </form>
            
            
        </div>
    </div>
    
</body>
</html>