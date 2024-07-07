<style>
    .inp{
        width: auto;
        max-width: 200px;
    }
    .inp2 {
        border: none;
        border-radius: 0px;
        border-bottom: 1px solid #000;
        outline: none;
        padding-bottom: 5px;
    }
    .main{
        display: block;
    }
    .form{
        display: block;
    }
</style>

<div class="sua">
    <form method="post" class="form" >
        <h2><label for="MaNH">Mã nhập:</label><input class="inp2" type="text" id="MaNH" name="MaNH" value="<?php if(isset($_POST['MaNH'])) echo $_POST['MaNH'] ?>"></h2>
        <div id="inputContainer">
            <?php
                if(isset($_POST['maxId']))
                {
                    for($i=0;$i<=$_POST['maxId'];$i++)
                    {
                        if(isset($_POST['ncc'.$i]))
                        {
                            echo '<select id="ncc'.$i.'" name="ncc'.$i.'" class="inp" onchange="tdsp(this,this.id)" data-index="'.$i.'">';
                            $sql1="SELECT * FROM tblncc";
                            $result2=mysqli_query($conn,$sql1);
                            while($row=mysqli_fetch_assoc($result2))
                            {
                                $selected = ($row["TENNCC"] == $_POST['ncc'.$i]) ? "selected" : "";
                                echo '<option value="' . $row["TENNCC"] . '" ' . $selected . '>' . $row["TENNCC"] . '</option>';
                            }
                
                            echo '</select>';
                            echo '<select id="spncc'.$i.'" name="spncc'.$i.'" class="inp" data-index="'.$i.'">';
                                $sql2="SELECT * FROM tblsanpham WHERE NCC='".$_POST['ncc'.$i]."'";
                                $result3=mysqli_query($conn,$sql2);
                                while($row=mysqli_fetch_assoc($result3))
                                {
                                    $selected = ($_POST['spncc'.$i] == $row["TENSP"]) ? "selected" : "rong";
                                    echo '<option value="' . $row["TENSP"] . '" ' . $selected . '>' . $row["TENSP"] . '</option>';
                                }
                            echo '</select>';
                            echo '<input placeholder="Số lượng" type="text" id="sl'.$i.'" name="sl'.$i.'" class="inp" value="'.$_POST['sl'.$i].'" data-index="'.$i.'">';
                            echo '<input  placeholder="Đơn giá" type="text" id="gia'.$i.'" name="gia'.$i.'" class="inp" value="'.$_POST['gia'.$i].'" data-index="'.$i.'">';
                            if($i==0)
                            {
                                echo '<br>';
                                continue;
                            }
                            else
                            {
                                echo '<button type="button" id="'.$i.'" onclick="deleteRow(this.id)">Xóa</button>';
                                echo '<input type="text" id="abc'.$i.'"  name="abc'.$i.'" hidden >';
                                echo '<br>';
                            }
                        }
                    }
                }
                else
                {
                    echo '<select id="ncc0" name="ncc0" class="ncc"  onchange="tdsp(this,this.id)" >';
                    $sql1="SELECT * FROM tblncc";
                    $result2=mysqli_query($conn,$sql1);
                    while($row=mysqli_fetch_assoc($result2))
                    {
                        echo '<option value="' . $row["TENNCC"] . '">' . $row["TENNCC"] . '</option>';
                    }
                    echo '</select>';
                    echo '<select id="spncc0" name="spncc0" class="sp" >';
                    echo '<option value="Iphone13">Iphone13</option>';
                    echo '<option value="Iphone14">Iphone14</option>';
                    echo '<option value="Iphone14">Iphone14</option>';
                    echo '</select>';
                    echo '<input type="text" id="sl0" name="sl0" class="sl" >';
                    echo '<input type="text" id="gia0" name="gia0" class="gia">';
                    echo '<br>';
                }
            ?>
        </div>
        <input type="hidden" id="maxIdInput" name="maxId" value="<?php echo (isset($_POST['maxId']))?$_POST['maxId']:'0'; ?>">
        
        <br>
        <?php 
            $error=0;
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if(empty($_POST['MaNH']))
                {
                    $error++;
                    echo '<p style="color:red">Mã nhập hàng bị trống </p>';
                }
                for($i=0;$i<=$_POST['maxId'];$i++)
                {
                    if(empty($_POST['sl'.$i]))
                    {
                        $error++;
                        echo '<p style="color:red"> Số lượng ở dòng '.($i+1).' bị trống </p>';
                    }
                    else if(!is_numeric($_POST['sl'.$i]))
                    {   
                        $error++;
                        echo '<p style="color:red"> Số lượng ở dòng '.($i+1).' phải là 1 số </p>';
                    }
                    else if($_POST['sl'.$i]<0)
                    {
                        $error++;
                        echo '<p style="color:red"> Số lượng ở dòng '.($i+1).' phải là số dương</p>';
                    }

                    if(empty($_POST['gia'.$i]))
                    {
                        $error++;
                        echo '<p style="color:red"> Giá ở dòng '.($i+1).' bị trống </p>';
                    }
                    else if(!is_numeric($_POST['gia'.$i]))
                    {   
                        $error++;
                        echo '<p style="color:red"> Giá ở dòng '.($i+1).' phải là 1 số </p>';
                    }
                    else if($_POST['gia'.$i]<0)
                    {
                        $error++;
                        echo '<p style="color:red"> Giá ở dòng '.($i+1).' phải là số dương</p>';
                    }
                }
            }
        ?>
        <p><b>Thêm mới dữ liệu</b>
        <button type="button" id="addInputBtn" class="btn">Thêm</button></p>
        <button type="submit" class="cn-button">Lưu</button>
        <button id="btnBack" class="cn-button">Quay Lại</button>

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

            // tạo mảng chứa sản phẩm cho nhà cung cấp
            $productNames = array();

            while ($row2 = mysqli_fetch_assoc($result3)) {
                $productNames[] = $row2["TENSP"];
            }

            echo "'" . $supplierName . "': ['" . implode("','", $productNames) . "'],\n";
        }
        ?>
    };
    

        // Thêm các sản phẩm tương ứng với ncc đã chọn
        var productOptions = products[selectedValue] || [];
        for (var i = 0; i < productOptions.length; i++) {
            var option = document.createElement('option');
            option.value = productOptions[i];
            option.textContent = productOptions[i];
            productSelect.appendChild(option);
        }
    }

    function deleteInputsWithIndex(container, index) 
    {
        const inputsToDelete = container.querySelectorAll(`[data-index="${index}"]`);
        inputsToDelete.forEach((input) => {
            container.removeChild(input);
        });
    }
    function deleteRow(id) 
    {
    // Sử dụng chỉ mục của id để xóa các phần tử tương ứng
        deleteInputsWithIndex(inputContainer, id);

        // Xóa nút xóa khỏi DOM
        var deleteButton = document.getElementById(id);
        if (deleteButton) {
            inputContainer.removeChild(deleteButton);
        }
    }

    const form = document.getElementById('myForm'); // Thay đổi ID tại đây
    const inputContainer = document.getElementById('inputContainer');
    const addInputBtn = document.getElementById('addInputBtn');
    const btnBack=document.getElementById('btnBack');
    var maxId=document.getElementById('maxIdInput').value;

    var i = Number(maxId);


    btnBack.addEventListener('click', function (event) {
        event.preventDefault(); // Ngăn form gửi lại trang 
        window.location.href = 'home.php?page_layout=nhaphang';
    });

    addInputBtn.addEventListener('click', function (event) {
        event.preventDefault(); 
        i++;
        if (i > maxId) {
            maxId = i; 
        }
        document.getElementById('maxIdInput').value = maxId;

        // Sau đó, bạn có thể thêm các phần tử <input> sau thẻ <br>
        var select=document.getElementById('ncc0');
        var x=select.cloneNode(true);
        x.id='ncc' + i;
        x.name = 'ncc' + i;
        x.className='inp';
        x.setAttribute('data-index', i);
        inputContainer.appendChild(x);

        var y=document.createElement('select');
        y.id='spncc' + i;
        y.name = 'spncc' + i;
        y.className='inp';
        y.setAttribute('data-index', i);
        var option = document.createElement("option");
        var option1 = document.createElement("option");
        var option2 = document.createElement("option");
        option.text = "Iphone13";
        option.value = "Iphone13";
        y.appendChild(option);
        option1.text = "Iphone14";
        option1.value = "Iphone14";
        y.appendChild(option1);
        option2.text = "Iphone15";
        option2.value = "Iphone15";
        y.appendChild(option2);
        inputContainer.appendChild(y);

        const newInput = document.createElement('input');
        newInput.type = 'text';
        //newInput.placeholder = `Nhập dữ liệu cho ID: ${'sl' + i}`;
        newInput.id = 'sl' + i;
        newInput.name = 'sl' + i;
        newInput.className='inp';
        newInput.setAttribute('data-index', i);
        inputContainer.appendChild(newInput);

        const newInput2 = document.createElement('input');
        newInput2.type = 'text';
        //newInput2.placeholder = `Nhập dữ liệu cho ID: ${'gia' + i}`;
        newInput2.id = 'gia' + i;
        newInput2.name = 'gia' + i;
        newInput2.className='inp';
        newInput2.setAttribute('data-index', i);
        inputContainer.appendChild(newInput2);

        const deleteButton = document.createElement('button');
        deleteButton.textContent = "Xóa";
        deleteButton.id = i;
        inputContainer.appendChild(deleteButton);
        deleteButton.addEventListener("click", function () {
            deleteInputsWithIndex(inputContainer, deleteButton.id);
            inputContainer.removeChild(deleteButton);
            inputContainer.removeChild(brElement);
        });
        function deleteInputsWithIndex(container, index) {
            const inputsToDelete = container.querySelectorAll(`[data-index="${index}"]`);
            inputsToDelete.forEach((input) => {
                container.removeChild(input);
            });
        }   

        var brElement = document.createElement("br");
        inputContainer.appendChild(brElement);
    });
    
    
</script>

<?php
    //include "connect.php";
    $sql3="SELECT * FROM tblncc";
    $result1=mysqli_query($conn,$sql3);  
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if($error==0)
        {
            $i=0;
            $TongTien=0;
            for($i=0;$i<=$_POST['maxId'];$i++)
            {
                if(!empty($_POST['ncc'.$i])&&isset($_POST['ncc'.$i]))
                {
                    $sql1="INSERT INTO `tbldonnhaphang`(`MANH`, `NCC`, `TENSP`, `SOLUONG`, `DONGIA`) VALUES ('". $_POST['MaNH'] . "','". $_POST['ncc'.$i] . "','".$_POST['spncc'.$i]."','". $_POST['sl'.$i] . "','". $_POST['gia'.$i] . "')";
                    mysqli_query($conn,$sql1);
                    $TongTien+=intval($_POST['gia'.$i])*intval($_POST['sl'.$i]);
                }
            }
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $Date = date("Y-m-d");
            $sql ="INSERT INTO `tblnhaphang`(`MANH`, `NGAYNHAP`, `TONGTIEN`) VALUES ('". $_POST['MaNH'] . "','$Date','".$TongTien."')";
            $result=mysqli_query($conn,$sql);
            if($result)
            {
                echo "<script type='text/javascript'>alert('Thêm dữ liệu thành công')
                    window.location.href='home.php?page_layout=nhaphang';
                </script>";
            }
            else
                echo "Lỗi ".mysqli_error($conn);
        }
    }
    
?>