<?php
require '../../lib/functionUserParent.php';


// session_start();
// $maPH = $_SESSION['MaPH'];


 $maPH = 9;

 $tenPH = selecttenPH($connection,$maPH);

// $listClassActive  =  listClassOfTeacher($connection, $maGV, 'Đang mở');
// $listClassClose  =  listClassOfTeacher($connection, $maGV, 'Đã đóng');
// $listSchedules =  listSchedules($connection);
// $listStudentOfClass =  studentOfClass($connection, $maGV);
// $listDD =  listDD($connection, $maGV);


// $jslistDD =  json_encode($listDD);
// $jslistClassClose = json_encode($listClassClose);
// $jslistStudentOfClass = json_encode($listStudentOfClass);
// $jsmaGV  =  json_encode($maGV);
$jstenPH  =  json_encode($tenPH);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/userParent_child.css">
    <title>Phụ huynh</title>
</head>

<body>

    <div id="menu-bar">

    </div>
    <div id="content"></div>

   

    

</body>


<script>
    var tenPH = <?php print_r($jstenPH); ?>; 
    const authMenuBarHTMl = ` <div class="PageMenuBar">
<a class="PageLogoWrap">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userParent_child.php" style="color:darkcyan">Thông tin của con</a>
  <a class="menubar-nav"  href="#">Lịch sử lương</a>
  <a class="menubar-nav">Tab3</a>
  <a class="menubar-nav last-nav">Tab4</a>
  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">`+ tenPH[0].TenPH +`</div>
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

</script>

<script src="../../assets/js/userParent_child.js"></script>



</html>