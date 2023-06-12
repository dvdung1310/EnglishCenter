<?php
require '../../lib/functionUserStudent.php';

session_start();
$ma = $_SESSION['MaHS'];

$maHS = $ma['MaHS'];

$tenHS = selecttenHS($connection, $maHS);
$listParent = parentOfStudent($connection, $maHS);
$listMaPH = listMaPH($connection);
$listRequest  = selectdslk($connection,$maHS);
$detailStudent = selectStudent($connection, $maHS);

$jstenHS = json_encode($tenHS);
$jslistParent = json_encode($listParent);
$jslistMaPH= json_encode($listMaPH);
$jslistRequest = json_encode($listRequest);
$jsdetailStudent = json_encode($detailStudent);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['maPH-link'])) {
        $maph = $_POST['maPH-link'];
        $tenhs =  $tenHS[0]['TenHS'];
        $tenph  = $_POST['name-parent'];
    
        insertLienKet($maHS, $maph, $tenhs, $tenph, 'hs', $connection);
        header("Location: userStudent_link.php");
      }

      if (isset($_POST['accept-maPH'])) {
        $maph = $_POST['accept-maPH'];
        deletedslk($connection,$maHS,$maph);
        insertPHHS($maHS,$maph,$connection);
        header("Location: userStudent_link.php");
      }

      if (isset($_POST['refuse-maPH'])) {
        $maph = $_POST['refuse-maPH'];
        
        deletedslk($connection,$maHS,$maph);
       
        header("Location: userStudent_link.php");
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
    <link rel="stylesheet" href="/assets/css/userStudent_link.css">
    <link rel="stylesheet" href="../../assets/css/common.css">


    <title>Học viên</title>
</head>

<body>

    <div id="menu-bar">

    </div>
    <div id="content" style="display:flex">
        <div id="parent-container">
            <div style="width:80%">
                <h2>Phụ huynh đã liên kết</h2>
                <?php if (!$listParent) {
                    echo ' <p style="font-style: italic;"> Phụ huynh chưa liên kết đến học viên nào ~</p>';
                } else {
                    foreach ($listParent as $parent) :
                        echo '<div id="parent">
                        <table style="width:100%">
                            <tr>
                                <td>Tên:' . ' ' . $parent['MaPH'] . ' - ' . $parent['TenPH'] . '</td>
                                </tr>
                                <tr>
                                    <td style="width: 210px">Giới tính:' . ' ' . $parent['GioiTinh'] . '</td>
                                    <td>Tuổi:' . ' ' . $parent['Tuoi'] . '</td>
                                    </tr>
                                </table>
                            </div>';
                    endforeach;
                } ?>

            </div>

        </div>
        <div id="link-container">

            <h2>Liên kết phụ huynh</h2>

            <form action="" id="form-link" method="POST">
                <input type="text" id="maPH-link" name="maPH-link" placeholder="Nhập mã phụ huynh">
                <button type="submit" id="btn-link">Liên kết</button>
                <button type="button" id="btn-nofi"><img id="img-nofi" width="30px" src=<?php if(!$listRequest) echo '"../../assets/images/bell.png"'; else echo '"../../assets/images/bell-1.png"' ?> alt=""></button>
                <input type="hidden" id="name-parent" name="name-parent">
            </form>
            <p id="err" style="color:red ; font-style:italic; margin-left: 80px;"></p>
        </div>

    </div>

    <div id="div-nofi">
       
    </div>

    <div class="add-success">
    <img src="../../assets/images/icon_success.png" alt="" style=" width: 40px;">
    <h3 id='tb1'></h3>
  </div>


</body>


<script>
    var tenHS = <?php print_r($jstenHS); ?>;
    var ds_ph = <?php print_r($jslistParent); ?>;
    var ds_maPH = <?php print_r($jslistMaPH); ?>;
    var ds_yeuCau = <?php print_r($jslistRequest); ?>;
    var detailStudent = <?php print_r($jsdetailStudent); ?>;

    const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeStudent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userStudent_class.php">Thông tin lớp học</a>
  <a class="menubar-nav  last-nav" href="./userStudent_link.php"  style="color:darkcyan" >Liên kết với phụ huynh</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenHS[0].TenHS + `</div>
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
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

<script src="../../assets/js/userStudent_link.js"></script>

<!--boostrap.js-->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!--boostrap.js-->
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
<!--slick.js-->
<script type="text/javascript" src="../../plugins/slick-1.8.1/slick/slick.min.js"></script>



</html>