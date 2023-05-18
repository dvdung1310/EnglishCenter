<?php
require '../lib/functionTeacher.php';

$listTeacher = listTeacher($connection);


var_dump($listTeacher);


$my_value = "Hello World";

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/mangerTeacher.css">

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

		<h1>Quản lý giáo viên</h1>



		<div><button class="add-teacher-button">Thêm giáo viên</button></div>

		<table>
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên</th>
					<th>Giới tính</th>
					<th>Tuổi</th>
					<th>Trình độ</th>
					<th>Lớp đang dạy</th>
					<th></th>

				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($listTeacher as $teacher) : ?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $teacher['TenGV']; ?></td>
						<td><?php echo $teacher['GioiTinh']; ?></td>
						<td><?php echo $teacher['Tuoi']; ?></td>
						<td><?php echo $teacher['TrinhDo']; ?></td>
						<td><?php
							$listClass = classOfTeacher($connection, $teacher['MaGV']);
							foreach ($listClass as $class) :
								echo $class['MaLop'] . '  ';
							endforeach;
							?></td>
						<td></td>

					</tr>
				<?php endforeach; ?>


			</tbody>
		</table>


		<div class="modal-bg">
			<div class="modal-content">
				<h2>Thông tin giáo viên</h2>

				<div class="container">

					<div class="header">
						<img src="https://icons.iconarchive.com/icons/custom-icon-design/flatastic-7/256/Teacher-male-icon.png" alt="Avatar" class="avatar">
						<!--Nữ:  https://icons.iconarchive.com/icons/custom-icon-design/flatastic-7/256/Teacher-female-icon.png -->
						<h1 class="name"><?php $stt = $_POST['stt_select']; echo $listTeacher[$stt - 1]['TenGV']; ?></h1>
						<!-- <p class="contact-info">Địa chỉ: [Địa chỉ], Điện thoại: [Điện thoại], Email: [Email]</p> -->
					</div>

					<!-- <div class="section">
						<h2 class="section-header">Tóm tắt kinh nghiệm làm việc</h2>
						<p class="section-content">- Kinh nghiệm A</p>
						<p class="section-content">- Kinh nghiệm B</p>
						<p class="section-content">- Kinh nghiệm C</p>
					</div> -->

					<table>
						<tr>
							<th>Mã giáo viên:</th>
							<td>GV001</td>
						</tr>
						<tr>
							<th>Giới tính:</th>
							<td>Nam</td>
						</tr>
						<tr>
							<th>Ngày sinh:</th>
							<td>01/01/1980</td>
						</tr>
						<tr>
							<th>Tuổi:</th>
							<td>43</td>
						</tr>
						<tr>
							<th>Quê quán:</th>
							<td>Hà Nội</td>
						</tr>
						<tr>
							<th>Địa chỉ:</th>
							<td>Số 10, đường ABC, phường XYZ, quận 123, TP. Hà Nội</td>
						</tr>
						<tr>
							<th>Trình độ:</th>
							<td>Thạc sỹ</td>
						</tr>
						<tr>
							<th>Lớp đang dạy</th>
							<td>Thạc sỹ</td>
						</tr>
						<tr>
							<th>Số điện thoại:</th>
							<td>0987654321</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td>nguyenvana@gmail.com</td>
						</tr>
					</table>




				</div>




				<!-- <table>
					<tr>
						<td>Tên:</td>
						<td id="teacher-name"></td>
					</tr>
					<tr>
						<td>Giới tính:</td>
						<td id="teacher-gender"></td>
					</tr>
					<tr>
						<td>Tuổi:</td>
						<td id="teacher-age"></td>
					</tr>
					<tr>
						<td>Trình độ:</td>
						<td id="teacher-education"></td>
					</tr>
					<tr>
						<td>Lớp đang dạy:</td>
						<td id="teacher-class"></td>
					</tr>
				</table> -->
				<button class="close-btn">Đóng</button>
			</div>
		</div>

	</main>


	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>

	<script>
		const rows = document.querySelectorAll('tbody tr');
		const modalBg = document.querySelector('.modal-bg');
		const modalContent = document.querySelector('.modal-content');


		rows.forEach((row) => {
			row.addEventListener('click', () => {

				var stt_select = row.cells[0].textContent;

				var xhr = new XMLHttpRequest();

				// Thiết lập yêu cầu POST với đường dẫn đến file PHP và các thông tin dữ liệu cần gửi
				xhr.open('POST', 'manageTeacher.php');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					// Xử lý kết quả
					console.log(xhr.responseText);
				};
				xhr.send('stt_select'); // Gửi các thông tin dữ liệu bằng phương thức POST

			


				// const name = row.cells[0].textContent;
				// const gender = row.cells[1].textContent;
				// const age = row.cells[2].textContent;
				// const education = row.cells[3].textContent;
				// const className = row.cells[4].textContent;

				// document.getElementById('teacher-name').textContent = name;
				// document.getElementById('teacher-gender').textContent = gender;
				// document.getElementById('teacher-age').textContent = age;
				// document.getElementById('teacher-education').textContent = education;
				// document.getElementById('teacher-class').textContent = className;

				modalBg.style.display = 'block';
			});
		});
		document.querySelector('.close-btn').addEventListener('click', () => {
			modalBg.style.display = 'none';
		});

		//hien thi chi tiet
		
	</script>
</body>

</html>