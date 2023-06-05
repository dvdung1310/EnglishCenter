<?php
require '../lib/functionStatisticalFinance.php';


$listCountThu = listCountThu($connection);
$listCountChi = listCountChi($connection);
// $listCountPHlk = listCountPHlk($connection);
// $listClassActive = listLopHDTheoThang($connection);
// $listCountClassAcitve = listSoLopHD($connection);
// $listCountGender = listSoNamNu($connection);
// $listCountAge = listHSTheoTuoi($connection);
// $listHSDangKyHoc = listHSDangKyHoc($connection);
// $listHSTangTheoThang = listHSTangTheoThang($connection);
// $listCountHSDD =  listCountHSDD($connection);
// $listHSAbsent = listHSAbsent($connection);
// $listCountClass = countClass($connection);




$jslistCountThu  = json_encode($listCountThu);
$jslistCountChi  = json_encode($listCountChi);
// $jslistCountPHlk  = json_encode($listCountPHlk);
// $jslistClassActive  = json_encode($listClassActive);
// $jslistCountClassAcitve = json_encode($listCountClassAcitve);
// $jslistCountGender = json_encode($listCountGender);
// $jslistCountAge = json_encode($listCountAge);
// $jslistHSTangTheoThang = json_encode($listHSTangTheoThang);
// $jslistHSDangKyHoc = json_encode($listHSDangKyHoc);
// $jslistCountHSDD = json_encode($listCountHSDD);
// $jslistCountClass = json_encode($listCountClass);






?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý hệ thống giáo dục</title>
    <link rel="stylesheet" href="../assets/css/manage.css">
    <link rel="stylesheet" href="../assets/css/manageStatisticalFinance.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.3/dist/apexcharts.min.js"></script>

</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/Apollo-Logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../manage/ManageClass.php">Quản lý lớp học</a></li>
                <li><a href="../manage/ManageStudent.php">Quản lý học viên</a></li>
                <li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
                <li><a href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
                <li><a href="../manage/manageFinance.php">Quản lý tài chính</a></li>
                <li><a href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="tab">
            <button class="tablinks" id='btn-tab1'>Thống kê tổng quan</button>
            <button class="tablinks" id='btn-tab2'>Thống kê tài chính</button>
            <button class="tablinks" id='btn-tab3'>Tổng hợp thu chi</button>
            <button class="tablinks" id='btn-tab4'>Tab4</button>
            <button class="tablinks" id='btn-tab5'>Tab5</button>
        </div>

        <div style="display: flex;flex-direction: column;" id="content">
            <div>
                <select id="select-year-1" style="width:100px">
                    <option value="">Chọn năm</option>
                    <?php for ($i = 2020; $i <= 2100; $i++) { ?>

                        <option value="<?php echo $i ?>" <?php if ($i == date("Y")) echo 'selected' ?>>
                            <?php echo $i ?>
                        </option>
                    <?php } ?>
                </select>

                <canvas id="chart-1" style="max-height:500px ; max-width: 1500px"></canvas>

            </div>



        </div>

        <div></div>



    </main>


    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>
</body>



<script>
    var ds_countThu = <?php print_r($jslistCountThu); ?>;
    var  ds_countChi = <?php print_r($jslistCountChi); ?>;
</script>



<script src="../../assets/js/manageStatisticalFinance.js"></script>

</html>