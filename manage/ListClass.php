<?php
include "../lib/FunctionClass.php";

$listClass = listClass($connection);

?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
</head>

<body>
	<header>
		<div class="logo">
			<img src="../assets/images/Apollo-Logo.png" alt="Logo">
		</div>
		<nav>
			<ul>
				<li><a href="../manage/ManageClass.php">Quản lý lớp học</a></li>
				<li><a href="#">Quản lý học viên</a></li>
				<li><a href="#">Quản lý giáo viên</a></li>
				<li><a href="#">Quản lý phụ huynh</a></li>
				<li><a href="#">Quản lý tài khoản</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<div class="class-container">
			<?php
			$listClassOn = dataClassOn($connection);
			if ($listClassOn != null) {
				foreach ($listClassOn as $datas) {
					$nameTeacher = dataTeacherByMaLop($datas['MaLop'], $connection);
					$schedules = dataSchedulesByMaLop($datas['MaLop'],$connection);
					echo	"<div class='class'>";
					echo	"<div class='image'>";
					echo	$datas['MaLop'];
					echo	"</div>";
					echo	"<div class='info'>";
					echo		"<h2>";
					echo $datas['TenLop'];
					echo "</h2>";
					echo		"<p>Giảng viên: ";
					foreach ($nameTeacher as $nameTeachers) {

						echo $nameTeachers['TenGV'];
					};
					echo "</p>";
					echo "<div class='column'>"; 
					echo		"<p>Thời gian:"; 
					echo "</p>";
					echo "<div class='center'>";  
					foreach($schedules as $listschedules){  
						         
						echo  $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
						echo "<br>";             
					  } 
					  echo "</div>";
					  echo "</div>";
					
					echo		"<p>Lứa tuổi: ";
					echo $datas['LuaTuoi'];
					echo "</p>";
					echo	"</div>";
					echo "</div>";
				}
			}
			?>
			
		</div>
	</main>
	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>
</body>

</html>