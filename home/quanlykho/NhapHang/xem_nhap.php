<div class="main">
    <h2>Xem đơn nhập <?php echo $_GET['ID'] ?></h2>
    <div class="center-table">
        <table>
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Mã nhập</th>
                    <th>Nhà cung cấp</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $MA=$_GET['ID'];
                    $sql="SELECT * FROM tbldonnhaphang WHERE MANH='$MA'";
                    $result= mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($row=mysqli_fetch_assoc($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $row['MADNH'] ?></td>
                                <td><?php echo $row['MANH'] ?></td>
                                <td><?php echo $row['NCC'] ?></td>
                                <td><?php echo $row['TENSP'] ?></td>
                                <td><?php echo $row['SOLUONG'] ?></td>
                                <td><?php echo $row['DONGIA'] ?></td>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="button-container">
        <button onclick="Back()" class="cn-button">
            Quay Lại
        </button>
    </div>
</div>
<script>
    function Back()
    {
        event.preventDefault();
        window.location.href = 'home.php?page_layout=nhaphang';
    }

</script>