<?php
require '../../lib/functionUserTeacher.php';

// $data = json_decode(file_get_contents('php://input'), true);


// $maGV = $_POST['key1'];



// session_start();
// $maGV = $_SESSION['MaGV'];


$maGV = 18;


$listBill  =  selectLuongGV($connection, $maGV);
$listSoBuoiDayAll =  selectSoBuoiDayAll($connection);
$tenGV = selectTenGV($connection,$maGV);


$jslistBill = json_encode($listBill);
$jslistSoBuoiDayAll = json_encode($listSoBuoiDayAll);
$jsmaGV  =  json_encode($maGV);
$jstenGV  =  json_encode($tenGV);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/userTeacherWage.css">
    <title>Document</title>
</head>

<body>

    <div id="menu-bar">

    </div>
    <div id="content">
        <h1 style="margin-top: 70px;">Lịch sử nhận lương</h1>
        <table id="table-1">

            <thead id="thead-1">
                <tr>
                    <th data-column="0" style="width:20px" onclick="sortTable(0)">STT</th>
                    <th data-column="1" onclick="sortTable(1)">Mã hóa đơn</th>
                    <th data-column="2" onclick="sortTable(2)">Tên hóa đơn</th>
                    <th data-column="3" onclick="sortTable(3)">Thời gian</th>
                    <th data-column="4" onclick="sortTable(4)">Lớp </th>
                    <th data-column="5" onclick="sortTable(5)">Thời gian thanh toán</th>
                    <th data-column="6" onclick="sortTable(6)">Số tiền</th>

                </tr>
            </thead>
            <tbody class="tbody-1">


            </tbody>
            <tbody class="tbody-5">



            </tbody>

        </table>
    </div>




</body>


<script>
    var tenGV = <?php print_r($jstenGV); ?>; 
    const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" >
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav" href="homeTeacher.php">Thông tin lớp dạy</a>
  <a class="menubar-nav"  style="color:darkcyan" href="userTeacher_wage.php">Lịch sử lương</a>
  <a class="menubar-nav">Tab3</a>
  <a class="menubar-nav last-nav">Tab4</a>
  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">`+ tenGV[0].TenGV +`</div>
      <div class="dropdown">
          <button class="menubar-avt-wrap" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
            <li><a class="dropdown-item" href="#">Chi tiết lớp học</a></li>
            <li><a class="dropdown-item" href="#">Đăng xuất</a></li>
          </ul>
        </div>
    </div>
  </div>
</div>
  
</div>`

    //isAuthentication === true
    document.querySelector("#menu-bar").innerHTML = authMenuBarHTMl
    var dsHoaDon = <?php print_r($jslistBill); ?>;
    var dssoBuoiDay = <?php print_r($jslistSoBuoiDayAll); ?>;
    var MaGV  = <?php print_r($jsmaGV); ?>;
 
</script>

<script src="../../assets/js/userTeacherWage.js"></script>




</html>