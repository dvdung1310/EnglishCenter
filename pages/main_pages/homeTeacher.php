<?php
require '../../lib/functionUserTeacher.php';


session_start();
$maGV = $_SESSION['MaGV'];


$listClassActive  =  listClassOfTeacher($connection, $maGV, 'Đang mở');
$listClassClose  =  listClassOfTeacher($connection, $maGV, 'Đã đóng');
$listSchedules =  listSchedules($connection);
$listStudentOfClass =  studentOfClass($connection, $maGV);
$listDD =  listDD($connection, $maGV);
$tenGV = selectTenGV($connection, $maGV);
$detailTeacher = selectTeacher($connection, $maGV);

$jslistDD =  json_encode($listDD);
$jslistClassClose = json_encode($listClassClose);
$jslistStudentOfClass = json_encode($listStudentOfClass);
$jsmaGV  =  json_encode($maGV);
$jstenGV  =  json_encode($tenGV);
$jsdetailTeacher = json_encode($detailTeacher);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['time-update'])) {

        $danhSachDiemDanh = json_decode($_POST['danhSachDiemDanh'], true);
        $thoiGian = $_POST['time-update'];
        $malop = $_POST['class-update'];

        foreach ($danhSachDiemDanh as $index => $student) {

            $maHS = $student['maHS'];
            $tenHS = $student['tenHS'];
            $diemDanh = $student['diemDanh'] ? 1 : 0;


            $old_dd = selectdd($connection, $maHS, $malop, $thoiGian);

            if ($diemDanh !=  $old_dd[0]['dd']) {

                $soBuoiNghi =  selectSoBuoiNghi($connection, $maHS, $malop);
                if ($diemDanh == 0) {
                    $so =   $soBuoiNghi[0]['SoBuoiNghi'] + 1;
                } else {
                    $so =   $soBuoiNghi[0]['SoBuoiNghi'] - 1;
                }
                updateSoBuoiNghi($connection, $so, $malop, $maHS);
            }
            updateDiemDanh($connection, $diemDanh, $malop, $maHS, $thoiGian);
        }
        header("Location: homeTeacher.php");
    }

    if (isset($_POST['time-add'])) {


        $danhSachDiemDanh = json_decode($_POST['danhSachDiemDanh'], true);
        $thoiGian = $_POST['time-add'];
        $malop = $_POST['class-add'];

        foreach ($danhSachDiemDanh as $index => $student) {

            $maHS = $student['maHS'];
            $tenHS = $student['tenHS'];
            $diemDanh = $student['diemDanh'] ? 1 : 0;

            if ($diemDanh == 0) {
                $soBuoiNghi =  selectSoBuoiNghi($connection, $maHS, $malop);
                $so =   $soBuoiNghi[0]['SoBuoiNghi'] + 1;
                updateSoBuoiNghi($connection, $so, $malop, $maHS);
            }



            insertDiemDanh($malop, $maHS, $thoiGian, (int)$diemDanh, $connection);
        }


        $la =  selectSoBuoiDaToChuc($connection, $malop);
        $soBDTC =  $la[0]['SoBuoiDaToChuc'] + 1;

        updateSoBuoiDaToChuc($connection, $soBDTC, $malop);
        header("Location: homeTeacher.php");
    }

    if (isset($_POST['date-delete'])) {
        $date = $_POST['date-delete'];
        $class = $_POST['class-delete'];

        $listdiemDanh = selectddByLopTG($connection, $class, $date);
        for ($i = 0; $i < count($listdiemDanh); $i++) {
            if ($listdiemDanh[$i]['dd'] == 0) {
                $soBuoiNghi =  selectSoBuoiNghi($connection, $listdiemDanh[$i]['MaHS'], $class);
                $so =   $soBuoiNghi[0]['SoBuoiNghi'] - 1;
                updateSoBuoiNghi($connection, $so, $class,  $listdiemDanh[$i]['MaHS']);
            }
        }

        deleteDiemDanh($connection, $class, $date);
        $la =  selectSoBuoiDaToChuc($connection, $class);
        $soBDTC =  $la[0]['SoBuoiDaToChuc'] - 1;

        if ($soBDTC != 0)
            updateSoBuoiDaToChuc($connection, $soBDTC, $class);

        header("Location: homeTeacher.php");
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

    <link rel="stylesheet" href="/assets/css/userTeacherClass.css">
    <link rel="stylesheet" href="../../assets/css/common.css">
    <title>Giáo viên</title>
</head>

<body>

    <div id="menu-bar">

    </div>

    <div id="content">
        <h1 style="text-align: center;margin-top:70px">Danh sách các lớp dạy</h1>
        <h1 style="background-color:yellowgreen">Lớp đang hoạt động</h1>
        <div id="class-on">


            <?php
            if (!$listClassActive) {
                echo ' <h2> Không có lớp đang dạy </h2>';
            } else {
                foreach ($listClassActive as $class) : ?>
                    <?php if ($class['TrangThai'] == 'Đang mở') { ?>

            <?php

                        echo '<div class="class" onclick="showHiddenInfo(event, \'' . $class['MaLop'] . '\')">
                    <table>
                   <tr> <td> <h2>Mã lớp: </h2></td>   <td>' . $class['MaLop'] . '</td> </tr> 
                   <tr> <td> <h3>Tên lớp: </h3></td>   <td>' . $class['TenLop'] . '</td> </tr> 
                   <tr>
                        <td>
                            <p>Lứa tuổi : </p>
                        </td>
                        <td> ' . $class['LuaTuoi'] . ' tuổi' . '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Số học sinh: </p>
                        </td>
                        <td> ' . $class['SLHS'] . '/' . $class['SLHSToiDa'] . ' học viên' . '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Số buổi đã dạy: </p>
                        </td>
                        <td> ' . $class['SoBuoiDaToChuc'] . '/' . $class['SoBuoi'] . ' buổi' . '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Thời gian:</p>
                        </td>
                        <td>';
                        for ($i = 0; $i < count($listSchedules); $i++) {
                            if ($class['MaLop'] == $listSchedules[$i]['MaLop'])
                                echo $listSchedules[$i]['day_of_week'] . ', ' . $listSchedules[$i]['start_time'] . ' - ' . $listSchedules[$i]['end_time'] . '<br>';
                        };
                        echo '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Lương:</p>
                        </td>
                        <td>' . number_format($class['TienTraGV'], 0, '.', ',') . ' /buổi' . '</td>
                    </tr>
                </table>

            </div>';
                    }
                endforeach;
            } ?>




        </div>
        <div>
            <h1 style="margin-top: 100px;   background-color: tomato;">Lớp đã đóng</h1>
            <div id="class-off">

                <?php
                if (!$listClassClose) {
                    echo ' <h2> Không có lớp đang dạy </h2>';
                } else {
                    foreach ($listClassClose as $class) : ?>
                        <?php if ($class['TrangThai'] == 'Đã đóng') { ?>

                <?php echo '<div class="class" onclick="showHiddenInfo(event, \'' . $class['MaLop'] . '\')">
                    <table>
                   <tr> <td> <h2>Mã lớp: </h2></td>   <td>' . $class['MaLop'] . '</td> </tr> 
                   <tr> <td> <h3>Tên lớp: </h3></td>   <td>' . $class['TenLop'] . '</td> </tr> 
                   <tr>
                        <td>
                            <p>Lứa tuổi : </p>
                        </td>
                        <td> ' . $class['LuaTuoi'] . ' tuổi' . '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Số học sinh: </p>
                        </td>
                        <td> ' . $class['SLHS'] . '/' . $class['SLHSToiDa'] . ' học viên' . '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Số buổi đã dạy: </p>
                        </td>
                        <td> ' . $class['SoBuoiDaToChuc'] . '/' . $class['SoBuoi'] . ' buổi' . '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Thời gian:</p>
                        </td>
                        <td>';
                            for ($i = 0; $i < count($listSchedules); $i++) {
                                if ($class['MaLop'] == $listSchedules[$i]['MaLop'])
                                    echo $listSchedules[$i]['day_of_week'] . ', ' . $listSchedules[$i]['start_time'] . ' - ' . $listSchedules[$i]['end_time'] . '<br>';
                            };
                            echo '</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Lương:</p>
                        </td>
                        <td>' . number_format($class['TienTraGV'], 0, '.', ',') . ' /buổi' . '</td>
                    </tr>
                </table>

             </div>';
                        }
                    endforeach;
                } ?>




            </div>
        </div>

    </div>

    <div id="modal-bg">
        <div id="modal-content">
            <h1 style="margin-left: 50px;">Danh sách điểm danh </h1>
            <button id="btn-add">+ Thêm điểm danh </button>

            <div id="date-list">
                <div class="date">

                    <p style="margin-left:50px" id="time"></p>
                    <p id="number"></p>
                    <p style="margin-right:30px" id="absent"> </p>
                </div>

            </div>



            <button id="close">Đóng</button>

        </div>
    </div>

    <div id="modal-bg-update">
        <div id="modal-content-update">
            <h1 style="margin-left: 50px;">Danh sách điểm danh</h1>


            <button id="btn-delete">Xóa</button>

            <h2 id="time-header" style="margin-left: 50px;"></h2>

            <table id="attendance">
                <thead>
                    <th>STT</th>
                    <th>Mã học viên</th>
                    <th>Tên học viên</th>
                    <th>Điểm danh</th>
                </thead>
                <tbody id='tbody-listStudent'>

                </tbody>
            </table>
            <form action="" , method="post" id="form-update">
                <button type="button" id="close-update" style="margin-left: 22%;">Đóng</button>
                <input type="hidden" id="time-update" name="time-update">
                <input type="hidden" id="class-update" name="class-update">
                <button type="submit" class="btn" id="btn-update">Cập nhật</button>
            </form>



        </div>
    </div>

    <div id="modal-bg-add">
        <div id="modal-content-add">
            <form action="" , method="post" id="form-add">
                <h1 style="margin-left: 50px;">Thên điểm danh</h1>
                <h2 style="margin-left: 50px;">Thời gian : <input style="margin-left: 20px;font-size: 16px;" type="date" id="time-add" name="time-add"></h2>
                <p style="margin-left: 50px;color: red;" id="error-time"></p>
                <table id="attendance-add">
                    <thead>
                        <th>STT</th>
                        <th>Mã học viên</th>
                        <th>Tên học viên</th>
                        <th>Điểm danh</th>
                    </thead>
                    <tbody id='tbody-listStudent-add'>

                    </tbody>
                </table>

                <button type="button" id="close-add" style="margin-left: 22%;">Hủy bỏ</button>

                <input type="hidden" id="class-add" name="class-add">
                <button type="submit" class="btn" id="btn-add-submit">Thêm</button>
            </form>



        </div>
    </div>



    </div>
    <div class="add-success">
        <img src="../../assets/images/icon_success.png" alt="" style=" width: 40px;">
        <h3 id='tb1'></h3>
    </div>

    <div class="add-cant">
        <img src="../../assets/images/Close-icon.png" alt="" style=" width: 40px;">
        <h3>Lớp đã đóng ~<br> Không thể cập nhật!</h3>
        <button id="close-err">Đóng</button>
    </div>

    <div class="delete-ques">
        <img src="../../assets/images/Help-icon.png" alt="" style=" width: 40px;">
        <h4>Bạn chắc chắn muốn xóa?</h4>
        <div style="display:flex ;justify-content: space-evenly;align-items: center">
            <button style="background-color:#52a95f; height: 44px;width: 80px" id="delete-cancle">Hủy bỏ</button>
            <form id="form-delete" action="" method="POST">
                <input type="hidden" id="date-delete" name="date-delete">
                <input type="hidden" id="class-delete" name="class-delete">
                <input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete" name="delete" value="Xóa"></input>
            </form>
        </div>
    </div>

</body>


<script>
    var ds_diemdanh = <?php print_r($jslistDD); ?>;
    var ds_lopDong = <?php print_r($jslistClassClose); ?>;
    var ds_hocsinh = <?php print_r($jslistStudentOfClass); ?>;
    var MaGV = <?php print_r($jsmaGV); ?>;
    var tenGV = <?php print_r($jstenGV); ?>;
    var detailTeacher = <?php print_r($jsdetailTeacher); ?>;

    const authMenuBarHTMl = ` <div style= "position: absolute" class="PageMenuBar">
<a class="PageLogoWrap">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="./homeTeacher.php" style="color:darkcyan">Thông tin lớp dạy</a>
  <a class="menubar-nav  last-nav"  href="./userTeacher_wage.php"">Lịch sử lương</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` + tenGV[0].TenGV + `</div>
      
      
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" id ="a123">
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Teacher.php">Thông tin cá nhân</a></li>
      
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
    if (detailTeacher[0].GioiTinh == "Nam") {
    
        img2.src = "../../assets/images/Teacher-male-icon.png";
    } else {
        
        img2.src = "../../assets/images/Teacher-female-icon.png";
    }
 
</script>

<script src="../../assets/js/userTeacherClass.js"></script>



<!--boostrap.js-->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!--boostrap.js-->
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
<script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
<!--slick.js-->
<script type="text/javascript" src="../../plugins/slick-1.8.1/slick/slick.min.js"></script>




</html>