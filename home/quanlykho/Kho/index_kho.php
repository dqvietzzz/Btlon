<div class="main">

    <h1 style="margin-top: 20px;">Danh sách Kho hàng</h1>
    
    <div class="center-table">
        <table>
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Nhà cung cấp</th>
                    <th>Tên SP</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $sql="SELECT * FROM tblkho";
                    $result= mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0)
                    {
                        $count=0;
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $count++;
                            ?>
                            <tr>
                                <td><?php echo $row['MASP'] ?></td>
                                <td><?php echo $row['TENSP'] ?></td>
                                <td><?php echo $row['MANCC'] ?></td>
                                <td class="sl"><?php echo $row['SOLUONG'] ?></td>
                                <td><?php echo '<a href="home.php?page_layout=sua_kho&ID='.$row["MASP"].' ">'?><button class="sua-xoa">Sửa</button></a></td>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div> 
    <div class="button-container">
        <button class="cn-button" id="btnNhap">
            Nhập kho
        </button>
    </div>
</div>
<script>
        const btnNhap=document.getElementById('btnNhap');
        btnNhap.addEventListener('click', function (event) {
                event.preventDefault(); // Ngăn form gửi lại trang 
                window.location.href = 'http://localhost/CNPM/home/home.php?page_layout=nhap_kho';
            });
</script>