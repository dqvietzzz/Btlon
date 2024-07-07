            <div class="timkiem" >
                <p>
                    Tìm kiếm theo :
                    <select name="TK_theo" id="TK_theo">
                        <option value="NCC">Nhà cung cấp</option>
                        <option value="TENSP">Tên sản phẩm</option>
                    </select>
                </p>
                <p>
                    Từ khóa :
                    <input type="text" name="TK" id="TK">
                </p>
                <button onclick="Timkiem()">Tìm kiếm</button>
            </div>
            <div class="main">
                <h2>Danh sách nhập hàng</h2>
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

                                $sql="SELECT * FROM tblnhaphang";
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
                                            <td><?php echo '<a href="home.php?page_layout=xem_nhap&ID='.$row["MANH"].' ">'?><button class="sua-xoa">Xem</button></a></td>
                                            <td><?php echo "<a onClick=\"javascript: return confirm('Bạn có muốn xóa đơn hàng này');\"href='quanlykho/NhapHang/xoa_nhap.php?ID=".$row["MANH"]."'><button class='sua-xoa'>Xóa</button></a>" ?></td>
                                            <td><?php if($row['TINHTRANG'] == 0) echo '<a href="home.php?page_layout=sua_nhap&ID='.$row["MANH"].' "><button class="sua-xoa">Sửa</button></a>'?></td>
                                            <td><?php if($row['TINHTRANG'] == 0) echo '<a href="quanlykho/NhapHang/add.php?ID='.$row["MANH"].' "><button class="sua-xoa">Thêm vào kho</button></a>'?></td>
                                        </tr>
                                    <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- <div>
                    <button id="btnThem">Thêm đơn nhập</button>
                </div> -->
                <div class="button-container">
                    <button class="cn-button" id="btnThem">
                        Thêm đơn nhập
                    </button>
                </div>
            </div>
        
    <script>
        const btnThem=document.getElementById('btnThem');
        btnThem.addEventListener('click', function (event) {
                event.preventDefault(); // Ngăn form gửi lại trang 
                window.location.href = 'home.php?page_layout=them_nhap';
            });

        function Timkiem()
        {
            const tktheo = document.getElementById('TK_theo').value;
            const tk = document.getElementById('TK').value;
            const url = 'home.php?page_layout=tk_nhap&TK_theo=' + tktheo + '&TK=' + tk;
            window.location.href = url;
        }
    </script>
    
</body>
</html>