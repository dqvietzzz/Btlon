<style>
    .inp{
        border: none;
        padding: 0px;
        margin: 0px;
        width: auto;
        max-width: 200px;
        font-size: 14px
    }

</style>
<div class="main">
    <h2>Đang sửa mã :<?php echo $_GET['ID'] ?></h2>
    <form method="post" name="myForm" id="myForm" >    
        <div class="center-table">         
            <table>
                <thead>
                    <tr>
                        <th><b>Mã đơn</b></th>
                        <th><b>Nhà cung cấp</b></th>
                        <th><b>Sản phẩm</b></th>
                        <th><b>Số lượng</b></th>
                        <th><b>Giá</b></th>
                    </tr>
                </thead>
                <tbody id="inputContainer" class="inputContainer">
                    <?php
                        if(isset($_GET['ID']))
                        {
                            $id=$_GET['ID'];
                            $sql="SELECT * FROM tbldonnhaphang WHERE MANH='$id'";
                            $result = mysqli_query($conn,$sql);
                            $numRow= mysqli_num_rows($result);
                        }
                        $i=0;
                
                        while($row1=mysqli_fetch_assoc($result)){
                            echo '<tr>';
                            echo '<td><input class="inp" id="ma'.$i.'" name="ma'.$i.'" class="ma" value="'.$row1['MADNH'].'" readonly></td>';
                            echo '<td><select id="ncc'.$i.'" name="ncc'.$i.'" class="inp"  onchange="tdsp(this,this.id)" data-index="'.$i.'">';
                            $sql1="SELECT * FROM tblncc";
                            $result2=mysqli_query($conn,$sql1);
                            while($row=mysqli_fetch_assoc($result2))
                            {
                
                                $selected = ($row["TENNCC"] == $row1["NCC"]) ? "selected" : "";
                                echo '<option value="' . $row["TENNCC"] . '" ' . $selected . '>' . $row["TENNCC"] . '</option>';
                            }
                
                            echo '</select></td>';
                            echo '<td><select id="spncc'.$i.'" name="spncc'.$i.'" class="inp" data-index="'.$i.'">';
                                $sql2="SELECT * FROM tblsanpham WHERE NCC='".$row1['NCC']."'";
                                $result3=mysqli_query($conn,$sql2);
                                while($row=mysqli_fetch_assoc($result3))
                                {
                                    $selected = ($row1["TENSP"] == $row["TENSP"]) ? "selected" : "";
                                    echo '<option value="' . $row["TENSP"] . '" ' . $selected . '>' . $row["TENSP"] . '</option>';
                                }
                            echo '</select></td>';
                            echo '<td><input type="text" id="sl'.$i.'" name="sl'.$i.'" class="inp" value="'.$row1['SOLUONG'].'" data-index="'.$i.'"></td>';
                            echo '<td><input type="text" id="gia'.$i.'" name="gia'.$i.'" class="inp" value="'.$row1['DONGIA'].'" data-index="'.$i.'"></td>';
                            echo '<td><button type="button" id="'.$i.'" onclick="deleteRow(this.id)" class="sua-xoa">Xóa</button></td>';
                            echo '<input type="text" id="abc'.$i.'"  name="abc'.$i.'" hidden >';
                            if($i<$numRow-1);
                            $i++;
                            echo '</tr>';
                        }
                    ?>
                    
                </tbody>
            </table>
            
            <input type="hidden" id="maxIdInputChange" name="maxIdChange" value="<?php echo $i ?>">
            <input type="hidden" id="maxIdInput" name="maxId" value="<?php echo $i ?>">
        </div>
        <div class="button-container">
            <div class="textThem"><b>Thêm mới dữ liệu</b></div>
            <button type="button" id="addInputBtn" class="btn">Thêm</button>
            <button type="submit" class="cn-button">Lưu</button>
            <button id="btnBack" class="cn-button">Quay Lại</button>
        </div>
    </form>
    
</div>

<script>       
    function tdsp(selectElement,id) 
    {
        var selectedValue = selectElement.value;

        // Fetch and update the product options based on the selected supplier (selectedValue)
        var productSelect = document.getElementById('sp' + id);
        productSelect.innerHTML = ''; // Clear existing options


        var products = {
            <?php
                $sql3 = "SELECT * FROM tblncc";
                $result1 = mysqli_query($conn, $sql3);
                while ($row = mysqli_fetch_assoc($result1)) 
                {
                    $supplierName = $row['TENNCC'];

                    $sql5 = "SELECT * FROM tblsanpham WHERE NCC='" . $supplierName . "'";
                    $result3 = mysqli_query($conn, $sql5);

                    // Create an array to store product names for this supplier
                    $productNames = array();

                    while ($row2 = mysqli_fetch_assoc($result3)) {
                        $productNames[] = $row2["TENSP"];
                    }

                    echo "'" . $supplierName . "': ['" . implode("',' ", $productNames) . "'],\n";
                }
            ?>
        };

        // Populate the product select based on the selected supplier
        var productOptions = products[selectedValue] || [];
        for (var i = 0; i < productOptions.length; i++) {
            var option = document.createElement('option');
            option.value = productOptions[i];
            option.textContent = productOptions[i];
            productSelect.appendChild(option);
        }
    }

    const form = document.getElementById('myForm'); // Thay đổi ID tại đây
    const inputContainer = document.getElementById('inputContainer');
    const addInputBtn = document.getElementById('addInputBtn');
    const maxIdInputChange=document.getElementById('maxIdInputChange');

    var i = maxIdInputChange.value-1;
    var maxId=0;

    btnBack.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn form gửi lại trang 
        window.location.href = 'home.php?page_layout=nhaphang';
    });

    addInputBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn form gửi lại trang
        i++;
        if (i >= maxId) {
            maxId = i + 1;
        }
        document.getElementById('maxIdInput').value = maxId;
        
        // Tạo một hàng mới (tr)
        var trElement = document.createElement("tr");

        // Tạo các cột mới (td)
        
        var td1 = document.createElement("td");
        var select = document.getElementById('ncc0');
        var x = select.cloneNode(true);
        x.id = 'ncc' + i;
        x.name = 'ncc' + i;
        x.className = 'inp';
        x.setAttribute('data-index', i);
        td1.appendChild(x);

        var td2 = document.createElement("td");
        var select1 = document.getElementById('spncc0');
        var y = select1.cloneNode(true);
        y.id = 'spncc' + i;
        y.name = 'spncc' + i;
        y.className = 'inp';
        y.setAttribute('data-index', i);
        td2.appendChild(y);

        var td3 = document.createElement("td");
        var newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.id = 'sl' + i;
        newInput.name = 'sl' + i;
        newInput.className = 'inp';
        newInput.setAttribute('data-index', i);
        td3.appendChild(newInput);

        var td4 = document.createElement("td");
        var newInput2 = document.createElement('input');
        newInput2.type = 'text';
        newInput2.id = 'gia' + i;
        newInput2.name = 'gia' + i;
        newInput2.className = 'inp';
        newInput2.setAttribute('data-index', i);
        td4.appendChild(newInput2);

        var td5 = document.createElement("td");
        const deleteButton = document.createElement('button');
        deleteButton.textContent = "Xóa";
        deleteButton.id = i;
        deleteButton.className = 'sua-xoa';
        deleteButton.type = "button";
        deleteButton.addEventListener("click", function () {

            deleteRow(i);
        });
        td5.appendChild(deleteButton);

        // Thêm các cột vào hàng (tr)
        trElement.appendChild(td1);
        trElement.appendChild(td2);
        trElement.appendChild(td3);
        trElement.appendChild(td4);
        trElement.appendChild(td5);

        // Thêm hàng vào inputContainer
        inputContainer.appendChild(trElement);

    });

    function deleteInputsWithIndex(container, index) 
    {
        const inputsToDelete = container.querySelectorAll(`[data-index="${index}"]`);
        inputsToDelete.forEach((input) => {
            // Sử dụng phương thức remove() thay vì removeChild()
            input.remove();
        });
    }

    function deleteRow(id) {
        // Sử dụng chỉ mục của id để xóa các phần tử tương ứng
        deleteInputsWithIndex(inputContainer, id);
        var abc = document.getElementById('abc'+id);
        abc.value = 'xoa';
        var deleteId = document.getElementById('ma'+id);
        deleteId.style.display = "none";

        // Xóa nút xóa khỏi DOM
        var deleteButton = document.getElementById(id);
        if (deleteButton) {
            inputContainer.removeChild(deleteButton);
        }
    }  
    
</script>

<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        include "connect.php";
        $TongTien=0;
        $id=$_GET['ID'];echo $_POST['maxId'];echo $_POST['maxIdChange'];
        if($_POST['maxId']==$_POST['maxIdChange'])
        {
            for($i=0;$i<$_POST['maxId'];$i++)
            {
                if($_POST['abc'.$i]=='xoa')
                {
                    $sql1="DELETE FROM tbldonnhaphang WHERE MADNH='".$_POST['ma'.$i]."'";
                    mysqli_query($conn,$sql1);
                    continue;
                }
                else
                {
                    $sql="UPDATE `tbldonnhaphang` SET `NCC`='". $_POST['ncc'.$i] . "',`TENSP`='".$_POST['spncc'.$i]."',`SOLUONG`='". $_POST['sl'.$i] . "',`DONGIA`='". $_POST['gia'.$i] . "' WHERE MADNH='". $_POST['ma'.$i] . "'";
                    $result=mysqli_query($conn,$sql);
                    $TongTien+=intval($_POST['gia'.$i])*intval($_POST['sl'.$i]);
                }
            }
            $sql1="UPDATE `tblnhaphang` SET `TONGTIEN`='".$TongTien."' WHERE MANH='".$id."'";
            $result1=mysqli_query($conn,$sql1);
            if($result1)
            {
                echo "<script type='text/javascript'>alert('Sửa dữ liệu thành công')
                    window.location.href='home.php?page_layout=nhaphang';
                    </script>";
            }
            else
                echo "Lỗi".mysqli_error($conn);
        }
        else if($_POST['maxIdChange']<$_POST['maxId'])
        {
            $TongTien=0;
            for($i=0;$i<$_POST['maxIdChange'];$i++)
            {
                $TongTien+=intval($_POST['gia'.$i])*intval($_POST['sl'.$i]);
            }
            for($i=$_POST['maxIdChange'];$i<$_POST['maxId'];$i++)
            {
                if(!empty($_POST['ncc'.$i])&&isset($_POST['ncc'.$i]))
                {
                    $sql1="INSERT INTO `tbldonnhaphang`(`MANH`, `NCC`, `TENSP`, `SOLUONG`, `DONGIA`) VALUES ('". $id . "','". $_POST['ncc'.$i] . "','".$_POST['spncc'.$i]."','". $_POST['sl'.$i] . "','". $_POST['gia'.$i] . "')";
                    mysqli_query($conn,$sql1);
                    $TongTien+=intval($_POST['gia'.$i])*intval($_POST['sl'.$i]);
                }
            }
            $sql1="UPDATE `tblnhaphang` SET `TONGTIEN`='".$TongTien."' WHERE MANH='".$id."'";
            $result1=mysqli_query($conn,$sql1);
            if($result)
            {
                echo "<script type='text/javascript'>alert('Sửa dữ liệu thành công')
                    window.location.href='home.php?page_layout=nhaphang';
                    </script>";
            }
            else
                echo "Lỗi".mysqli_error($conn);
        }
    }
?>