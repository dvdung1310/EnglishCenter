<?php
require '../lib/functionStatistical.php';


$listCountUser = listCountUser($connection);
$listCountHSlk = listCountHSlk($connection);
$listCountPHlk = listCountPHlk($connection);
$listClassActive = listLopHDTheoThang($connection);
$listCountClassAcitve = listSoLopHD($connection);
$listCountGender = listSoNamNu($connection);
$listCountAge = listHSTheoTuoi($connection);
$listHSDangKyHoc = listHSDangKyHoc($connection);
$listHSTangTheoThang = listHSTangTheoThang($connection);
$listCountHSDD =  listCountHSDD($connection);
$listHSAbsent = listHSAbsent($connection);
$listCountClass = countClass($connection);




$jslistCountUser  = json_encode($listCountUser);
$jslistCountHSlk  = json_encode($listCountHSlk);
$jslistCountPHlk  = json_encode($listCountPHlk);
$jslistClassActive  = json_encode($listClassActive);
$jslistCountClassAcitve = json_encode($listCountClassAcitve);
$jslistCountGender = json_encode($listCountGender);
$jslistCountAge = json_encode($listCountAge);
$jslistHSTangTheoThang = json_encode($listHSTangTheoThang);
$jslistHSDangKyHoc = json_encode($listHSDangKyHoc);
$jslistCountHSDD = json_encode($listCountHSDD);
$jslistCountClass = json_encode($listCountClass);






?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý hệ thống giáo dục</title>
    <link rel="stylesheet" href="../assets/css/manage.css">
    <link rel="stylesheet" href="../assets/css/manageStatistical.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.3/dist/apexcharts.min.js"></script>

</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/logo-web.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="./ListClass.php">Quản lý lớp học</a></li>
                <li><a href="../manage/ManageStudent.php">Quản lý học viên</a></li>
                <li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
                <li><a href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
                <li><a href="../manage/manageFinance.php">Quản lý tài chính</a></li>
                <li><a style="color: #0088cc;" href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
                <li><a href="../pages/home/home.php" style="display: flex;"><img src="../assets/images/icon-logout.png" alt="" style="width:20px"></a></li>

            </ul>
        </nav>
    </header>
    <main>
        <div class="tab">
            <button class="tablinks" id='btn-tab1'>Thống kê tổng quan</button>
            <button class="tablinks" id='btn-tab2'>Thống kê tài chính</button>
           
        </div>

        <div style="display: flex;flex-direction: column;" id="content">
            <h2>Tổng quan người dùng:</h2>
            <div id='div-user' style="display: flex;">
                <div id="countUserChart">
                    <h3>Số lượng người dùng : </h3>
                </div>
                <div style="width:50%">
                    <h3> Tỷ lệ liên kết giữa phụ huynh và học sinh : </h3>
                    <div id="countHSlkChart"></div>
                    <div id="countPHlkChart"></div>
                </div>

            </div>
            <h2>Lớp học :</h2>
            <div id="div-class">
                <div style="position:relative ">
                    <div style="width: 100%">
                        <select id="select-year" style="width:100px">
                            <option value="">Chọn năm</option>
                            <?php for ($i = 2020; $i <= 2100; $i++) { ?>

                                <option value="<?php echo $i ?>" <?php if ($i == date("Y")) echo 'selected' ?>>
                                    <?php echo $i ?>
                                </option>
                            <?php } ?>
                        </select>

                        <canvas id='classActiveChart'> </canvas>
                    </div>
                    <div style="position:absolute; right: 100px; top:270px">
                            <div id = "class-detail"></div>
                    </div>

                </div>
            </div>
            <h2>Học viên :</h2>
            <div id="Student">
                <h3 id="total-student"></h3>
                <div style="display:flex">
                    <canvas style="max-width:400px; max-height:400px; margin-left:100px " id="genderChart"></canvas>

                    <div style="width:50%;margin-left: 250px;">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>

                <div>
                    <select id="select-year-hs" style="width:100px">
                        <option value="">Chọn năm</option>
                        <?php for ($i = 2020; $i <= 2100; $i++) { ?>

                            <option value="<?php echo $i ?>" <?php if ($i == date("Y")) echo 'selected' ?>>
                                <?php echo $i ?>
                            </option>
                        <?php } ?>
                    </select>
                    <canvas id="studentChart" style="max-height:500px"></canvas>
                </div>

                <div style="display:inline-flex">
                    <div style="width:40%">
                        <div  style="max-width:500px; max-height:500px;margin-left:150px " id="absentChart">

                        </div>
                        <h3 style="margin-left:200px">Tỷ lệ học sinh tham gia buổi học</h3>
                    </div>
                    <div style="width:40%;margin-left:200px;">
                    <h3 style="margin-left:150px" >Danh sách học sinh nghỉ học nhiều</h3>
                        <table>
                            <thead>
                                <th>Mã học viên</th>
                                <th>Tên học viên</th>
                                <th>Lớp</th>
                                <th>Số buổi</th>
                            </thead>
                                
                            <tbody style="max-height: 300px;overflow-y: auto; ">
                                <?php foreach ($listHSAbsent as $student) : ?>
                                    <tr> 
                                       
                                        <td><?php echo $student['MaHS']; ?></td>
                                        <td><?php echo $student['TenHS']; ?></td>
                                        <td><?php echo $student['MaLop']; ?></td>
                                        <td><?php echo $student['so']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div></div>



    </main>


    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>
</body>



<script>
    var countUser = <?php print_r($jslistCountUser); ?>;
    var countHSlk = <?php print_r($jslistCountHSlk); ?>;
    var countPHlk = <?php print_r($jslistCountPHlk); ?>;
    var countLopHD = <?php print_r($jslistCountClassAcitve); ?>;
    var ds_LopHD = <?php print_r($jslistClassActive); ?>;
    var countGender = <?php print_r($jslistCountGender); ?>;
    var countAge = <?php print_r($jslistCountAge); ?>;

    var ds_DangKyHoc = <?php print_r($jslistHSDangKyHoc); ?>;
    var ds_HSTang = <?php print_r($jslistHSTangTheoThang); ?>;
    var ds_HSDD = <?php print_r($jslistCountHSDD); ?>;
    var ds_tongLop = <?php print_r($jslistCountClass); ?>;

  
</script>



<script src="../../assets/js/manageStatistical.js"></script>

</html>