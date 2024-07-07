<div class="main">
    <h2>Kho</h2>

    <div class="center-table">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã nhập</th>
                    <th>Ngày nhập</th>
                    <th>Tổng tiền</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql="SELECT * FROM tblnhaphang where `TINHTRANG` ='0' ";
                    $result= mysqli_query($conn,$sql);
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
                                <td><?php $row['NGAYNHAP'] = date("d/m/Y", strtotime($row['NGAYNHAP']));
                            echo $row['NGAYNHAP']; ?></td>
                                <td><?php echo $row['TONGTIEN'] ?></td>
                                <td><?php echo ($row['TINHTRANG'] == 0) ? "Chưa nhập" : "Đã nhập"; ?></td>
                                <td><?php if($row['TINHTRANG'] == 0) echo '<a class="sua-xoa" href="quanlykho/Kho/add.php?ID='.$row["MANH"].' ">Thêm vào kho</a>'?></td>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody> 
        </table>
    </div>
</div>
<button class="cn-button" onclick="Back()">Quay Lại</button>
        
<script>
    function Back()
    {
        event.preventDefault();
        window.location.href = 'http://localhost/CNPM/home/home.php?page_layout=kho';
    }

</script>