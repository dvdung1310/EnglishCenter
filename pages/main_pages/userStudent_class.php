<?php
require '../../lib/functionUserStudent.php';

session_start();
$ma = $_SESSION['MaHS'];

$maHS = $ma['MaHS'];



$tenHS = selecttenHS($connection, $maHS);

$listClassOpen = listDD($connection, $maHS, 'Đang mở');
$listClassClose = listDD($connection, $maHS, 'Đã đóng');
$listAbsent = listNgayNghi($connection,$maHS);
$listSchedules =  listSchedules($connection);
$detailStudent = selectStudent($connection, $maHS);


$jstenHS = json_encode($tenHS);
$jslistClassOpen = json_encode($listClassOpen);
$jslistClassClose = json_encode($listClassClose);
$jslistAbsent = json_encode($listAbsent);
$jslistSchedules = json_encode($listSchedules);
$jsdetailStudent = json_encode($detailStudent);


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
  <!-- bootstrap.css-->
  <!-- <link rel="stylesheet" href="../../plugins/bootstrap-5.2.3-dist/css/bootstrap.min.css" /> -->
  <!--slick.css-->
  <link rel="stylesheet" href="../../plugins/slick-1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="../../assets/css/home.css" />
  <!--Animated css-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="/assets/css/userStudent_class.css">
  <link rel="stylesheet" href="../../assets/css/common.css">


  <title>Học viên</title>
</head>

<body>

  <div id="menu-bar">

  </div>
  <div id="content">

    <ul class="tab">
      <li><a href="#" id="btn-1" class="tablinks" onclick="openTab(event, 'tabpane1')">Lớp dang theo học </a></li>
      <li><a href="#" class="tablinks" onclick="openTab(event, 'tabpane2')">Lớp đã hoàn thành</a></li>
      <!-- <li><a href="#" class="tablinks" onclick="openTab(event, 'tabpane3')">Tab 3</a></li> -->
    </ul>
    <div id="tabpane1" class="tabcontent">
      <div id="class-active">
        <h2>Lớp đang theo học</h2>
        <div id="container-class"></div>
      </div>
    </div>

    <div id="tabpane2" class="tabcontent">

      <div id="class-close">
      <h2>Lớp đã hoàn thành</h2>
      <div id="container-class-close"></div>
      </div>
    </div>
  </div>

  </div>



</body>


<script>
  var tenHS = <?php print_r($jstenHS); ?>;
  var detailStudent = <?php print_r($jsdetailStudent); ?>;

  var ds_classOpen = <?php print_r($jslistClassOpen); ?>;
  var ds_classClose = <?php print_r($jslistClassClose); ?>;
  var ds_absent = <?php print_r($jslistAbsent); ?>;
  var ds_schedule = <?php print_r($jslistSchedules); ?>;

  



  const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeStudent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userStudent_class.php" style="color:darkcyan">Thông tin lớp học</a>
  <a class="menubar-nav  last-nav" href="./userStudent_link.php">Liên kết với phụ huynh</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenHS[0].TenHS + `</div>
     
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" id ="a123">
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Student.php">Thông tin cá nhân</a></li>
      
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
   
    $(".menubar-dropdown-menu")[0].classList.toggle("menubar-show")
 
}

var img2 = document.querySelector(".menubar-avt");
    if (detailStudent[0].GioiTinh == "Nam") {
    
        img2.src = "../../assets/images/Student-male-icon.png";
    } else {
        
        img2.src = "../../assets/images/Student-female-icon.png";
    }

</script>

<script src="../../assets/js/userStudent_class.js"></script>

<!--boostrap.js-->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!--boostrap.js-->
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
<!--slick.js-->
<script type="text/javascript" src="../../plugins/slick-1.8.1/slick/slick.min.js"></script>



</html>