<?php
include "../lib/FunctionClass.php";
$malop = $_GET['maLop'];

$dataClass = dataClassById($malop, $connection);
$dataSchedules = dataSchedulesByMaLop($malop, $connection);
$nameTeacher = dataTeacherByMaLop($malop, $connection);
$result = listSchedules($connection);
$nameCondition = ''; 
if ($dataClass['TrangThai'] == 0) {
    $nameCondition = 'Chưa mở';
} else if ($dataClass['TrangThai'] == 1) {
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
            0,
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
        $newTeacher = $_POST['teachers'];
        foreach ($nameTeacher as $nameTeachers) {
            $teacher =  $nameTeachers['MaGV'];
        };

        if ($newTeacher != $teacher) {
            updateClass_TeacherByID($malop, $teacher, $newTeacher, $connection);
        }


        header("Location: DetailsClass.php?maLop=$classcode");
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
    <style>
        
    </style>
</head>

<body>
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
                                <td id="teacher-date" contenteditable="false"><?php echo $dataClass['ThoiGian']; ?></td>
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
                                <th>Học phí:</th>
                                <td id="teacher-qq" contenteditable="false"><?php echo $dataClass['HocPhi']; ?>VND</td>
                            </tr>
                            <tr>
                                <th>Tổng số buổi đã dạy:</th>
                                <td id="" contenteditable="false"><?php echo $dataClass['SoBuoiDaToChuc']; ?></td>
                            </tr>
                            <tr>
                                <th>Tổng số buổi dạy:</th>
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
                        <select name="teachers" id="teachers">
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
                        <label for="condition">Trạng thái:<label class="lbStyle" id="lbcondition" style="color:red; font-size:13px ; font-style: italic "></label></label>
                        <br><select name="SelectCondition" id="SelectCondition">
                            <option value=" <?php echo $dataClass['TrangThai'] ?>">
                                <?php echo $nameCondition ?>
                            </option>
                            <option value="0">Chưa mở</option>
                            <option value="1">Đang mở</option>
                            <option value="2">Đã đóng</option>
                        </select>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $listStudents = ListStudentByClass($malop, $connection)
                            ?>
                            <?php foreach ($listStudents as $data) : ?>
                                <tr>
                                    <td><?php echo $data['TenHS'] ?></td>
                                    <td><?php echo $data['NgaySinh'] ?></td>
                                    <td><?php echo $data['GioiTinh'] ?></td>
                                    <td><?php echo $data['DiaChi'] ?></td>
                                    <td><?php echo $data['SDT'] ?></td>
                                    <td><?php
                                        $mahs = $data['MaHS'];
                                        $numberAbsences = numberAbsences($mahs, $malop, $connection);
                                        echo $numberAbsences['Absences'];
                                        ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
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
                                    <td><?php echo $data['ThoiGian'] ?></td>
                                    <td><?php
                                        $totalStudent = TotalStudentByTime($data['ThoiGian'], $connection);
                                        echo $totalStudent['total'] . '/' . $dataClass['SLHS']  ?></td>
                                </tr>

                            <?php endforeach ?>

                        </tbody>
                    </table>

                    <!-- hiện ra box của time chi tiết -->
                    <?php $j = 1; 
                    foreach($listTime as $data) :
                    ?>
                    <div class="detailTimeAttendance" id="details-<?php echo $j ?>">
                                <div id="boxTime<?php echo $j ?>">
                                <button id="closebtnboxTime<?php echo $j ?>">&times;</button>
                                    <div class="">
                                    <h1>Chi tiết điểm danh của ngày </h1>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã học sinh</th>
                                            <th>Tên học sinh</th>
                                            <th>Tham gia lớp học</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           <td><?php echo $j ?></td>
                                           <td>CT</td>
                                           <td>D</td>
                                           <td>OKE</td>
                                        </tr>

                                        <tr>
                                           <td><?php echo $j ?></td>
                                           <td>CT</td>
                                           <td>D</td>
                                           <td>OKE</td>
                                        </tr>
                                    </tbody>
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
        const boxTime = document.getElementById('boxTime'+ id);
        detailsBox.classList.add('active');
        boxTime.classList.add('active');

     const closebtnboxTime = document.getElementById('closebtnboxTime'+id);
     closebtnboxTime.addEventListener('click', () => {
        detailsBox.classList.remove('active');
        boxTime.classList.remove('active'); 
    });
    }
</script>

</html>