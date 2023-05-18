<?php
include "../lib/FunctionClass.php";
$result = listSchedules($connection);
$listTeacher = listTeacher($connection);
// classcode
// classname
// classAge
// classTimeOpen
// schedules
// price
// numberlessons
// students
// teachers
// khi tạo 1 lớp thì phải kèm theo tạo bảng gv_lop + schedules_class
// 
$classcode = $classname = $classAge = $classTimeOpen = $schedules1 = $schedules2 = $schedules3 = $price = $numberLessons = $sumStudents = $teachers = "";
$information = "";
$kq = "";
$teacherClass;
$schedulesClass;
$error_schedules = "";
$boolean = false;
if (isset($_GET['submit'])) {
  if (
    empty($_GET['classcode']) || empty($_GET['classname']) || empty($_GET['classAge']) || empty($_GET['classTimeOpen'])
    || empty($_GET['schedules0']) || empty($_GET['price']) || empty($_GET['numberlessons']) || empty($_GET['students'])
    || empty($_GET['teachers'])
  ) {
    $information = "Bạn chưa điền đủ thông tin";
  } else {
    $classcode = $_GET['classcode'];
    $classname = $_GET['classname'];
    $classAge  = $_GET['classAge'];
    $classTimeOpen = $_GET['classTimeOpen'];
    $price = $_GET['price'];
    $numberLessons = $_GET['numberlessons'];
    $sumStudents = $_GET['students'];
    $kq = CreateClass(
      $classcode,
      $classname,
      $classAge,
      $classTimeOpen,
      0,
      $sumStudents,
      $price,
      $numberLessons,
      0,
      0,
      $connection
    );

    if ($kq != null) {
      $schedules0 = $_GET['schedules0'];
      if(isset($_GET['schedules1'])){
        $schedules1 = $_GET['schedules1'];
      }else{
        $schedules1 = "schedules1";
      }

      if(isset($_GET['schedules2'])){
        $schedules2 = $_GET['schedules2'];
      }else{
        $schedules2 = "schedules2";
      }
      echo $schedules0;
      echo $schedules1;
      echo $schedules2;

      if($schedules0 == $schedules1 || $schedules0 == $schedules2 || $schedules1 == $schedules2) {
        $error_schedules = "Lịch học trùng nhau";
        deleteClass($kq,$connection);
      } else {
        $schedulesClass0 = CreateSchedules_Class($schedules0, $kq, $connection);
        if($schedules1 != "schedules1"){
          $schedulesClass1 = CreateSchedules_Class($schedules1, $kq, $connection);
        }
        if($schedules2 != "schedules2"){
          $schedulesClass2 = CreateSchedules_Class($schedules2, $kq, $connection);
        }
       
        $teachers = $_GET['teachers'];
        $teacherClass = CreateTeacher_Class($teachers, $kq, $connection);
        if ($teacherClass) {
          $information = "Tạo lớp thành công";
          $boolean = true;
        }
      }
    } else {
      $information = "Tạo lớp thất bại";
    }
  }

  echo "<div class='overlay'></div>";
  echo "<div class='center-box'>";
  echo "<h2>Thông báo</h2>";
  echo "<p>$error_schedules</p>";
  echo "<p>$information</p>";
  echo "<div class='close-button'><a href='#' onclick='closeNotification()'>Đóng</a></div>";
  echo "</div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Quản lý hệ thống giáo dục</title>
  <link rel="stylesheet" href="../assets/css/manage.css">
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
        <li><a href="#">Quản lý lớp học</a></li>
        <li><a href="#">Quản lý học viên</a></li>
        <li><a href="manageTeacher.php">Quản lý giáo viên</a></li>
        <li><a href="#">Quản lý phụ huynh</a></li>
        <li><a href="#">Quản lý tài khoản</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="container">
      <h1>Quản lý lớp học</h1>
      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
        <label for="classcode">Mã lớp:</label>
        <input type="text" id="classcode" name="classcode" placeholder="Nhập mã lớp...">

        <label for="classname">Tên lớp:</label>
        <input type="text" id="classname" name="classname" placeholder="Nhập tên lớp...">

        <label for="classAge">Lứa tuổi:</label>
        <input type="text" id="classAge" name="classAge" placeholder="Nhập lứa tuổi...">

        <label for="classTimeOpen">Thời gian tạo lớp:</label>
        <input type="date" id="classTimeOpen" name="classTimeOpen" placeholder="Nhập thời gian...">
        <br>

        <label for="schedules">Lịch học:</label>
        <select name="schedules0" id="select-option">
          <option value="">Thời gian</option>
          <?php foreach ($result as $results) : ?>
            <option <?php if (isset($_GET['schedules0']) && $_GET['schedules0'] == $results['idSchedules']) echo 'selected' ?> value="<?php echo $results['idSchedules']  ?>">

              <?php echo $results['day_of_week'] . ' - ' . $results['start_time'] . '-' . $results['end_time']   ?>
            </option>
          <?php endforeach; ?>
        </select>

        <button type="button" onclick="addCard()">Thêm lịch học</button>
        <div id="addSchedules"></div>


        <br>
        <label for="price">Học phí:</label>
        <input type="text" id="price" name="price" placeholder="Nhập học phí...">

        <label for="numberlessons">Tổng số buổi học:</label>
        <input type="text" id="numberlessons" name="numberlessons" placeholder="Nhập số buổi học...">

        <label for="students">Số lượng sinh viên tối đa:</label>
        <input type="text" id="students" name="students" placeholder="Nhập số lượng sinh viên...">

        <label for="teacher">Giáo viên:</label>
        <select name="teachers" id="">
          <option value="">Tên giáo viên</option>
          <?php foreach ($listTeacher as $listTeachers) : ?>
            <option value="<?php echo $listTeachers['MaGV'] ?>">
              <?php echo $listTeachers['TenGV'] . ' - ' . $listTeachers['TrinhDo'] ?>
            </option>
          <?php endforeach; ?>
        </select>
        <input type="submit" name="submit" value="Thêm lớp học">
      </form>

      <div id="card-container"></div>
      <br>
      <input type="text" id="search" name="search" placeholder="Tìm kiếm lớp học...">
      <br><br>
      <table>
        <thead>
          <tr>
            <th>Tên lớp</th>
            <th>Giảng viên</th>
            <th>Số lượng sinh viên</th>
            <th colspan="2">Lịch học</th>
          </tr>
        </thead>
        <?php
        if($boolean){
          $data = dataSchedulesByMaLop($kq,$connection);
          $nameTeacher = dataTeacherByMaLop($kq,$connection);
          echo "<tbody>";
          echo "<tr>";
          echo "<td>$classname</td>";
          if($nameTeacher != null){
            echo "<td>";
            foreach($nameTeacher as $nameTeachers){
              
              echo $nameTeachers['TenGV'];
              
            } 
            echo "</td>"; 
          }
          echo  "<td>0<span>/</span>$sumStudents</td>";
          if($data != null){
            echo "<td>";
            foreach($data as $datas){             
              echo $datas['day_of_week'] . ' - ' . $datas['start_time'] . '-' . $datas['end_time'];
              echo "<br>";             
            } 
            echo "</td>"; 
          }
          
          echo "</tr>";
          echo "</tbody>";
        }
        ?>
      </table>
    </div>
  </main>
  <footer>
    <p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
     
  </footer>

</body>

<script>
  function closeNotification() {
    var overlay = document.querySelector('.overlay');
    var centerBox = document.querySelector('.center-box');
    overlay.style.display = 'none';
    centerBox.style.display = 'none';
  }

  var counter = 1; // Biến đếm ban đầu
  <?php $counter = 1 ?>

  function addCard() {
    var container = document.getElementById("addSchedules");
    var card = document.createElement("div");
    card.className = "card";
    card.innerHTML = `
  <select name="schedules${counter}" id="select-option">
          <option value="">Thời gian</option>
          <?php foreach ($result as $results) : ?>
            <?php $counter = 1 ?>
            <option <?php if (isset($_GET['schedules']) && $_GET['schedules'] == $results['idSchedules']) echo 'selected' ?>
             value="<?php echo $results['idSchedules']  ?>">
              <?php echo $results['day_of_week'] . ' - ' . $results['start_time'] . '-' . $results['end_time']   ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button class="delete-button" data-index="${counter}" onclick="deleteCard(this)">Xóa</button>
  `;
    container.appendChild(card);
    counter++; // Tăng giá trị của biến đếm
    <?php $counter++ ?>
  }

  function deleteCard(button) {
    var index = button.getAttribute("data-index");
    var card = button.parentNode;
    var container = card.parentNode;
    container.removeChild(card);

    // Cập nhật giá trị biến đếm
    counter--;
    <?php $counter-- ?>

    // Cập nhật thuộc tính name của các thẻ select
    var cards = container.getElementsByClassName("card");
    for (var i = 0; i < cards.length; i++) {
      var select = cards[i].querySelector("select");
      select.setAttribute("name", "schedules" + (i + 1));
    }

  }
</script>

</html>