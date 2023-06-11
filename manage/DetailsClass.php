<?php
include "../lib/FunctionClass.php";
$malop = $_GET['maLop'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['deleteClass'])) {
        $result = deleteClassById($malop, $connection);
        header("Location: ListClass.php");
        exit();
    }


    if (isset($_POST['classcode'])) {
        $classcode = $_POST['classcode'];
        $classname = $_POST['classname'];
        $classAge = trim($_POST['classAge']);
        $classTimeOpen = $_POST['classTimeOpen'];
        $price = trim($_POST['price']);
        $numberlessons = trim($_POST['numberlessons']);
        $students = trim($_POST['students']);
        $SelectCondition = $_POST['SelectCondition'];
        updateClassbyID(
            $classcode,
            $classname,
            $classAge,
            $classTimeOpen,
            0,
            $students,
            $price,
            $numberlessons,
            0,
            $SelectCondition,
            $connection
        );
        $schedules0 = $_POST['schedules0'];

        if (isset($_POST['schedules1'])) {
            $schedules1 = $_POST['schedules1'];
        } else {
            $schedules1 = "";
        }
        if (isset($_POST['schedules2'])) {
            $schedules2 = $_POST['schedules2'];
        } else {
            $schedules2 = "";
        }
        $arr = array();
        $dem = 0;
        foreach ($dataSchedules as $ListSchedules) {
            $arr[$dem] = $ListSchedules['idSchedules'];
            $dem++;
        }

        if ($arr[0] != $schedules0) {
            updateClass_SchedulesByID($malop, $arr[0], $schedules0, $connection);
        }

        if ($schedules1 != "") {
            if ($arr[1] != $schedules1) {
                updateClass_SchedulesByID($malop, $arr[1], $schedules1, $connection);
            }
        }
        if ($schedules2 != "") {
            if ($arr[2] != $schedules2) {
                updateClass_SchedulesByID($malop, $arr[2], $schedules2, $connection);
            }
        }
        // kiem tra giao vien cos trungf vs giaos vien dc sua ko 
        if (isset($_POST['teachers'])) {
            $newTeacher = $_POST['teachers'];
        }
        foreach ($nameTeacher as $nameTeachers) {
            $teacher =  $nameTeachers['MaGV'];
            $TeacherSalarie = $nameTeachers['TienTraGV'];
        };

        if (isset($_POST['TeacherSalarie'])) {
            $newTeacherSalarie = $_POST['TeacherSalarie'];
        }
        updateClass_TeacherByID($malop, $teacher, $newTeacher, $TeacherSalarie, $newTeacherSalarie, $connection);

        if(isset($_POST['startDiscount'])){
            $startDiscount = $_POST['startDiscount'];
        }else{
            $startDiscount = '2023-1-1';
        }

        if(isset($_POST['endDiscount'])){
            $endDiscount = $_POST['endDiscount'];
        }else{
            $endDiscount = '2023-1-1';
        }

        if(isset($_POST['discountpercent'])){
            $Discount = $_POST['discountpercent'];
        }else{
            $Discount = 0;
        }

        editDiscountFull($malop,$startDiscount,$endDiscount,$Discount,$connection);

        header("Location: DetailsClass.php?maLop=$classcode");
        exit();
    }

    if (isset($_POST['discount1'])) {
        $listStudents = ListStudentByClass($malop, $connection);
        $i = 1;
        foreach ($listStudents as $list) {
            $mahsDiscount = $list['MaHS'];
            $x = 'discount' . $i++;
            $discount = $_POST[$x];
            editDiscount($discount, $mahsDiscount, $malop, $connection);
        }
        header("Location: DetailsClass.php?maLop=$malop");
        exit();
    }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết lớp học</title>
    <link rel="stylesheet" href="../assets/css/manage.css">
    <link rel="stylesheet" href="../assets/css/manageClass.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <style>
        /* .checkbox 
  display: none; /* Ẩn checkbox gốc */
        .checkbox {
            display: none;
        }

        .checkbox+label {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #999;
            border-radius: 50%;
            cursor: pointer;
        }

        .green+label {
            background-color: #3cb371;
            /* Màu xanh */
            border-color: #3cb371;
        }

        .green+label::before {
            content: "\2713";
            /* Dấu tích unicode */
            color: #fff;
            font-size: 14px;
            text-align: center;
            line-height: 20px;
        }

        label::before {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            text-align: center;
            line-height: 20px;
        }

        .red+label {
            background-color: #ff0000;
            /* Màu đỏ */
            border-color: #ff0000;
        }

        .red+label::before {
            content: "\2717";
            /* Dấu tích unicode */
            color: #fff;
            font-size: 14px;
            text-align: center;
            line-height: 20px;
        }

        .squaredcheck {
            display: flex;
            align-items: center;
        }

        <?php
        if($dataClass['TrangThai'] == 'Chưa mở'):?>
            #piechart_3d{
                display: none;
            }
        <?php endif ?>
        

        */
    </style>
</head>

<body>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <header>
        <div class="logo">
            <img src="../assets/images/Apollo-Logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a style="color: #0088cc;" href="../manage/ListClass.php">Quản lý lớp học</a></li>
                <li><a href="#">Quản lý học viên</a></li>
                <li><a href="#">Quản lý giáo viên</a></li>
                <li><a href="#">Quản lý phụ huynh</a></li>
                <li><a href="#">Quản lý tài khoản</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Thong tin chi tiet -->
        <div class="modal-bg">
            <!-- <?php
                    $listStudents = ListStudentByClass($malop, $connection);
                    $i = 1;
                    foreach ($listStudents as $list) {
                        $mahsDiscount = $list['MaHS'];
                        $x = 'discount' . $i++;
                        $discount = $_POST[$x];
                        echo $x;
                        echo '<br>';
                        echo $mahsDiscount;
                        echo '<br>';
                        echo $discount;
                        echo '<br>';
                        // editDiscount($discount,$mahsDiscount,$malop,$connection);
                    }
                    ?> -->
            <div class="modal-content">
                <div class="container">
                    <h1 style="text-align: center;color:#0088cc;">Thông tin chi tiết lớp học <?php echo $malop; ?></h1>
                    <form id="form_delete" name="form_delete" method="post">
                        <table>
                            <tr>
                                <th>Mã lớp:</th>
                                <td id="teacher-id"><?php echo $malop; ?></td>
                            </tr>
                            <tr>
                                <th>Tên lớp:</th>
                                <td id="teacher-gender" contenteditable="false"><?php echo $dataClass['TenLop']; ?></td>
                            </tr>
                            <tr>
                                <th>Lứa tuổi:</th>
                                <td id="" contenteditable="false"><?php echo $dataClass['LuaTuoi']; ?></td>
                            </tr>
                            <tr>
                                <th>Thời gian tạo lớp:</th>
                                <td id="teacher-date" contenteditable="false"><?php echo convertDateFormat($dataClass['ThoiGian']); ?></td>
                            </tr>
                            <tr>
                                <th>Lịch học:</th>
                                <td id="teacher-age" contenteditable="false">
                                    <?php
                                    foreach ($dataSchedules as $listschedules) {
                                        echo  $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
                                        echo "<br>";
                                    }
                                    ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>Học phí/buổi:</th>
                                <td id="teacher-qq" contenteditable="false"><?php echo numberWithCommas($dataClass['HocPhi']); ?>VND</td>
                            </tr>
                            <tr>
                                <th>Tổng số buổi đã dạy:</th>
                                <td id="" contenteditable="false"><?php echo $dataClass['SoBuoiDaToChuc']; ?></td>
                            </tr>
                            <tr>
                                <th>Tổng số buổi học:</th>
                                <td id="" contenteditable="false"><?php echo $dataClass['SoBuoi']; ?></td>
                            </tr>
                            <tr>
                                <th>Số lượng học sinh đăng kí:</th>
                                <td id="" contenteditable="false"><?php echo $dataClass['SLHS']; ?></td>
                            </tr>
                            <tr>
                                <th>Số lượng học sinh tối đa:</th>
                                <td id="" contenteditable="false"><?php echo $dataClass['SLHSToiDa']; ?></td>
                            </tr>
                            <tr>
                                <th>Tên giáo viên</th>
                                <td id="teacher-class" contenteditable="false">
                                    <?php
                                    foreach ($nameTeacher as $nameTeachers) {

                                        echo $nameTeachers['TenGV'];
                                    };
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Lương giáo viên/buổi :</th>
                                <td>
                                    <?php
                                    foreach ($nameTeacher as $nameTeachers) {
                                        $TeacherSalarie = $nameTeachers['TienTraGV'];
                                    };

                                    echo numberWithCommas($TeacherSalarie);
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Khuyến mại : </th>
                                <td>
                                <?php
                                $discount = getDiscount($malop,$connection);
                               
                                if(empty($discount['GiamHocPhi'])){
                                    echo '0%';
                                }else{
                                    echo $discount['GiamHocPhi'].'%';
                                }                                
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <input style="display: none;" type="text" id="" name="deleteClass" value="helloToiDepTraiQuaDi">
                    </form>
                    <div class="detailButton">
                        <input type="submit" id='delete' name="delete" value="Xóa Lớp">
                        <button id="open-btn">Sửa Lớp</button>
                        <button id="opten-listStudents">Danh sách học sinh</button>
                        <button id="opten-listAttendance">Quản lý điểm danh</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- sửa thông tin lớp -->
        <div id="overlay">
            <div id="box">
                <button id="close-btn">&times;</button>
                <div class="">
                    <h1 style="color: #0088cc;">Sửa lớp học</h1>
                    <form id="form_edit" name="form_edit" method="post">
                        <label for="classcode">Mã lớp:<label id="lbclasscode" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="classcode" name="classcode" readonly value="<?php echo $malop ?>">

                        <label for="classname">Tên lớp:<label id="lbclassname" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="classname" name="classname" value="<?php echo $dataClass['TenLop']; ?>">

                        <label for="classAge">Lứa tuổi:<label id="lbclassAge" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="classAge" name="classAge" value="<?php echo $dataClass['LuaTuoi']; ?>">

                        <label for="classTimeOpen">Thời gian tạo lớp:<label id="lbclassTimeOpen" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="date" id="classTimeOpen" name="classTimeOpen" value="<?php echo $dataClass['ThoiGian']; ?>">
                        <br>

                        <label for="schedules">Lịch học:<label id="lbschedules" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <br>
                        <?php $i = 0 ?>
                        <?php foreach ($dataSchedules as $listschedules) :
                            $maLich = $listschedules['idSchedules'];
                        ?>
                            <select name="schedules<?php echo $i; ?>" id="schedules<?php echo $i; ?>">
                                <option value="<?php echo $maLich ?>">
                                    <?php echo  $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time']; ?>
                                </option>
                                <?php foreach ($result as $results) :
                                    $maSchedules = $results['idSchedules'];
                                ?>
                                    <option id="" value="<?php echo $maSchedules ?>">
                                        <?php echo  $results['day_of_week'] . ' - ' . $results['start_time'] . '-' . $results['end_time']; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <br>
                            <?php $i++; ?>
                        <?php endforeach ?>

                        <br>
                        <label for="price">Học phí:<label id="lbprice" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="price" name="price" value="<?php echo $dataClass['HocPhi']; ?>">

                        <label for="numberlessons">Tổng số buổi học:<label id="lbnumberlessons" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="numberlessons" name="numberlessons" value="<?php echo $dataClass['SoBuoi']; ?>">

                        <label for="students">Số lượng sinh viên tối đa:<label id="lbstudents" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="students" name="students" value="<?php echo $dataClass['SLHSToiDa']; ?>">

                        <label for="teacher">Giáo viên:<label id="lbteacher" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <br><select name="teachers" id="teachers">
                            <option value="<?php
                                            foreach ($nameTeacher as $nameTeachers) {
                                                echo $nameTeachers['MaGV'];
                                            };
                                            ?>">
                                <?php
                                foreach ($nameTeacher as $nameTeachers) {
                                    echo $nameTeachers['TenGV'] . ' - ' . $nameTeachers['TrinhDo'];
                                };
                                ?>
                            </option>
                            <?php $listTeacher = listTeacher($connection); ?>
                            <?php foreach ($listTeacher as $listTeachers) : ?>
                                <option value="<?php echo $listTeachers['MaGV'] ?>">
                                    <?php echo $listTeachers['TenGV'] . ' - ' . $listTeachers['TrinhDo'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="TeacherSalarie">Lương giáo viên:<label id="lbTeacherSalarie" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <input type="text" id="TeacherSalarie" name="TeacherSalarie" value="<?php
                                                                                            foreach ($nameTeacher as $nameTeachers) {
                                                                                                $TeacherSalarie = $nameTeachers['TienTraGV'];
                                                                                                if ($TeacherSalarie == null) {
                                                                                                    $TeacherSalarie = 0;
                                                                                                }
                                                                                            };

                                                                                            echo $TeacherSalarie;
                                                                                            ?>">
                        <br>
                        <label for="condition">Trạng thái:<label class="lbStyle" id="lbcondition" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <br><select name="SelectCondition" id="SelectCondition">
                            <option value="<?php echo $dataClass['TrangThai'] ?>">
                                <?php echo $nameCondition ?>
                            </option>
                            <option value="Chưa mở">Chưa mở</option>
                            <option value="Đang mở">Đang mở</option>
                            <option value="Đã đóng">Đã đóng</option>
                        </select>
                        <br>
                        <label for="condition">Giảm giá:<label class="lbStyle" id="lbcondition" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <p>
                        <?php
                                $discount = getDiscount($malop,$connection);
                               
                                if(empty($discount['GiamHocPhi'])){
                                    echo '0%';
                                }
                                ?>
                                <?php
                                if(empty($discount['GiamHocPhi'])):?>
                                 <button style="background-color: chartreuse; border: 1px solid #fff; border-radius:5px ; padding: 5px 4px;" type="button" onclick="addDiscount()">Thêm khuyến mại</button>
                                <div id="addDiscount">
                               </div>

                               <?php else: ?><br>
                                
                                <label for=""><label class="lbStyle" id="lbdiscount" style="color:red; font-size:13px ; font-style: italic "></label></label>
                              Thời gian bắt đầu : <input type="date" name="startDiscount" id="startDiscount" value="<?php echo $discount['TGBatDau']?>"><br>
                              Thời gian kết thúc : <input type="date" name="endDiscount" id="endDiscount" value="<?php echo $discount['TGKetThuc']?>"><br>
                              Khuyến mại : <input type="text" name="discountpercent" id="discountpercent" style="width: 40%;" value="<?php echo $discount['GiamHocPhi']?>">
                              <label id="lbvv1"></label>
                               <?php endif ?>

                               

                            
                                  
                        </p>
                        


                        <input type="submit" id='update' name="update" value="Sửa">
                    </form>

                    <div id="card-container"></div>
                </div>
            </div>
        </div>



        <!-- Danh sách học sinh -->
        <div id="overlayStudent">
            <div id="boxStudent">
                <button id="closebtnstudents">&times;</button>
                <div class="">
                    <h1 style="color: #0088cc;">Danh sách học sinh lớp <?php echo $malop ?></h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Họ và tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Tổng số buổi nghỉ học</th>
                                <th>Giảm học phí</th>
                            </tr>
                        </thead>
                        <form id="form_discount" name="form_discount" method="post">
                            <tbody>
                                <?php $listStudents = ListStudentByClass($malop, $connection);
                                $jsonListStudents = json_encode($listStudents);
                                $discountNumber = 1;
                                ?>
                                <?php foreach ($listStudents as $data) : ?>
                                    <tr>
                                        <td><?php echo $data['TenHS'] ?></td>
                                        <td><?php echo convertDateFormat($data['NgaySinh']) ?></td>
                                        <td><?php echo $data['GioiTinh'] ?></td>
                                        <td><?php echo $data['DiaChi'] ?></td>
                                        <td><?php echo $data['SDT'] ?></td>
                                        <td><?php
                                            $mahs = $data['MaHS'];
                                            $numberAbsences = numberAbsences($mahs, $malop, $connection);
                                            echo $numberAbsences['Absences'];
                                            ?></td>
                                        <td>
                                            <input name="discount<?php echo $discountNumber++ ?>" style="border:none" type="text" placeholder="<?php
                                                                                                                                                $discount = discount($mahs, $malop, $connection);
                                                                                                                                                echo $discount['GiamHocPhi'];
                                                                                                                                                echo '%';
                                                                                                                                                ?>">
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <input type="submit" id="discount" value="Sửa">
                        </form>
                    </table>
                </div>
            </div>
        </div>

        <!-- dữ liệu điểm danh của lớp  -->
        <div id="overlayAttendance">
            <div id="boxAttendance">
                <button id="closebtnAttendance">&times;</button>
                <div class="">
                    <h1 style="color: #0088cc;">Quản lý điểm danh lớp <?php echo $malop ?></h1>
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thời gian</th>
                                <th>Sỉ số</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $listTime = ListTimeAttendance($malop, $connection);
                            $j = 1;
                            ?>
                            <?php foreach ($listTime as $data) : ?>
                                <tr id='time<?php echo $j ?>' onclick="showDetails(<?php echo $j; ?>)">
                                    <td><?php echo $j++ ?></td>
                                    <td><?php echo convertDateFormat($data['ThoiGian']) ?></td>
                                    <td><?php
                                        $totalStudent = TotalStudentByTime($data['ThoiGian'], $connection);
                                        echo $totalStudent['total'] . '/' . $dataClass['SLHS']  ?></td>
                                </tr>

                            <?php endforeach ?>

                        </tbody>
                    </table>

                    <!-- hiện ra box của time chi tiết -->
                    <?php $j = 1;
                    foreach ($listTime as $data) :
                        $maTime = $data['ThoiGian'];
                    ?>
                        <div class="detailTimeAttendance" id="details-<?php echo $j ?>">
                            <div id="boxTime<?php echo $j ?>">
                                <button id="closebtnboxTime<?php echo $j ?>">&times;</button>
                                <div class="">
                                    <h1>Chi tiết điểm danh của ngày </h1>
                                    <h2><?php echo $data['ThoiGian']; ?></h2>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã học sinh</th>
                                                <th>Tên học sinh</th>
                                                <th>Tham gia lớp học</th>
                                            </tr>
                                        </thead>
                                        <form id="dd" name="dd" method="post">
                                            <tbody>
                                                <?php $k = 1;
                                                $getCodeStudentByTimeandCodeClass = getCodeStudentByTimeandCodeClass($malop, $maTime, $connection);
                                                foreach ($getCodeStudentByTimeandCodeClass as $dataStudentTime) : ?>
                                                    <tr>
                                                        <td><?php echo $k++ ?></td>
                                                        <td><?php echo $dataStudentTime['MAHS'] ?></td>
                                                        <td><?php echo  getStudentByid($dataStudentTime['MAHS'], $connection)['TenHS']; ?></td>
                                                        <td>
                                                            <div class="squaredcheck">
                                                                <input onclick="showCheckBox(<?php echo $dataStudentTime['MAHS']; ?>)" <?php echo ($dataStudentTime['dd'] == 1) ? 'checked' : ''; ?> type="checkbox" id="squaredcheck<?php echo $dataStudentTime['MAHS'] ?>" id="<?php echo $dataStudentTime['MAHS']; ?>" name="<?php echo $dataStudentTime['MAHS']; ?>" value="<?php echo $dataStudentTime['dd']; ?>" class="checkbox <?php echo ($dataStudentTime['dd'] == 1) ? 'green' : 'red'; ?>">
                                                                <?php echo ($dataStudentTime['dd'] == 1) ? 'có' : 'không'; ?>
                                                                <label for="squaredcheck<?php echo $dataStudentTime['MAHS'] ?>"></label>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                            <?php
                                            $arr = array();
                                            $dem = 0;
                                            foreach ($getCodeStudentByTimeandCodeClass as $dataTime) {
                                                $arr[$dem] = $dataTime['MAHS'];
                                                $dem++;
                                            }
                                            $listDD = json_encode($arr);
                                            ?>
                                            <input type="submit" id="submitDiemDanh" value="Sửa" name="submitDiemDanh">
                                        </form>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php $j++ ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>



    </main>
    <!-- thống kê -->
    <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Đi học', 'Nghỉ học'],
                <?php $a = getCountDD(1, $malop, $connection);
                $b = getCountDD(0, $malop, $connection)
                ?>['Đi học', <?php echo $a['dihoc'] ?>],
                ['Nghỉ học', <?php echo $b['dihoc'] ?>],
            ]);

            var options = {
                title: 'Thống kê tỉ lệ học sinh đi học của lớp <?php echo $malop ?>',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>

    <div class="delete-Option">
        <h2 style="color: #fff;">Bạn có chắc chắn xóa lớp không</h2>
        <button id="yesDelete">Có</button>
        <button id="noDelete">Không</button>
    </div>

    <div class="delete-success">
        <img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
        <h3>Xóa lớp thành công!</h3>
    </div>
    <div class="update-success">
        <img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
        <h3>Thay đổi thành công!</h3>
    </div>
    <script src="../assets/js/DetailClass.js"></script>
</body>
<script>
    function showDetails(id) {
        var detailsBox = document.getElementById('details-' + id);
        const boxTime = document.getElementById('boxTime' + id);
        detailsBox.classList.add('active');
        boxTime.classList.add('active');

        const closebtnboxTime = document.getElementById('closebtnboxTime' + id);
        closebtnboxTime.addEventListener('click', () => {
            detailsBox.classList.remove('active');
            boxTime.classList.remove('active');
        });
    }

    function showCheckBox(id) {
        var checkbox = document.getElementById('squaredcheck' + id);
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                this.classList.add('green');
            } else {
                this.classList.remove('green');
            }
        });

    };

    var jsonListStudents = <?php echo $jsonListStudents ?>;
    console.log(jsonListStudents);
    const submit_discount = document.getElementById('discount');
    submit_discount.addEventListener('click', function(event) {
        const formdiscount = document.getElementById('form_discount');
        event.preventDefault();
        // for(var i = 1 ; i < jsonListStudents.length() ; i++){
        //     const classcode = document.getElementById('discount').value;
        // }
        document.querySelector('.update-success').style.display = 'block';
        setTimeout(function() {
            document.querySelector('.update-success').style.display = 'none';
            formdiscount.submit();
        }, 1000);

    })
   var buttonClicked = false;
    function addDiscount() {
        buttonClicked = true;
		var container = document.getElementById("addDiscount");
		var card = document.createElement("div");
		card.className = "card";
		card.innerHTML = `
		<label for=""><label class="lbStyle" id="lbdiscount" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<br>
							Thời gian bát đầu : <input type="date" name="startDiscount" id="startDiscount" ><br>
							Thời gian kết thúc: <input type="date" name="endDiscount" id="endDiscount">
							<input type="text" name="discountpercent" id="discountpercent">
                            <label id="lbvv2"></label>
							<button class="delete-button" onclick="deleteDiscount(this)">Xóa khuyến mại :</button>
  `;
		container.appendChild(card);
	}

	function deleteDiscount(button) {
        buttonClicked = false;
		var index = button.getAttribute("data-index");
		var card = button.parentNode;
		var container = card.parentNode;
		container.removeChild(card);

	}
</script>

</html>