<?php
include "../../lib/FunctionClass2.php";
$malop = $_GET['malop'];
session_start();
$check = false;
if (isset($_SESSION['MaPH'])) {
    $check = true;
}

$maPH = $_SESSION['MaPH'];

$dataClass = dataClassById($malop, $connection);
$dataSchedules = dataSchedulesByMaLop($malop, $connection);
$nameTeacher = dataTeacherByMaLop($malop, $connection);
$result = listSchedules($connection);

$detailParent = selectParent($connection, $maPH['MaPH']);
$tenPH = selecttenPH($connection, $maPH['MaPH']);
$listBill_CD = searchHDHocPhi($connection, 'Chưa đóng', $maPH['MaPH']);
$listBill_CN = searchHDHocPhi($connection, 'Còn nợ', $maPH['MaPH']);
$listRequest = selectdslk($connection, $maPH['MaPH']);

$jsdetailParent = json_encode($detailParent);
$jstenPH = json_encode($tenPH);
$jslistBill_CD = json_encode($listBill_CD);
$jslistBill_CN = json_encode($listBill_CN);
$jslistRequest = json_encode($listRequest);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['accept-maHS'])) {
      $mahs = $_POST['accept-maHS'];
      deletedslk($connection, $mahs, $maPH['MaPH']);
      insertPHHS($mahs, $maPH['MaPH'], $connection);
      header("Location: userParent_Fee.php");
    }
  
    if (isset($_POST['refuse-maHS'])) {
      $mahs = $_POST['refuse-maHS'];
  
      deletedslk($connection, $mahs, $maPH['MaPH']);
  
      header("Location: userParent_Fee.php");
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
    <title>Chi tiết lớp học</title>
    <link rel="stylesheet" href="../../assets/css/manage.css">
    <link rel="stylesheet" href="../../assets/css/home.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <link rel="stylesheet" href="../../assets/css/common.css">
    <style>
        .hidden {
            display: none;
        }

        .buttonAdd {
            position: absolute;
            left: 30;
            top: 100;
        }

        /* box add lớp */
        #overlay {
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            transition: opacity 0.3s, visibility 0.3s;
        }

        #overlay.active {
            opacity: 1;
            visibility: visible;
        }

        #box {
            opacity: 0;
            transform: scale(1.5);
            transition: opacity 0.3s, transform 0.3s;
            background-color: #fff;
            overflow: auto;
            padding: 30px;
            border-radius: 5px;
        }

        #box.active {
            opacity: 1;
            transform: scale(1);
        }

        #box #close-btn {
            position: absolute;
            top: 3px;
            right: 3px;
            background: none;
            border: none;
            font-size: 50px;
            cursor: pointer;
            color: #0088cc;
        }
        .menubar-nav:hover {
      background-color: turquoise;
    }

    #btn-nofi {
      border: none;
      margin-left: 10px;
      background-color: white;
      position: absolute;
      z-index: 1000;
      top: 20px;
      right: 201px;
      background-color: unset;
    }


    #div-nofi {
      display: none;
      position: absolute;

      background-color: #f2f2f2;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 400px;
      height: 400px;
      max-height: 380px;
      background-color: lavender;
      overflow-y: auto;
      border: ridge;
      z-index: 1000;
      top: 47px;
      right: 225px;
    }

    #nofi {
      border: solid 2px;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 20px;
    }

    #nofi button {

      background-color: rgb(0 125 124);
      color: white;
      border: none;
      padding: 10px 20px;
      margin-right: 10px;
      cursor: pointer;
    }

    .menubar-nav:hover {
      background-color: turquoise;
    }
    #btn-logout{
        all:unset;
      
    border: none;
    background-color: unset;

    }
    #btn-logout:hover{
        cursor: pointer;
        background-color: #0d7cd0;
    }


        <?php if(isset($_SESSION['MaPH'])): ?>
            #buttonAdd{
                display: none;
            }
            <?php endif ?>
        
    </style>
</head>

<body>
    <header>
    </header>
    <main>
        <div>
            <div id="menu-bar">
                <a ></a>
                <!-- khi chưa đăng nhập -->
                <?php

                if (!$check) : ?>
                    <div class="PageMenuBar">
                        <a class="PageLogoWrap"  href="../home/home.php">
                            <img class="PageLogoImg" src="../../assets/images/logo-web.png" />
                        </a>
                        <div class="menubar-btnwrap">
                            <a href="../login_pages/login.php" class="PageLogoBtn">Login LoDuHi</a>
                        </div>
                    </div>
                <?php endif ?>

                <!-- khi đã đăng nhập -->
               
                
            </div>

            <!-- main -->

        </div>
        </div>
        <div class="modal-bg">

        </div>
        <div class="modal-content">
            <div class="container">
                <h1 style="text-align: center;color:#0088cc;">Thông tin chi tiết lớp học <?php echo $malop; ?></h1>
                <form id="form_delete" name="form_delete" method="post">
                    <table>
                        <tr>
                            <th style="color:#0088cc">Mã lớp:</th>
                            <td style="color: #0088cc" id="teacher-id"><?php echo $malop; ?></td>
                        </tr>
                        <tr>
                            <th style="color: #ffd95c">Tên lớp:</th>
                            <td style="color: #0088cc" id="teacher-gender" contenteditable="false"><?php echo $dataClass['TenLop']; ?></td>
                        </tr>
                        <tr>
                            <th style="color:#0088cc">Lứa tuổi:</th>
                            <td style="color: #0088cc" id="" contenteditable="false"><?php echo $dataClass['LuaTuoi']; ?></td>
                        </tr>
                        <tr>
                            <th style="color:#ffd95c">Thời gian bắt đầu khóa học:</th>
                            <td style="color: #0088cc" id="teacher-date" contenteditable="false"><?php echo convertDateFormat($dataClass['ThoiGian']); ?></td>
                        </tr>
                        <tr>
                            <th style="color:#0088cc">Lịch học:</th>
                            <td style="color: #0088cc" id="teacher-age" contenteditable="false">
                                <?php
                                foreach ($dataSchedules as $listschedules) {
                                    echo  $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
                                    echo "<br>";
                                }
                                ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th style="color:#ffd95c">Học phí:</th>
                            <td style="color: #0088cc" id="teacher-qq" contenteditable="false"><?php echo numberWithCommas($dataClass['HocPhi']); ?>VND</td>
                        </tr>
                        <tr>
                            <th style="color:#0088cc">Tổng số buổi đã dạy:</th>
                            <td style="color: #0088cc" id="" contenteditable="false"><?php echo $dataClass['SoBuoiDaToChuc']; ?></td>
                        </tr>
                        <tr>
                            <th style="color:#ffd95c">Tổng số buổi dạy:</th>
                            <td style="color: #0088cc" id="" contenteditable="false"><?php echo $dataClass['SoBuoi']; ?></td>
                        </tr>
                        <tr>
                            <th style="color:#0088cc">Số lượng học sinh đăng kí:</th>
                            <td style="color: #0088cc" id="" contenteditable="false"><?php echo $dataClass['SLHS']; ?></td>
                        </tr>
                        <tr>
                            <th style="color:#ffd95c">Số lượng học sinh tối đa:</th>
                            <td style="color: #0088cc" id="" contenteditable="false"><?php echo $dataClass['SLHSToiDa']; ?></td>
                        </tr>
                        <tr>
                            <th style="color:#0088cc">Tên giáo viên</th>
                            <td style="color: #0088cc" id="teacher-class" contenteditable="false">
                                <?php
                                foreach ($nameTeacher as $nameTeachers) {
                                    echo $nameTeachers['TenGV'];
                                };
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="color:#ffd95c">Trình đồ giáo viên :</th>
                            <td style="color: #0088cc">
                                <?php
                                foreach ($nameTeacher as $nameTeachers) {
                                    echo  $TeacherSalarie = $nameTeachers['TrinhDo'];
                                };
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="color: #0088cc">Khuyến mại :</th>
                            <td style="color: #0088cc">
                                <?php
                                $discount = getDiscount($malop, $connection);

                                if (empty($discount['GiamHocPhi'])) {
                                    echo '0%';
                                } else {
                                    echo $discount['GiamHocPhi'] . '%'.'    &emsp; &emsp; (Từ '.$discount['TGBatDau'].' đến '.$discount['TGKetThuc'].')';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        </div>
    </main>
    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>
    
</body>
<button type="button" id="btn-nofi"><img id="img-nofi" width="30px" src=<?php if (!$listRequest && !$listBill_CD && !$listBill_CN) {
                                                                            echo '"../../assets/images/bell.png"';
                                                                          } else {
                                                                            echo '"../../assets/images/bell-1.png"';
                                                                          }
                                                                          ?> alt=""></button>
  <div id="div-nofi">
    <?php if (!$listRequest && !$listBill_CD && !$listBill_CN) {
      echo 'Không có thông báo mới!';
    }
    ?> </button>
  </div>
<script>
    var tenPH = <?php print_r($jstenPH); ?>;
    var detailParent = <?php print_r($jsdetailParent); ?>;

    var ds_yeuCau = <?php print_r($jslistRequest); ?>;
    var dsHoaDon_CD = <?php print_r($jslistBill_CD); ?>;
    var dsHoaDon_CN = <?php print_r($jslistBill_CN); ?>;

    const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeParent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userParent_child.php" >Thông tin của con</a>
  <a class="menubar-nav  last-nav"  href="./userParent_Fee.php" >Học phí của con</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenPH[0].TenPH + `</div>
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" >
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Parent.php">Thông tin cá nhân</a></li>

            <li class="menubar-dropdown-item">  <form action="" method="post"> <input type="submit" name ="btn-logout"  id ="btn-logout" value ="Đăng xuất" style="border: none;background-color: unset;"></form></li>
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

    $(".menubar-drop-btn").onclick = () => {

      $(".menubar-dropdown-menu").classList.toggle("menubar-show")

    }


    var img2 = document.querySelector(".menubar-avt");
    if (detailParent[0].GioiTinh == "Nam") {

      img2.src = "../../assets/images/Parent-male-icon.png";
    } else {

      img2.src = "../../assets/images/Parent-female-icon.png";
    }

    var button = document.getElementById('btn-nofi');
    var hiddenDiv = document.getElementById('div-nofi');

    button.addEventListener('click', function() {
      hiddenDiv.style.display = hiddenDiv.style.display === 'block' ? 'none' : 'block';

    });


    var divNofiContainer = document.getElementById('div-nofi');

    ds_yeuCau.forEach(function(yeuCau) {

      var nofiDiv = document.createElement('div');
      nofiDiv.id = 'nofi';
      nofiDiv.innerHTML = '<p>Học viên ' + yeuCau.TenHS + ' đã gửi yêu cầu liên kết với bạn</p>' +
        '<button onclick="tuChoi(' + yeuCau.MaHS + ',' + yeuCau.MaPH + ')">Từ chối</button>' +
        '<button onclick="chapNhan(' + yeuCau.MaHS + ',' + yeuCau.MaPH + ')">Chấp nhận</button>';

      divNofiContainer.appendChild(nofiDiv);


    });

    dsHoaDon_CD.forEach(function(yeuCau) {
      yeuCau

      var nofiDiv = document.createElement('div');
      nofiDiv.id = 'nofi';
      nofiDiv.innerHTML = '<p> Hóa đơn ' + yeuCau.TenHD + ' (' + numberWithCommas(yeuCau.SoTienPhaiDong) + ' VND) của  Học viên ' + yeuCau.TenHS + '  chưa được thanh toán</p>'
      divNofiContainer.appendChild(nofiDiv);
    });



    dsHoaDon_CN.forEach(function(yeuCau) {

      var nofiDiv = document.createElement('div');
      nofiDiv.id = 'nofi';
      nofiDiv.innerHTML = '<p> Hóa đơn ' + yeuCau.TenHD + ' còn nợ (' + numberWithCommas(yeuCau.NoPhiConLai) + ' VND) của  Học viên ' + yeuCau.TenHS + '  chưa được thanh toán</p>'
      divNofiContainer.appendChild(nofiDiv);
    });


    function tuChoi(maHS, maPH) {
      var form = document.createElement('form');

      form.method = 'POST';
      form.name = 'refuse-form'

      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'refuse-maHS';
      input.value = maHS;
      form.appendChild(input);

      document.body.appendChild(form);
      form.submit();

    }

    function chapNhan(maHS, maPH) {


      var form = document.createElement('form');

      form.method = 'POST';
      form.name = 'accept-form'

      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'accept-maHS';
      input.value = maHS;
      form.appendChild(input);

      document.body.appendChild(form);
      form.submit();
    }

    function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  </script>
</script>

</html>