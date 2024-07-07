<?php
    if(isset($_GET['ID']))
    {
        $ma=$_GET['ID'];
        $sql="SELECT * FROM tblkho WHERE MASP='$ma'";
        $result = mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
    }
    $error=[];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($_POST['sl'] !== '' || $_POST['sl'] === '0')
        {
            if($_POST['sl']<0)
            {
                $error['min']='Số lượng phải lớn hơn 0';
            }
        }
        else $error['required']='Không được để trống';
    }
?>
<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" action="" method="post">
            <h2>Sửa kho:</h2>
            
            <table class=tbl1>
                <tr>
                    <td><label for="ma">Mã: </label></td>
                    <td><input type="text" id="ma" name="ma" value="<?php echo $row['MASP'] ?>" readonly><br></td>
                </tr>
                <tr>
                    <td><label for="ncc">Nhà cung cấp:</label></td>
                    <td><input type="text" id="ncc" name="ncc" value="<?php echo $row['MANCC'] ?>" readonly><br></td>
                </tr>
                <tr>
                    <td><label for="sp">Sản phẩm:</label></td>
                    <td><input type="text" id="sp" name="sp" value="<?php echo $row['TENSP'] ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="sl">Số lượng:</label></td>
                    <td><input type="number" id="sl" name="sl" value="<?php echo $row['SOLUONG'] ?>">
                    <?php if(!empty($error['min'])) echo '<p style="color:red">'.$error['min'].'</p>' ;?>
                    <?php if(!empty($error['required']))
                    echo '<p style="color:red">'.$error['required'].'</p>';?></td>
                </tr>
            </table>
            <button class="AlertButton" type="submit">Lưu</button>
            <button id="btnBack" class="AlertButton">Quay Lại</button>
            <script>
                btnBack.addEventListener('click', function (event) {
                    event.preventDefault(); // Ngăn form gửi lại trang
                    window.location.href = 'home.php?page_layout=kho';
                });
            </script>

        </form>
    </div>
</div>


<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($error))
        {
            $sql="UPDATE `tblkho` SET `SOLUONG`='".$_POST['sl']."' WHERE MASP =$ma";
            $result=mysqli_query($conn,$sql);
            if($result)
            {
                echo "<script type='text/javascript'>alert('Sửa dữ liệu thành công')
                    window.location.href='http://localhost/CNPM/home/home.php?page_layout=kho';
                    </script>";
            }
        }
    }
?>
