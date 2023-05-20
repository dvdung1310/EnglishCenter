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
	<style>
		.class-code {
			padding: 10px 50px;
			background-color: chartreuse;
			font-size: 18px;
			color: #fff;
		}

		.class-container a {
			text-decoration: none;
		}

		.class {
		position: relative;
	}

	.class:hover {
		background-color: #ccc;
	}

	.class .details {
		display: none;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		background-color: #f9f9f9;
		padding: 10px;
		border: 1px solid #ccc;
		opacity: 0; 
		transition: opacity 5s ease-in-out; 
		border-radius: 5px;
	}

	.class:hover .details {
		display: block;
		opacity: 1; 
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
		<div>
			<h1 style="color: #0088cc;">Danh sách lớp học</h1>
		</div>
		<a href=""></a>
		<div class="class-container">
			<?php
			$listClassOn = dataClassOn($connection);
			if ($listClassOn != null) {
				foreach ($listClassOn as $datas) {
					$maLop = $datas['MaLop'];
					$nameTeacher = dataTeacherByMaLop($datas['MaLop'], $connection);
					$schedules = dataSchedulesByMaLop($datas['MaLop'], $connection);
					echo "<a class='class' href='DetailsClass.php?maLop=$maLop'>";
					echo	"<div>";
					echo	"<div class='class-code'>";
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
					foreach ($schedules as $listschedules) {

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
					echo "<div class='details'>Xem chi tiết</div>";
					echo "</a>";
				}
			}
			?>

		</div>

		<div>
			<a href="AddClass.php">Thêm lớp</a>
		</div>
	</main>
	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>
</body>

<script>


</script>

</html>