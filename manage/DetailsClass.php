<?php
include "../lib/FunctionClass.php";
$malop = $_GET['maLop'];

$dataClass = dataClassById($malop, $connection);
$dataSchedules = dataSchedulesByMaLop($malop, $connection);
$nameTeacher = dataTeacherByMaLop($malop, $connection);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết lớp học</title>
    <link rel="stylesheet" href="../assets/css/manage.css">
    <style>
        .container-details {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container-detail-class {
            display: flex;
        }

        .container-p {
            margin-top: 27px;
            padding-left: 10px;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Màu nền mờ */
            display: none;
            z-index: 9999;
        }

        #myModal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            display: none;
            z-index: 10000;
        }

        #myModal h2 {
            margin-top: 0;
        }

        #myModal p {
            margin-bottom: 20px;
        }

        #myModal button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../assets/images/Apollo-Logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a style="color: #0088cc;" href="../manage/ManageClass.php">Quản lý lớp học</a></li>
                <li><a href="#">Quản lý học viên</a></li>
                <li><a href="#">Quản lý giáo viên</a></li>
                <li><a href="#">Quản lý phụ huynh</a></li>
                <li><a href="#">Quản lý tài khoản</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container-details">
            <h1 style="color: #0088cc;">Chi tiết lớp <?php echo $malop; ?></h1>
            <div class="container-details-center">
                <div class="container-detail-class">
                    <h2>Mã lớp :</h2>
                    <p class="container-p"><?php echo $malop; ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Tên lớp: </h2>
                    <p class="container-p"><?php echo $dataClass['TenLop']; ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Lứa tuổi: </h2>
                    <p class="container-p"><?php echo $dataClass['LuaTuoi']; ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Thời gian tạo lớp:</h2>
                    <p class="container-p"><?php echo $dataClass['ThoiGian']; ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Lịch học:</h2>
                    <p class="container-p">
                        <?php
                        foreach ($dataSchedules as $listschedules) {
                            echo  $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
                            echo "<br>";
                        }

                        ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Học phí:</h2>
                    <p class="container-p"><?php echo $dataClass['HocPhi']; ?>VND</p>
                </div>

                <div class="container-detail-class">
                    <h2>Tổng số buổi học:</h2>
                    <p class="container-p"><?php echo $dataClass['SoBuoi']; ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Số lượng học sinh tối đa:</h2>
                    <p class="container-p"><?php echo $dataClass['SLHSToiDa']; ?></p>
                </div>

                <div class="container-detail-class">
                    <h2>Giáo viên:</h2>
                    <p class="container-p"><?php
                                            foreach ($nameTeacher as $nameTeachers) {

                                                echo $nameTeachers['TenGV'];
                                            };
                                            ?></p>
                </div>
            </div>

            <button id="myButton">Xóa lớp</button>
            <div id="overlay"></div>

            <div id="myModal">
                <h2>Thông báo</h2>
                <p>Bạn có muốn xóa lớp ?</p>
                <button id="confirmBtn">Có</button>
                <button id="cancelBtn">Không</button>
            </div>
        </div>
    </main>
    <footer>
        <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
    </footer>
</body>

<script>
    var myButton = document.getElementById("myButton");
    var overlay = document.getElementById("overlay");
    var modal = document.getElementById("myModal");
    var confirmBtn = document.getElementById("confirmBtn");
    var cancelBtn = document.getElementById("cancelBtn");

    myButton.addEventListener("click", function() {
        overlay.style.display = "block";
        modal.style.display = "block";
    });

    confirmBtn.addEventListener("click", function() {
        // Thực hiện điều kiện khi chọn "Có"
        var confirmed = confirm("Bạn có chắc chắn muốn xóa lớp?");
        if (false) {
    <?php
    $result = deleteClassById($malop, $connection);
    if ($result) {
      $infor = "Bạn đã xóa lớp thành công";
    }
    ?>
  }

    });

    cancelBtn.addEventListener("click", function() {
        overlay.style.display = "none";
        modal.style.display = "none";
    });
</script>

</html>