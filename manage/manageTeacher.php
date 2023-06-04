<?php
require '../lib/functionTeacher.php';







$listTeacher = listTeacher($connection);
$listtk_gv = listtk_gv($connection);
$listClassOfTeacher = listClassOfTeacher($connection);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['teacher_name_edit'])) {

		$magv = $_POST['id_edit'];
		$ten = trim($_POST['teacher_name_edit']);
		$gt = $_POST['gender_edit'];
		$ns = $_POST['birthday_edit'];
		$tuoi = $_POST['age_edit'];
		$qq = trim($_POST['hometown_edit']);
		$dc = trim($_POST['address_edit']);
		$td = trim($_POST['education_edit']);
		$sdt = $_POST['phone_number_edit'];
		$email = trim($_POST['email_edit']);
		updateTeacherbyID($connection, $magv, $ten, $gt, $ns, $tuoi, $qq, $dc, $td, $sdt, $email);
		header("Location: manageTeacher.php");
	}



	if (isset($_POST['teacher_name_add'])) {


		$ten = trim($_POST['teacher_name_add']);
		$gt = $_POST['gender_add'];
		$ns = $_POST['birthday_add'];
		$tuoi = $_POST['age_add'];
		$qq = trim($_POST['hometown_add']);
		$dc = trim($_POST['address_add']);
		$td = trim($_POST['education_add']);
		$sdt = $_POST['phone_number_add'];
		$email = trim($_POST['email_add']);

		$magv = insertTeacher($connection, $ten, $gt, $ns, $tuoi, $qq, $dc, $td, $sdt, $email);
		inserttk_gv($magv, $sdt, '12345678', $connection);

		header("Location: manageTeacher.php");
	}

	if (isset($_POST['refesh'])) {
		header("Location: manageTeacher.php");
	}

	if (isset($_POST['search'])) {
		$key = trim($_POST['keyword']);
		$listTeacher = searchTeacher($connection, $key);
	}

	if (isset($_POST['maGV_delete'])) {
		$magv = $_POST['maGV_delete'];
		deletetk_gv($connection, $magv);
		deleteTeacher($connection, $magv);
		header("Location: manageTeacher.php");
	}

	if (isset($_POST['username-login'])) {
		$username = $_POST['username-login'];
		$pass = $_POST['new-password'];

		updatePassGV($connection, $username, $pass);
		header("Location: manageTeacher.php");
	}
}


$jsonListTeacher = json_encode($listTeacher);
$jsonListtk_gv = json_encode($listtk_gv);
$jsonListClass = json_encode($listClassOfTeacher);



?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/mangeTeacher.css">

</head>

<body>
	<header>
		<div class="logo">
			<img src="../assets/images/Apollo-Logo.png" alt="Logo">

		</div>
		<nav>
			<ul>
				<li><a href="../manage/ManageClass.php">Quản lý lớp học</a></li>
				<li><a href="../manage/manageStudent.php">Quản lý học viên</a></li>
				<li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a href="../manage/ManageParent.php">Quản lý phụ huynh</a></li>
				<li><a href="../manage/ManageFinance.php">Quản lý tài khoản</a></li>
			</ul>
		</nav>
	</header>
	<main>

		<h1>Quản lý Giáo viên</h1>
		<div class="search-container">
			<form id="form-search" method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
				<input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value="">
				<input type="submit" name="search" value="Tìm kiếm" style="width: 100px">
				<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
			</form>


			<div>
				<button class="add-teacher-button">Thêm giáo viên</button>
			</div>
		</div>

		<table id="table-1">
			<thead>
				<tr>
					<th onclick="sortTable(0)">STT</th>
					<th onclick="sortTable(1)">Mã Giáo viên</th>
					<th onclick="sortTable(2)">Họ tên</th>
					<th onclick="sortTable(3)">Giới tính</th>
					<th onclick="sortTable(4)">Tuổi</th>
					<th onclick="sortTable(5)">Quê Quán</th>
					<th onclick="sortTable(6)">Lớp đang dạy</th>
					<th></th>

				</tr>
			</thead>
			<tbody class="tbody-1">
				<?php $i = 1;
				if (!$listTeacher)
					echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
				else {
					foreach ($listTeacher as $teacher) : ?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $teacher['MaGV']; ?></td>
							<td><?php echo $teacher['TenGV']; ?></td>

							<td><?php echo $teacher['GioiTinh']; ?></td>
							<td><?php echo $teacher['Tuoi']; ?></td>
							<td><?php echo $teacher['QueQuan']; ?></td>
							<td><?php
								$listClass = classOfTeacher($connection, $teacher['MaGV']);
								foreach ($listClass as $class) :
									echo $class['MaLop'] . ' ; ';
								endforeach;
								?></td>
							<td></td>

						</tr>
				<?php endforeach;
				} ?>



			</tbody>
		</table>

		<!-- Thong tin chi tiet -->
		<div class="modal-bg">
			<div class="modal-content">
				<h2>Thông tin giáo viên</h2>
				<button id="edit-button" style="position: absolute;top: 40px;right: 60px;">Sửa</button>

				<button id="delete-button" name="delete" style="position: absolute;top: 40px;right: 11px; background-color: #e90000">Xóa</button>

				<div class="container">

					<div class="header">
						<img id="img" alt="Avatar" class="avatar">

						<h1 class="name" id="teacher-name"></h1>
					</div>
					<div class="detail">

						<div class="tab">
							<button class="tablinks" id="tb1" onclick="openTab(event, 'tab1')">Chung</button>
							<button class="tablinks" id="tb2" onclick="openTab(event, 'tab2')">Lớp dạy</button>
							<button class="tablinks" id="tb3" onclick="openTab(event, 'tab3')">Tài khoản</button>
						</div>

						<div id="tab1" class="tabcontent">

							<table>
								<tr>
									<th>Mã giáo viên:</th>
									<td id="teacher-id"></td>
								</tr>
								<tr>
									<th>Giới tính:</th>
									<td id="teacher-gender" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Ngày sinh:</th>
									<td id="teacher-date" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Tuổi:</th>
									<td id="teacher-age" contenteditable="false">43</td>
								</tr>
								<tr>
									<th>Quê quán:</th>
									<td id="teacher-qq" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Địa chỉ:</th>
									<td id="teacher-address" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Trình độ:</th>
									<td id="teacher-qualification" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Lớp đang dạy</th>
									<td id="teacher-class" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Số điện thoại: </th>
									<td id="teacher-phone" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Email:</th>
									<td id="teacher-email" contenteditable="false"></td>
								</tr>
							</table>

						</div>

						<div id="tab2" class="tabcontent">
							<div id="classes-of-teacher">

							</div>

						</div>


						<div id="tab3" class="tabcontent">
							<div>
								<table>
									<tr>
										<td>
											<h3 style="text-align: center;"> Tên đăng nhập : </h3>
										</td>
										<td>
											<label id="name-login"> </label>
										</td>
									</tr>
									<tr>
										<td>
											<h3 style="text-align: center;"> Mật khẩu : </h3>
										</td>
										<td>
											<input type="password" id="password" style="height: 21px;font-size: 18px;" readonly>
											<button style="background-color: slategray;" onclick="togglePassword()">Hiện/ẩn</button>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<button style=" background-color: peru;" id="change-pass-btn">Đổi mật khẩu</button>
										</td>
									</tr>
								</table>
							</div>
							<div id="div-change-pass">
								<form action="#" method="POST" id="change-pass" name="change-pass">
									<table>

										<tr>
											<td>
												<label> Tên đăng nhập : </label>
											</td>
											<td>
												<input type="text" id="username-login" name="username-login" readonly>
											</td>
										</tr>
										<tr>

											<td>
												<label for="new-password">Mật khẩu mới:</label>
											</td>
											<td>
												<input type="password" id="new-password" name="new-password" autocomplete="false"><br>
											</td>
										</tr>
										<tr>
											<td>
												<p id="err-pass" style="color: red;font-style: italic;  font-size: 14px;"></p>
											</td>

										</tr>
										<tr>
											<td>
												<label for="confirm-password">Nhập lại mật khẩu mới:</label>
											</td>
											<td>
												<input type="password" id="confirm-password" name="confirm-password" autocomplete="false"><br>
											</td>
										</tr>
										<tr>
											<td>
												<p id="err-repass" style="color: red;font-style: italic;  font-size: 14px;"></p>
											</td>

										</tr>

										<tr>
											<td style="text-align :center">
												<button type="button" id="cancle-change-pass" style=" font-size: 14px;padding: 14px 20px;">Hủy bỏ</button>
											</td>
											<td style="text-align :center">
												<input type="submit" name="change" id="change" style="width: unset" value="Đổi mật khẩu">
											</td>
										</tr>

									</table>
								</form>
							</div>
						</div>

					</div>

					<button class="close-btn">Đóng</button>
				</div>
			</div>

			<!-- Sua thong tin -->
			<div class="modal-bg-edit">
				<div class="modal-content-edit">
					<div>
						<form id="form_edit" name="form_edit" method="post">


							<!-- <label for="teacher_id">Mã giáo viên: 1</label>
						<input type="text" id="teacher_id" name="teacher_id" required> -->


							<h1>Sửa thông tin giáo viên</h1>

							<h2 id="teacher-id_edit"></h2>
							<input type="hidden" id="id_edit" name="id_edit">

							<label for="teacher_name">Tên giáo viên: <label id="lb_name_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="teacher_name_edit" name="teacher_name_edit" required>

							<label for="gender">Giới tính:</label>
							<select id="gender_edit" name="gender_edit">
								<option>Nam</option>
								<option>Nữ</option>
							</select>

							<label for="birthday">Ngày sinh:</label>
							<input type="date" id="birthday_edit" name="birthday_edit" required><label id="lb_birthday_edit" style="color:red; font-size:13px ; font-style: italic "></label>

							<label for="age" style="margin-left: 150px;">Tuổi:</label>
							<input type="number" id="age_edit" name="age_edit" required> <label id="lb_age_edit" style="color:red; font-size:13px ; font-style: italic "></label>
							<br>
							<label for="hometown">Quê quán: <label id="lb_hometown_edit" style="color:red; font-size:13px ; font-style: italic "></label> </label>
							<input type="text" id="hometown_edit" name="hometown_edit" required>

							<label for="address">Địa chỉ: <label id="lb_address_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="address_edit" name="address_edit" required>

							<label for="education">Trình độ: <label id="lb_education_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="education_edit" name="education_edit" required>

							<label for="phone_number">Số điện thoại: <label id="lb_phone_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="tel" id="phone_number_edit" name="phone_number_edit" required>

							<label for="email">Email: <label id="lb_email_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="email" id="email_edit" name="email_edit" required>


							<input type="submit" id='update' name="update" value="Cập nhật">

						</form>
						<button class="cancle-btn">Hủy bỏ</button>
					</div>
				</div>
			</div>




			<div class="add-success">
				<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
				<h3>Thêm giáo viên thành công!</h3>
			</div>
			<div class="update-success">
				<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
				<h3>Thay đổi thành công!</h3>
			</div>
			<div class="delete-success">
				<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
				<h3>Xóa thành công!</h3>
			</div>

			<div class="delete-ques">
				<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
				<h4>Bạn chắc chắn muốn xóa?</h4>
				<div style="display:flex ;justify-content: space-evenly;align-items: center">

					<button style="background-color:#52a95f; height: 44px;width: 80px" id="delete-cancle">Hủy bỏ</button>
					<form id="form-delete" action="" method="POST">
						<input type="hidden" id="maGV_delete" name="maGV_delete">
						<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete" name="delete" value="Xóa"></input>
					</form>
				</div>
			</div>

			<div class="delete-cant">
				<img src="../assets/images/Close-icon.png" alt="" style=" width: 40px;">
				<h3>Giáo viên đang có lớp dạy <br> Không thể xóa!</h3>
				<button id="close">Đóng</button>
			</div>

			<div class="change-pass-success">
				<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
				<h3>Thay đổi mật khẩu thành công!</h3>
			</div>
		</div>

		<!-- Them giao vien -->
		<div class="modal-bg-add">
			<div class="modal-content-add">
				<div>
					<form id="form_add" name="form_add" method="post">


						<!-- <label for="teacher_id">Mã giáo viên: 1</label>
						<input type="text" id="teacher_id" name="teacher_id" required> -->


						<h1>Thêm Giáo viên</h1>



						<label for="teacher_name">Tên giáo viên: <label id="lb_name_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="teacher_name_add" name="teacher_name_add" required placeholder="Nhập tên giáo viên">

						<label for="gender">Giới tính:</label>
						<select id="gender_add" name="gender_add">
							<option>Nam</option>
							<option>Nữ</option>
						</select>

						<label for="birthday">Ngày sinh:</label>
						<input type="date" id="birthday_add" name="birthday_add" required><label id="lb_birthday_add" style="color:red; font-size:13px ; font-style: italic "></label>

						<label for="age" style="margin-left: 150px;">Tuổi:</label>
						<input type="number" id="age_add" name="age_add" required> <label id="lb_age_add" style="color:red; font-size:13px ; font-style: italic "></label>
						<br>
						<label for="hometown">Quê quán: <label id="lb_hometown_add" style="color:red; font-size:13px ; font-style: italic "></label> </label>
						<input type="text" id="hometown_add" name="hometown_add" required placeholder="Nhập quê quán">

						<label for="address">Địa chỉ: <label id="lb_address_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_add" name="address_add" required placeholder="Nhập địa chỉ">

						<label for="education">Trình độ: <label id="lb_education_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="education_add" name="education_add" required placeholder="Nhập tên trình độ">

						<label for="phone_number">Số điện thoại: <label id="lb_phone_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="tel" id="phone_number_add" name="phone_number_add" required placeholder="Nhập số diện thoại"> 

						<label for="email">Email: <label id="lb_email_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="email" id="email_add" name="email_add" required placeholder="Nhập email">


						<input type="submit" id='add' name="add" value="Thêm">

					</form>
					<button class="cancle-btn-add">Hủy bỏ</button>
				</div>
			</div>
		</div>



	</main>




	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>

	<script>
		function convertDateFormat(dateString) {
			var dateParts = dateString.split("-");
			var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
			return formattedDate;
		}

		function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

		const rows = document.querySelectorAll('.tbody-1 tr');
		const modalBg = document.querySelector('.modal-bg');
		const modalContent = document.querySelector('.modal-content');




		var stt_select;
		var ds_giaovien;
		var listClass;
		var teacher_select;

		var ds_giaovien = <?php print_r($jsonListTeacher); ?>; //


		// khi nhấn vào 1 hàng , hiển thị thông tin chi tiêt
		rows.forEach((row) => {
			row.addEventListener('click', () => {


				stt_select = row.cells[1].textContent;

				listClass = row.cells[6].textContent;
				ds_giaovien = <?php print_r($jsonListTeacher); ?>;
				ds_tk_gv = <?php print_r($jsonListtk_gv); ?>;
				ds_gv_lop = <?php print_r($jsonListClass); ?>;

				for (var i = 0; i < ds_giaovien.length; i++) {
					if (stt_select == ds_giaovien[i].MaGV)
						teacher_select = ds_giaovien[i];
				}

				console.log(teacher_select);


				document.getElementById('teacher-name').textContent = teacher_select.TenGV;
				document.getElementById('teacher-gender').textContent = teacher_select.GioiTinh;
				document.getElementById('teacher-age').textContent = teacher_select.Tuoi;
				document.getElementById('teacher-class').textContent = listClass;
				document.getElementById('teacher-id').textContent = teacher_select.MaGV;
				document.getElementById('teacher-qq').textContent = teacher_select.QueQuan;
				document.getElementById('teacher-address').textContent = teacher_select.DiaChi;
				document.getElementById('teacher-date').textContent = convertDateFormat(teacher_select.NgaySinh);
				document.getElementById('teacher-phone').textContent = teacher_select.SDT;
				document.getElementById('teacher-email').textContent = teacher_select.Email;
				document.getElementById('teacher-qualification').textContent = teacher_select.TrinhDo;

				document.getElementById('maGV_delete').value = teacher_select.MaGV;

				var img = document.getElementById("img");

				if (teacher_select.GioiTinh == "Nam") {
					img.src = "../assets/images/Teacher-male-icon.png";
				} else {
					img.src = "../assets/images/Teacher-female-icon.png";
				}

				document.getElementById("tab1").classList.add("show");
				document.getElementById("tab2").classList.remove("show");
				document.getElementById("tab3").classList.remove("show");
				document.getElementById("tb1").classList.add("active");
				document.getElementById("tb2").classList.remove("active");
				document.getElementById("tb3").classList.remove("active");

				// Thong tin lop cua giao vien
				var classes = [];
				var k = 0;
				for (var i = 0; i < ds_gv_lop.length; i++) {
					if (ds_gv_lop[i].MaGV === teacher_select.MaGV) {

						classes[k++] = ds_gv_lop[i];
					}
				}


				var html = '';

				if (classes.length === '0') {
					html += '<p>Học viên chưa tham gia lớp học nào </p>';
				} else {
					html += '<p> Số lớp dạy:  ' + classes.length + '</p>';

					for (var i = 0; i < classes.length; i++) {

						html += '<div class="class">' +
							'<p></p>' +
							'<table>' +
							'<tr>' +

							'<td>' +
							'<p id="id-class">Mã lớp học:  ' + classes[i]['MaLop'] + '</p>' +
							'</td>' +

							'<td>' +
							'<p id="num-of-session">Số buổi học:  ' + classes[i]['SoBuoiDaToChuc'] + '/' + classes[i]['SoBuoi'] +
							'</tr>' +
							'<tr>' +

							'<td>' +
							'<p id="name-class">Tên lớp học:  ' + classes[i]['TenLop'] + '</p>' +
							'</td>' +

							'<td>' +
							'<p id="name =name-teacher">Lứa tuổi:  ' + classes[i]['LuaTuoi'] + '</p>' +
							'</td>' +
							'</tr>' +
							'<tr>' +

							'<td>' +
							'<p id="fee-class">Số học sinh:  ' + classes[i]['SLHS'] + '/' + classes[i]['SLHSToiDa'] + '</p>' +
							'</td>' +

							'<td>' +
							'<p id="de-fee-class">Lương:  ' + numberWithCommas(classes[i]['TienTraGV']) + ' / buổi' + '</p>' +
							'</td>' +
							'</tr>' +
							'<tr>' +

							'<td>' +
							'<p id="status-class">Trạng thái:  ' + classes[i]['TrangThai'] + '</p>' +
							'</td>' +
							'</tr>' +
							'</table>' +
							'</div>';
					}

					document.querySelector("#classes-of-teacher").innerHTML = html;

				}



				//thong tin tai khoan
				var username = '';
				var pass = '';
				for (var i = 0; i < ds_tk_gv.length; i++) {
					if (ds_tk_gv[i].MaGV === teacher_select.MaGV) {
						username = ds_tk_gv[i]['UserName'];
						pass = ds_tk_gv[i]['Password']
					}
				}

				document.getElementById('name-login').textContent = username;
				document.getElementById('username-login').value = username;
				document.getElementById('password').value = pass;


				modalBg.style.display = 'block';
			});
		});
		document.querySelector('.close-btn').addEventListener('click', () => {
			document.getElementById('div-change-pass').style.display = 'none';
			document.getElementById('err-pass').textContent = '';
			document.getElementById('err-repass').textContent = '';
			modalBg.style.display = 'none';
		});



		const editButton = document.getElementById('edit-button');
		const tdList = document.querySelectorAll('td[contenteditable]');

		const modalBgEdit = document.querySelector('.modal-bg-edit');
		const modalContentEdit = document.querySelector('.modal-content-edit');

		// Khi người dùng nhấn vào nút "Sửa"
		editButton.addEventListener('click', () => {
			document.getElementById('lb_phone_edit').textContent = "";
			document.getElementById('lb_email_edit').textContent = "";
			document.getElementById('lb_name_edit').textContent = "";
			document.getElementById('lb_hometown_edit').textContent = "";
			document.getElementById('lb_address_edit').textContent = "";
			document.getElementById('lb_education_edit').textContent = "";
			document.getElementById('lb_age_edit').textContent = "";
			document.getElementById('lb_birthday_edit').textContent = "";

			modalBgEdit.style.display = "block";


			document.getElementById('teacher_name_edit').value = teacher_select.TenGV;

			var gt = teacher_select.GioiTinh;
			var selectTag = document.getElementById("gender_edit");
			for (var i = 0; i < selectTag.options.length; i++) {
				if (selectTag.options[i].value == gt) {
					selectTag.options[i].selected = true; // nếu giống nhau, đặt thuộc tính selected cho option
					break;
				}
			}

			document.getElementById('birthday_edit').value = teacher_select.NgaySinh;
			document.getElementById('age_edit').value = teacher_select.Tuoi;
			document.getElementById('teacher-id_edit').textContent = "Mã Giáo viên : " + teacher_select.MaGV;
			document.getElementById('hometown_edit').value = teacher_select.QueQuan;
			document.getElementById('address_edit').value = teacher_select.DiaChi;
			document.getElementById('phone_number_edit').value = teacher_select.SDT;
			document.getElementById('email_edit').value = teacher_select.Email;
			document.getElementById('education_edit').value = teacher_select.TrinhDo;
			document.getElementById('id_edit').value = teacher_select.MaGV;
		});

		document.querySelector('.cancle-btn').addEventListener('click', () => {
			modalBgEdit.style.display = 'none';
		});



		// Khi nhấn nút Cập nhật
		const submit_update = document.getElementById('update');
		submit_update.addEventListener('click', function(event) {
			var check = true;
			const form1 = document.getElementById('form_edit')
			// Ngăn chặn việc submit form mặc định để xử lý dữ liệu trước khi gửi form đi
			event.preventDefault();

			const phone_number = document.getElementById('phone_number_edit').value;
			const email = document.getElementById('email_edit').value;

			const teacher_name = document.getElementById('teacher_name_edit').value;
			const age = document.getElementById('age_edit').value;
			const hometown = document.getElementById('hometown_edit').value;
			const address = document.getElementById('address_edit').value;
			const education = document.getElementById('education_edit').value;
			const birthday = document.getElementById('birthday_edit').value;

			var erorr_empty = "*Dữ liệu không để trống";

			//Kiểm tra dữ liệu nhập vào
			if (!teacher_name) {
				document.getElementById('lb_name_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_name_edit').textContent = "";

			if (!birthday) {
				document.getElementById('lb_birthday_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_birthday_edit').textContent = "";

			if (!age) {
				document.getElementById('lb_age_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_age_edit').textContent = "";

			if (!hometown) {

				document.getElementById('lb_hometown_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_hometown_edit').textContent = "";

			if (!address) {

				document.getElementById('lb_address_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_address_edit').textContent = "";
			if (!education) {

				document.getElementById('lb_education_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_education_edit').textContent = "";
			if (!(/^(0[0-9]{9})$/.test(phone_number))) {
				document.getElementById('lb_phone_edit').textContent = "*Số điện thoại không chính xác (0..; 10 chữ số)";
				check = false;
			} else
				document.getElementById('lb_phone_edit').textContent = "";

			if (!(/\S+@\S+\.\S+/.test(email))) {
				document.getElementById('lb_email_edit').textContent = "*Email không chính xác (example@xxx.com)";
				check = false;
			} else
				document.getElementById('lb_email_edit').textContent = "";

			if (!check)
				return;
			document.querySelector('.update-success').style.display = 'block';


			setTimeout(function() {
				document.querySelector('.update-success').style.display = 'none';
				form1.submit();
			}, 1000);

			// Gửi form đi nếu tất cả dữ liệu hợp lệ

		});


		//Thêm giáo viên
		const modalBgAdd = document.querySelector('.modal-bg-add');
		const modalContentAdd = document.querySelector('.modal-content-add');

		// Khi nhấn "thêm giáo viên"
		document.querySelector('.add-teacher-button').addEventListener('click', () => {
			modalBgAdd.style.display = 'block';
		})
		// Huy bo 
		document.querySelector('.cancle-btn-add').addEventListener('click', () => {
			modalBgAdd.style.display = 'none';

			 document.getElementById('phone_number_add').value ='';
			document.getElementById('email_add').value ='';
			document.getElementById('teacher_name_add').value ='';
			 document.getElementById('age_add').value ='';
			document.getElementById('hometown_add').value ='';
			document.getElementById('address_add').value ='';
			 document.getElementById('education_add').value ='';
			 document.getElementById('birthday_add').value ='';

			
				document.getElementById('lb_name_add').textContent = "";

				document.getElementById('lb_birthday_add').textContent = "";

				document.getElementById('lb_age_add').textContent = "";

			
				document.getElementById('lb_hometown_add').textContent = "";

			
				document.getElementById('lb_address_add').textContent = "";
			
				document.getElementById('lb_education_add').textContent = "";
			
				document.getElementById('lb_phone_add').textContent = "";

			
				document.getElementById('lb_email_add').textContent = "";

		});

		// Khi nhấn Thêm
		const submit_add = document.getElementById('add');
		submit_add.addEventListener('click', function(event) {
			var check = true;
			const form2 = document.getElementById('form_add')
			// Ngăn chặn việc submit form mặc định để xử lý dữ liệu trước khi gửi form đi
			event.preventDefault();
			const phone_number = document.getElementById('phone_number_add').value;
			const email = document.getElementById('email_add').value;
			const teacher_name = document.getElementById('teacher_name_add').value;
			const age = document.getElementById('age_add').value;
			const hometown = document.getElementById('hometown_add').value;
			const address = document.getElementById('address_add').value;
			const education = document.getElementById('education_add').value;
			const birthday = document.getElementById('birthday_add').value;

			var erorr_empty = "*Dữ liệu không để trống";

			//Kiểm tra dữ liệu nhập vào

			if (!teacher_name) {
				document.getElementById('lb_name_add').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_name_add').textContent = "";

			if (!birthday) {
				document.getElementById('lb_birthday_add').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_birthday_add').textContent = "";

			if (!age) {
				document.getElementById('lb_age_add').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_age_add').textContent = "";

			if (!hometown) {

				document.getElementById('lb_hometown_add').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_hometown_add').textContent = "";

			if (!address) {

				document.getElementById('lb_address_add').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_address_add').textContent = "";
			if (!education) {

				document.getElementById('lb_education_add').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_education_add').textContent = "";
			if (!(/^(0[0-9]{9})$/.test(phone_number))) {
				document.getElementById('lb_phone_add').textContent = "*Số điện thoại không chính xác (0[0-9]; 10 chữ số)";
				check = false;
			} else
				document.getElementById('lb_phone_add').textContent = "";

			if (!(/\S+@\S+\.\S+/.test(email))) {
				document.getElementById('lb_email_add').textContent = "*Email không chính xác (example@xxx.com)";
				check = false;
			} else
				document.getElementById('lb_email_add').textContent = "";

			if (!check)
				return;

			document.querySelector('.add-success').style.display = 'block';

			setTimeout(function() {
				document.querySelector('.add-success').style.display = 'none';
				form2.submit();
			}, 1000);
			// Gửi form đi nếu tất cả dữ liệu hợp lệ
			// form2.submit();
		});

		// Khi nhan nut Xoa
		document.getElementById('delete-button').addEventListener('click', () => {
			document.querySelector('.delete-ques').style.display = 'block';
		});
		document.getElementById('delete-cancle').addEventListener('click', () => {
			document.querySelector('.delete-ques').style.display = 'none';
		});
		document.getElementById('delete').addEventListener('click', function(event) {

			const form3 = document.getElementById('form-delete');

			event.preventDefault();
			document.querySelector('.delete-ques').style.display = 'none';
			if (listClass.length != 0) {
				document.querySelector('.delete-cant').style.display = 'block';
				return;
			}

			document.querySelector('.delete-success').style.display = 'block';
			setTimeout(function() {
				document.querySelector('.delete-success').style.display = 'none';


				form3.submit();
			}, 1000);

		});

		document.getElementById('close').addEventListener('click', () => {
			document.querySelector('.delete-cant').style.display = 'none';
		});

		// document.getElementById('refesh-btn').addEventListener('click', () => {
		// 	location.reload();
		// 	header("Location: manageTeacher.php");
		// });

		// Open detail tab
		document.getElementById("tab1").classList.add("show");

		function openTab(evt, tabName) {
			// Declare all variables
			var i, tabcontent, tablinks;

			// Get all elements with class="tabcontent" and hide them
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].classList.remove("show");
			}

			// Get all elements with class="tablinks" and remove the class "active"
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].classList.remove("active");
			}

			// Show the current tab, and add an "active" class to the button that opened the tab
			document.getElementById(tabName).classList.add("show");
			evt.currentTarget.classList.add("active");
		}


		//  Tài khoản
		// ẩn hiện mk
		function togglePassword() {
			var passwordInput = document.getElementById("password");
			if (passwordInput.type === "password") {
				passwordInput.type = "text";
			} else {
				passwordInput.type = "password";
			}
		}
		// Đổi mật khẩu

		document.getElementById('change-pass-btn').addEventListener('click', () => {
			document.getElementById('div-change-pass').style.display = 'block';

		});

		document.getElementById('change').addEventListener('click', function(event) {

			const form4 = document.getElementById('change-pass');
			event.preventDefault();


			var pass = document.getElementById("new-password").value;

			var con_pass = document.getElementById('confirm-password').value;

			var err_pass = '';
			var err_repass = '';
			var check_pass = true;
			console.log(pass);
			if (!pass) {
				err_pass = '*Bạn chưa nhập mật khẩu';
				check_pass = false;
			}
			if (!con_pass) {
				err_repass = '*Bạn chưa xác nhận mật khẩu';
				check_pass = false;
			} else if (pass !== con_pass) {
				err_repass = "*Mật khẩu không trùng khớp";
				check_pass = false;
			}

			document.getElementById('err-pass').textContent = err_pass;
			document.getElementById('err-repass').textContent = err_repass;


			if (!check_pass) {
				return;

			}



			document.querySelector('.change-pass-success').style.display = 'block';


			setTimeout(function() {
				document.querySelector('.change-pass-success').style.display = 'none';
				form4.submit();
			}, 1000);
		});

		document.getElementById('cancle-change-pass').addEventListener('click', () => {
			document.getElementById('div-change-pass').style.display = 'none';
			document.getElementById('err-pass').textContent = '';
			document.getElementById('err-repass').textContent = '';

		});


		// sap xep

		// sap xep bang



		var sortDirection = {}; // Store the current sort direction for each column

		function sortTable(columnIndex) {
			var table = document.getElementById('table-1');
			var tbody = table.querySelector('.tbody-1');
			var rows = Array.from(tbody.getElementsByTagName('tr'));
			var sttValues = rows.map(function(row) {
				return parseInt(row.getElementsByTagName('td')[0].innerText.trim());
			});

			rows.sort(function(a, b) {
				var aValue = a.getElementsByTagName('td')[columnIndex].innerText.trim();
				var bValue = b.getElementsByTagName('td')[columnIndex].innerText.trim();



				if (sortDirection[columnIndex] === 'asc') {
					return aValue.localeCompare(bValue);
				} else {
					return bValue.localeCompare(aValue);
				}



			});



			rows.forEach(function(row, index) {
				var sttCell = row.getElementsByTagName('td')[0];
				sttCell.innerText = sttValues[index];
			});

			rows.forEach(function(row) {
				tbody.appendChild(row);
			});


			// Reverse the sort direction for the clicked column
			if (sortDirection[columnIndex] === 'asc') {
				sortDirection[columnIndex] = 'desc';
			} else {
				sortDirection[columnIndex] = 'asc';
			}

			// Update the sort icon in the column header
			updateSortIcon(columnIndex);



		}




		function updateSortIcon(columnIndex) {
			var table = document.getElementById('table-1');
			var headers = table.querySelectorAll('th');

			headers.forEach(function(header) {
				// Remove the sort icon from all column headers
				var icon = header.querySelector('img');
				if (icon) {
					header.removeChild(icon);
				}
			});

			// Add the sort icon to the clicked column header
			var clickedHeader = headers[columnIndex];
			var sortIcon = document.createElement('img');
			sortIcon.src = '../assets/images/arrow-up-down-bold-icon.png';
			sortIcon.style.width = '20px';
			sortIcon.style.backgroundColor = 'white';
			sortIcon.style.borderRadius = '30px';
			if (sortDirection[columnIndex] === 'asc') {
				sortIcon.style.transform = 'rotate(180deg)';
			}
			clickedHeader.appendChild(sortIcon);
		}
	</script>;





</html>