<?php
include "../../lib/FunctionClass2.php";
$malop = $_GET['malop'];
session_start();
$mahs = "";
if (isset($_SESSION['MaHS']['MaHS'])) {
    $mahs = $_SESSION['MaHS']['MaHS'];
}
$resultHSLOP = setExits_hs_lop($mahs, $malop, $connection);
$checkregister = "";
$check = false;
if (isset($_SESSION['MaHS'])) {

    $check = true;
    $maHS = $_SESSION['MaHS'];
    $tenHS = selecttenHS($connection, $maHS['MaHS']);
$detailStudent = selectStudent($connection, $maHS['MaHS']);
$jstenHS = json_encode($tenHS);
$jsdetailStudent = json_encode($detailStudent);
$jscheck = json_encode($check);
}





$dataClass = dataClassById($malop, $connection);
$dataSchedules = dataSchedulesByMaLop($malop, $connection);
$nameTeacher = dataTeacherByMaLop($malop, $connection);
$result = listSchedules($connection);
$nameCondition = '';
if ($dataClass['TrangThai'] == 'Chưa mở') {
    $nameCondition = 'Chưa mở';
} else if ($dataClass['TrangThai'] == 'Đang mở') {
    $nameCondition = 'Đang mở';
} else {
    $nameCondition = 'Đã đóng';
}
if (isset($_POST['check'])) {
    if ($_SESSION['MaHS'] != null) {
        $mahs = $_SESSION['MaHS']['MaHS'];
        $maph = checkExitPH_HS($mahs, $connection);
        if ($maph) {

           
            $checkregister = createTabHS_LOP($mahs, $malop, $connection);
            
            $stRegister = $dataClass['SLHS'];
            setHSDANGKI($stRegister, $malop, $connection);

            if ($stRegister + 1 == $dataClass['SLHSToiDa']) {
                setSLHSToiDa($malop, $connection);
            }
          
        }
    } else {
        header("Location: ../login_pages/login.php");
        exit();
    }
}
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
    <title>Chi tiết lớp học</title>
    <link rel="stylesheet" href="../../assets/css/manage.css">
    <link rel="stylesheet" href="../../assets/css/home.css" />
    <link rel="stylesheet" href="../../assets/css/common.css">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>

    <style>
        .hidden {
            display: none;
        }

        .buttonAdd {
            position: absolute;
            left: 30;
            top: 100px;
            padding: 8px;

        }

        .buttonAdd p {
            margin: 0;
            padding: 3px;
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

        #showButtons {
            border: none;
            border: 1px solid #0088cc;
            font-size: 17px;
            background-color: #ffd95c;
            color: #0088cc;
        }

        #checkLoginButton {
            margin-top: 10px;
            margin-left: 50px;
            border: none;
            border: 1px solid #ffd95c;
            font-size: 15px;
            background-color: #0088cc;
            color: #ffd95c;
        }

        #noButton {
            margin-top: 10px;
            margin-left: 5px;
            border: none;
            border: 1px solid #ffd95c;
            font-size: 15px;
            background-color: #0088cc;
            color: #ffd95c;
        }



        .text-regsister {
            color: #0088cc;
            font-size: 18px;
            position: absolute;
            left: 30;
            top: 100px;
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
    </style>
</head>

<body>
    <header>
    </header>
    <main>
        <div>
            <div id="menu-bar">
                <!-- khi chưa đăng nhập -->
                <?php

                if (!$check) : ?>
                    <div class="PageMenuBar">
                        <a class="PageLogoWrap" href="../home/home.php">
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

            <div id="overlay">
                <div id="box">
                    <button id="close-btn">&times;</button>
                    <?php $maph = false;
                    if ($mahs != "") {
                        $maph = checkExitPH_HS($mahs, $connection);
                        $discount = discount($malop, $connection);
                        $day = date("Y/m/d");
                        $startTime = $discount['TGBatDau'];
                        $startTimeObj = new DateTime($startTime);
                        $endTime = $discount['TGKetThuc'];
                        $endTimeObj = new DateTime($endTime);
                        $price = $discount['GiamHocPhi'];
                        $pr = false;
                        if ((new DateTime($day)) >= $startTimeObj && (new DateTime($day)) <= $endTimeObj) {
                            $pr = true;
                            insertDiscountMahs($malop, $mahs, $price, $connection);
                        }
                    }
                    ?>
                    <?php if (!$check) : ?>
                        <div>
                            <p>Thông báo !</p>
                            <p>Bạn đã chưa đăng nhập tài khoản</p>
                            <p>Trang đăng nhập: <a style="color: #ffd95c;" href="../login_pages/login.php">Login</a></p>
                        </div>
                    <?php


                    elseif ($check && $maph) : ?>
                        <div>
                            <p>Thông báo !</p>
                            <p>Bạn đã đăng kí thành công</p>
                            <p><?php if ($pr) {
                                    echo "Bạn đã được khuyến mại : ";
                                    echo $price;
                                } ?></p>
                        </div>
                    <?php elseif (!$maph) : ?>
                        <div>
                            <p>Thông báo !</p>
                            <p>Bạn đã chưa liên kết tài khoản phụ huynh</p>
                        </div>
                    <?php endif ?>
                </div>
            </div>

        </div>
        </div>
        <?php if (!$resultHSLOP) : ?>
            <div class="buttonAdd">
                <button id="showButtons">
                    <p>Bạn muốn đăng kí lớp học</p>
                </button>
                <div id="buttonContainer" class="hidden">
                    <button id="checkLoginButton">Có</button>
                    <button id="noButton">Không</button>
                </div>
            </div>

        <?php endif ?>
        <?php if ($resultHSLOP) : ?>
            <div class="text-regsister">
                Lớp này bạn đã đăng kí
            </div>
            </div>

        <?php endif ?>
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
                    <input style="display: none;" type="text" id="" name="deleteClass" value="helloToiDepTraiQuaDi">
                </form>
            </div>
        </div>
        </div>
    </main>
    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>
</body>
<script>
    var check = <?php print_r($jscheck); ?>;
    var tenHS = <?php print_r($jstenHS); ?>;
    var detailStudent = <?php print_r($jsdetailStudent); ?>;
    if (check) {
        const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeStudent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./userStudent_class.php" >Thông tin lớp học</a>
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



        document.querySelector(".menubar-drop-btn").onclick = () => {

            document.querySelector(".menubar-dropdown-menu").classList.toggle("menubar-show")

        }

        var img2 = document.querySelector(".menubar-avt");
        if (detailStudent[0].GioiTinh == "Nam") {

            img2.src = "../../assets/images/Student-male-icon.png";
        } else {

            img2.src = "../../assets/images/Student-female-icon.png";
        }
}
</script>
<script>
    const openBtn = document.getElementById('checkLoginButton');
    const overlay = document.getElementById('overlay');
    const box = document.getElementById('box');
    const closeBtn = document.getElementById('close-btn');

    openBtn.addEventListener('click', () => {
        overlay.classList.add('active');
        box.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        overlay.classList.remove('active');
        box.classList.remove('active');
        location.reload();
    });

    $(document).ready(function() {
        $("#checkLoginButton").click(function() {
            var province_id = $(this).val();
            $.post(window.location.href, {
                check: province_id
            }, function(check) {
                setTimeout(function() {
                    document.documentElement.innerHTML = check;
                }, 30000); // Đợi 30 giây (30000ms) trước khi load lại trang
            });
        });
    });



    var noButton = document.getElementById('noButton');

    var showButton = document.getElementById('showButtons');
    var buttonContainer = document.getElementById('buttonContainer');

    showButton.addEventListener('click', function(event) {
        buttonContainer.classList.toggle('hidden');
        event.stopPropagation();
    });

    buttonContainer.addEventListener('click', function(event) {
        event.stopPropagation();
    });

    noButton.addEventListener('click', function() {
        buttonContainer.classList.toggle('hidden');
    });
</script>

</html>