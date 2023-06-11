<?php
include "../../lib/FunctionClass2.php";
$malop = $_GET['malop'];
session_start();
$check = false;
if (isset($_SESSION['MaPH'])) {
    $check = true;
}
$dataClass = dataClassById($malop, $connection);
$dataSchedules = dataSchedulesByMaLop($malop, $connection);
$nameTeacher = dataTeacherByMaLop($malop, $connection);
$result = listSchedules($connection);
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
    
</script>

</html>