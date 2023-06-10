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
            if ($checkregister) {
                $stRegister = $dataClass['SLHS'];
                setHSDANGKI($stRegister, $malop, $connection);
            } else {
                $checkregister = false;
            }
        }
    } else {
        header("Location: ../login_pages/login.php");
        exit();
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
                        <a class="PageLogoWrap">
                            <img class="PageLogoImg" src="../../assets/images/logo-web.png" />
                        </a>
                        <div class="menubar-btnwrap">
                            <a href="/pages/home/home.html" class="PageLogoBtn">Login LoDuHi</a>
                        </div>
                    </div>
                <?php endif ?>

                <!-- khi đã đăng nhập -->
                <?php
                if ($check) : ?>
                    <div class="PageMenuBar">
                        <a class="PageLogoWrap">
                            <img src="../../assets/images/logo-web.png" class="PageLogoImg" />
                        </a>
                        <div class="menubar-left">
                            <a class="menubar-nav">Tab1</a>
                            <a class="menubar-nav">Tab2</a>
                            <a class="menubar-nav">Tab3</a>
                            <a class="menubar-nav last-nav">Tab4</a>
                            <div class="menubar-info-wrap">
                                <div class="menubar-info">
                                    <div class="menubar-name"></div>
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

                    </div>
                <?php endif ?>
            </div>

            <!-- main -->

            <div id="overlay">
                <div id="box">
                    <button id="close-btn">&times;</button>
                    <?php $maph = false;
                    $maph = checkExitPH_HS($mahs, $connection);
                    $discount = discount($malop, $connection);
                    $day = date("Y/m/d");
                    $startTime = $discount['TGBatDau'];
                    $startTimeObj = DateTime::createFromFormat('Y-m-d', $startTime);
                    $endTime = $discount['TGKetThuc'];
                    $endTimeObj = DateTime::createFromFormat('Y-m-d', $endTime);
                    $price = $discount['GiamHocPhi'];
                    $pr = true;
                    if($day >= $startTimeObj && $day <= $endTimeObj){
                        $pr = true;
                        insertDiscountMahs($malop,$mahs,0,$price,$connection);
                    }
                    ?>
                    <?php if (!$check) : ?>
                        <div>
                            <p>Thông báo !</p>
                            <p>Bạn đã chưa đăng nhập tài khoản</p>
                        </div>
                    <?php


                    elseif ($check && $maph) : ?>
                        <div>
                            <p>Thông báo !</p>
                            <p>Bạn đã đăng kí thành công</p>
                            <p><?php if($pr){
                                echo "Bạn đã được khuyến mại : ";
                                echo $price;
                            }?></p>
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
                <button id="showButtons">Bạn muốn đăng kí lớp học</button>
                <div id="buttonContainer" class="hidden">
                    <button id="checkLoginButton">Có</button>
                    <button id="noButton">Không</button>
                </div>
            </div>

        <?php endif ?>
        <?php if ($resultHSLOP) : ?>
            <div>
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
                            <th style="color:#ffd95c">Thời gian tạo lớp:</th>
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