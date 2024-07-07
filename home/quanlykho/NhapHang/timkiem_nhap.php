<div class="main">
    <div class="center-table">
        <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã nhập</th>
                <th>Nhà cung cấp</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $tk = urldecode($_GET['TK']);
                $tk_theo=urldecode($_GET['TK_theo']);
                $sql="SELECT * FROM `tbldonnhaphang` WHERE $tk_theo ='$tk'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0)
                {
                    $count=0;
                    while($row=mysqli_fetch_assoc($result))
                    {
                        $count++;
                        ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['MANH'] ?></td>
                            <td><?php echo $row['NCC'] ?></td>
                            <td><?php echo $row['TENSP'] ?></td>
                            <td><?php echo $row['SOLUONG'] ?></td>
                            <td><?php echo $row['DONGIA'] ?></td>
                            <td><?php echo '<a href="home.php?page_layout=xem_nhap&ID='.$row["MANH"].' ">'?>Xem</a></td>
                            <td><?php echo "<a onClick=\"javascript: return confirm('Bạn có muốn xóa đơn hàng này');\"href='quanlykho/NhapHang/xoa_nhap.php?ID=".$row["MANH"]."'>Xóa</a>" ?></td>
                            <td><?php echo '<a href="home.php?page_layout=sua_nhap&ID='.$row["MANH"].' ">'?>Sửa</a></td>
                        </tr>
                    <?php
                    }
                }
            ?>
        </tbody>
        </table>
    </div>
    <button onclick="Back()" style="width:fit-content">Quay lại</button>
    <script>
        function Back()
        {
            event.preventDefault();
            window.location.href = 'home.php?page_layout=nhaphang';
        }
    </script>
</div>