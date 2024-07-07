
<script lang="javascript">
    function On() {
        var DIV = document.getElementById("menu-icon");
        DIV.style.display = "block";
    }

    function Off() {
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

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM tbltaikhoan WHERE TENDN = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $TenDN = $row["TENDN"];
    $MK = $row["MK"];
    $quyen = $row["QUYEN"];

} else {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
?>
<div style="height: 100%; width: 100%; display: flex; justify-content: center;">
    <div class="sua">
        <form class="form" action="" method="post">
            <h2>CẬP NHẬP THÔNG TIN TÀI KHOẢN:
                <?php echo $id ?>
            </h2>
            <table class="tbl1">
                <tr>
                    <td><label for="TENDN">Tên Đăng Nhập: </label></td>
                    <td><input readonly="true" type="text" name="TENDN" id="TENDN" value="<?php echo $TenDN ?>"><br></td>
                </tr>
                <tr>
                    <td><label for="mk">Mật Khẩu: </label></td>
                    <td><input type="text" name="mk" id="mk" value="<?php echo $MK ?>"><br></td>
                </tr>
                <tr>
                    <td><label for="quyen">Quyền:</label></td>
                    <td><select id="quyen" name="quyen">
                            <option <?php if ($quyen == 0)
                                echo 'selected' ?> value="0">Quản lý </option>
                                <option <?php if ($quyen == 1)
                                echo 'selected' ?> value="1">Nhân viên </option>
                            </select>
                        </td>
                    </tr>

                </table>
                <a class="AlertButton" href="http://localhost/CNPM/home/home.php?page_layout=quanlytk">Quay lại</a>
                <button type="submit" name="Sua" class="AlertButton">Cập Nhập</button>

        </form>
            <!-- <button class="AlertButton" onclick="DK()">Đăng ký tài khoản</button> -->

    </div>
</div>


<?php
    if (isset($_POST["Sua"])) {
        $ID = $_GET["id"];
        $mk = $_POST["mk"];
        $quyen = $_POST["quyen"];

        $updateSql = "UPDATE tbltaikhoan SET mk = '$mk', QUYEN = '$quyen' WHERE TENDN= '$ID'";
        $result = mysqli_query($conn, $updateSql);
        if ($result) {
            echo "Cập nhật thành công!";
            echo "<script type='text/javascript'>alert('Cập nhập thành công')
        window.location.href='home.php?page_layout=quanlytk';
    </script>";
        } else {
            echo "Lỗi cập nhật: " . mysqli_error($conn);
        }

    }
?>