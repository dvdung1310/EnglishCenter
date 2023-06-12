<?php
require '../lib/functionFin_History.php';



$listBill =  searchHistory($connection, '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    if (isset($_POST['refesh'])) {
        header("Location: manageHistoryFinance.php");
    }

    if (isset($_POST['search'])) {
        $key = trim($_POST['keyword']);
        $listBill = searchHistory($connection, $key);
    }




  
}

$jslistBill = json_encode($listBill);



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý hệ thống giáo dục</title>
    <link rel="stylesheet" href="../assets/css/manage.css">
    <link rel="stylesheet" href="../assets/css/manageFinance_History.css">

</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/logo-web.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="./ListClass.php">Quản lý lớp học</a></li>
                <li><a href="../manage/ManageStudent.php">Quản lý học viên</a></li>
                <li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
                <li><a href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
                <li><a  style="color: #0088cc;"href="../manage/ManageFinance.php">Quản lý tài chính</a></li>
                <li><a href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
                <li><a href="../pages/home/home.php" style="display: flex;"><img src="../assets/images/icon-logout.png" alt="" style="width:20px"></a></li>

            </ul>
        </nav>
    </header>
    <main>

        <div class="tab">
            <button class="tablinks" id='btn-tab1'>Thu học phí</button>
            <button class="tablinks" id='btn-tab2'>Chi phí</button>
            <button class="tablinks" id='btn-tab3'>Lịch sử thu chi</button>
           
        </div>
        <div id="nav-container-Tab2">

            <a href="./manageFinance_wageTea.php" id="btn-tab-luongGV">Lương giáo viên</a>
            <a href="./manageFinance_OtherFee.php" id="btn-tab-chiPhiKhac">Chi phí khác</a>
          

        </div>
  

        <div id="Tab1" class="tabcontent">
            <h1>Lịch sử thu chi</h1>
            <div class="search-container">
                <form id="form-search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 45%; margin: unset;display: inline-flex;" autocomplete="off">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value="<?php if(isset($_POST['keyword'])) echo  $_POST['keyword']?>">
                    <input type="submit" name="search" id="search" value="Tìm kiếm" style="width: 100px">
                    <button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
                </form>
                <form action="" style="width: 500px;">
                <div style="display:inline-flex ; align-items:baseline">
                    <h3 style="margin-right:5px">Từ :</h3>
                    <input type="date" id="date-from" style="width: 120px;height: 30px; font-size:16px" required>
                </div>

                <div style="display:inline-flex ; align-items:baseline">
                    <h3 style="margin-right:5px">đến :</h3>
                    <input type="date"  id="date-to" style="width: 120px;height: 30px; font-size:16px" required>
                </div>
                
                <button id="btn-filter" >Lọc</button>
                </form>
                <div style="display:inline-flex ">
                    <h3 style="margin-right:5px;    width: 138px;">Loại hóa đơn :</h3>
                    <select style=" border: groove;background-color: beige;font-size: 14px;padding:0; width:200px;height:50px" id="select-kind-bill">
                        <option value="">...</option>
                        <option value="chi">Hóa đơn chi</option>
                        <option value="thu">Hóa đơn thu</option>
                      
                    </select>
                </div>
                <!-- <div style="display:inline-flex">
                    <h3 style="margin-right:5px">Trạng thái :</h3>
                    <select style=" border: groove;background-color: beige;font-size: 14px;padding:0; width:200px;height:50px" id="select-status">
                        <option value="">...</option>
                        <option value="Chưa thanh toán">Chưa thanh toán</option>
                        <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                </div> -->
               
            </div>



            <div>
                <table id="table-1">
                    <?php $i = 1;
                    if (!$listBill) {
                        echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
                    }
                    ?>
                    <thead id="thead-1">
                        <tr>
                            <th data-column="0" style="width:100px" onclick="sortTable(0)">STT</th>
                            <th data-column="1" onclick="sortTable(1)">Tên hóa đơn</th>
                            <th data-column="2" onclick="sortTable(2)">Đối tượng</th>
                            <th data-column="3" onclick="sortTable(3)">Loại hóa đơn</th>
                            <th data-column="4" onclick="sortTable(4)">Thời gian</th>
                            <th data-column="5" onclick="sortTable(5)">Số tiền</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-1">

                    </tbody>

                    <tbody class="tbody-5">

                    </tbody>
                    
                </table>
            </div>
            <!-- Them hoa don -->
            




        </div>

        

        



    
        
    </main>

    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>
</body>




<script>
    var dsHoaDon = <?php print_r($jslistBill); ?>;
</script>

<script src="../../assets/js/manageFinance_History.js"></script>

</html>