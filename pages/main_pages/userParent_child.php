<?php
require '../../lib/functionUserParent.php';

session_start();
$ma = $_SESSION['MaPH'];


$maPH= $ma['MaPH'];


$tenPH = selecttenPH($connection, $maPH);

$listBill_CD = searchHDHocPhi($connection, 'Chưa đóng', $maPH);
$listBill_CN = searchHDHocPhi($connection, 'Còn nợ', $maPH);

$listChild = studentOfParent($connection, $maPH);
$listClassOpen = listDD($connection, 'Đang mở');
$listClassClose = listDD($connection, 'Đã đóng');
$listAbsent = listNgayNghi($connection);
$listMaHS = listMaHS($connection);
$listSchedules =  listSchedules($connection);
$listRequest  = selectdslk($connection, $maPH);
$detailParent = selectParent($connection, $maPH);

$jslistBill_CD = json_encode($listBill_CD);
$jslistBill_CN = json_encode($listBill_CN);

$jsdetailParent = json_encode($detailParent);
$jslistChild = json_encode($listChild);
$jstenPH = json_encode($tenPH);
$jslistClassOpen = json_encode($listClassOpen);
$jslistClassClose = json_encode($listClassClose);
$jslistAbsent = json_encode($listAbsent);
$jslistMaHS = json_encode($listMaHS);
$jslistSchedules = json_encode($listSchedules);
$jslistRequest = json_encode($listRequest);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['input-child'])) {
    $mahs = $_POST['input-child'];
    $tenph =  $tenPH[0]['TenPH'];
    $tenhs  = $_POST['name-child'];

    insertLienKet($mahs, $maPH, $tenhs, $tenph, 'ph', $connection);
    header("Location: userParent_child.php");
  }
  if (isset($_POST['accept-maHS'])) {
    $mahs = $_POST['accept-maHS'];
    deletedslk($connection,$mahs,$maPH);
    insertPHHS($mahs,$maPH,$connection);
    header("Location: userParent_child.php");;
  }

  if (isset($_POST['refuse-maHS'])) {
    $mahs = $_POST['refuse-maHS'];
    
    deletedslk($connection,$mahs,$maPH);
   
    header("Location: userParent_child.php");
  }
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
  <link rel="stylesheet" href="/assets/css/userParent_child.css">
  <link rel="stylesheet" href="../../assets/css/common.css">


  <title>Phụ huynh</title>
</head>

<body>

  <div id="menu-bar">

  </div>
  <div id="content">

    <div id="child">
      <h3>Con của phụ hunh</h3>
      <?php
      if (!$listChild) {
        echo ' <p style="font-style: italic;"> Phụ huynh chưa liên kết đến học viên nào ~</p>';
      } else {
        foreach ($listChild as $child) :

          echo '<p class="name-child">' . $child['TenHS'] . '</p>';
        endforeach;
      } ?>

      <div style="display:flex">
        <button id="btn-add-child" onclick="toggleDivLink()"> Thêm liên kết với học viên</button>
        <button type="button" id="btn-nofi"><img id="img-nofi" width="30px" src=<?php if (!$listRequest && !$listBill_CD && !$listBill_CN) echo '"../../assets/images/bell.png"';
                                                                                else echo '"../../assets/images/bell-1.png"' ?> alt=""></button>
      </div>
      <div id="div-link">
        <form action="" method="post" id="form-link">
          <input type="text" id="input-child" name="input-child" placeholder="Nhập mã học viên" required>
          <input type="hidden" id="name-child" name="name-child">
          <br><button type="submit" id="btn-link">Liên kết</button>
          <p id="err-mahs" style="color:red ; font-style:italic"></p>
        </form>

      </div>
    </div>
    <div id="infor">

      <ul class="tab">
        <li><a href="#" class="tablinks" onclick="openTab(event, 'tabpane1')">Thông tin cá nhân</a></li>
        <li><a href="#" class="tablinks" onclick="openTab(event, 'tabpane2')">Lớp học</a></li>
        <!-- <li><a href="#" class="tablinks" onclick="openTab(event, 'tabpane3')">Tab 3</a></li> -->
      </ul>

      <div id="tabpane1" class="tabcontent">
        <h2>Thông tin cá nhân</h2>

        <table style="margin-left: 15%; width:80%">
          <tbody id="tbody-infor"></tbody>

        </table>
      </div>

      <div id="tabpane2" class="tabcontent">
        <div class="tab-2">
          <button id="btn-class-active" class="tablinks-2" onclick="openTab_2(event, 'tab3')">Lớp đang hoạt động</button>
          <button class="tablinks-2" onclick="openTab_2(event, 'tab4')">Lớp đã hoàn thành</button>
        </div>

        <div id="tab3" class="tabpane">
          <div id="class-active">
            <h3>Lớp đang hoạt động</h3>
            <div id="container-class"></div>

          </div>
        </div>

        <div id="tab4" class="tabpane">
          <div id="class-close"></div>
          <h3>Lớp đã hoàn thành</h3>
          <div id="container-class-close"></div>
        </div>

      </div>

    </div>

  </div>


  <div id="div-nofi">
  <?php if (!$listRequest && !$listBill_CD && !$listBill_CN) echo 'Không có thông báo mới!' ?> </button>
  </div>

  <div class="add-success">
    <img src="../../assets/images/icon_success.png" alt="" style=" width: 40px;">
    <h3 id='tb1'></h3>
  </div>

</body>


<script>
  var tenPH = <?php print_r($jstenPH); ?>;
  var ds_con = <?php print_r($jslistChild); ?>;
  var ds_classOpen = <?php print_r($jslistClassOpen); ?>;
  var ds_classClose = <?php print_r($jslistClassClose); ?>;
  var ds_absent = <?php print_r($jslistAbsent); ?>;
  var ds_maHS = <?php print_r($jslistMaHS); ?>;
  var ds_schedule = <?php print_r($jslistSchedules); ?>;
  var ds_yeuCau = <?php print_r($jslistRequest); ?>;
  var detailParent = <?php print_r($jsdetailParent); ?>;


  var dsHoaDon_CD = <?php print_r($jslistBill_CD); ?>;
  var dsHoaDon_CN = <?php print_r($jslistBill_CN); ?>;


  const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeParent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userParent_child.php" style="color:darkcyan">Thông tin của con</a>
  <a class="menubar-nav  last-nav"  href="./userParent_Fee.php">Học phí của con</a>
  
  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenPH[0].TenPH + `</div>


      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" id ="a123">
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Parent.php">Thông tin cá nhân</a></li>
      
              <li class="menubar-dropdown-item">  <form action="" method="post"> <input type="submit" name ="btn-logout"  id ="btn-logout" value ="Đăng xuất" style="border: none;background-color: unset;"></form></li>          </ul>
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
    if (detailParent[0].GioiTinh == "Nam") {
    
        img2.src = "../../assets/images/Parent-male-icon.png";
    } else {
        
        img2.src = "../../assets/images/Parent-female-icon.png";
    }
</script>

<script src="../../assets/js/userParent_child.js"></script>

<!--boostrap.js-->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!--boostrap.js-->
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
<!--slick.js-->
<script type="text/javascript" src="../../plugins/slick-1.8.1/slick/slick.min.js"></script>



</html>