<?php
require '../../lib/functionUserTeacher.php';


session_start();
$maGV = $_SESSION['MaGV'];


$listBill  =  selectLuongGV($connection, $maGV);
$listSoBuoiDayAll =  selectSoBuoiDayAll($connection);
$tenGV = selectTenGV($connection,$maGV);
$detailTeacher = selectTeacher($connection, $maGV);

$jslistBill = json_encode($listBill);
$jslistSoBuoiDayAll = json_encode($listSoBuoiDayAll);
$jsmaGV  =  json_encode($maGV);
$jstenGV  =  json_encode($tenGV);
$jsdetailTeacher = json_encode($detailTeacher);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn-logout'])) {
  
      session_start();
      session_unset();
      session_destroy();
      header("Location: ../home/home.php");
    }
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/userTeacherWage.css">

    
    <link rel="stylesheet" href="../../assets/css/common.css">
    <title>Giáo viên</title>
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
        <p id="emty"></p>
    </div>




</body>


<script>
    var tenGV = <?php print_r($jstenGV); ?>; 
    var detailTeacher = <?php print_r($jsdetailTeacher); ?>;
    const authMenuBarHTMl = ` <div style= "position: absolute" class="PageMenuBar">
<a class="PageLogoWrap">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./homeTeacher.php" >Thông tin lớp dạy</a>
  <a class="menubar-nav  last-nav"  href="./userTeacher_wage.php" style="color:darkcyan">Lịch sử lương</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenGV[0].TenGV + `</div>
      
      
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" id ="a123">
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Teacher.php">Thông tin cá nhân</a></li>
      
              <li class="menubar-dropdown-item">  <form action="" method="post"> <input type="submit" name ="btn-logout"  id ="btn-logout" value ="Đăng xuất" style="border: none;background-color: unset;"></form></li>          </ul>
          </ul>
        </div>
        

    </div>
  </div>
</div>
  
</div>`
    //isAuthentication === true
    document.querySelector("#menu-bar").innerHTML = authMenuBarHTMl

var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)

$(".menubar-drop-btn").onclick = ()=>{
   
    $(".menubar-dropdown-menu").classList.toggle("menubar-show")
 
}
var img2 = document.querySelector(".menubar-avt");
    if (detailTeacher[0].GioiTinh == "Nam") {
    
        img2.src = "../../assets/images/Teacher-male-icon.png";
    } else {
        
        img2.src = "../../assets/images/Teacher-female-icon.png";
    }

    var dsHoaDon = <?php print_r($jslistBill); ?>;
    var dssoBuoiDay = <?php print_r($jslistSoBuoiDayAll); ?>;
    var MaGV  = <?php print_r($jsmaGV); ?>;
 
</script>

<script src="../../assets/js/userTeacherWage.js"></script>




</html>