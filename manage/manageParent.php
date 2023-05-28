<?php
require '../lib/functionParent.php';



$listParent = listParent($connection);
$listph_hs = listph_hs($connection);
// $lisths_lop = lisths_lop($connection);
$listtk_ph =  listtk_ph($connection);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['parent_name_edit'])) {

		$maph = $_POST['id_edit'];
		$ten = trim($_POST['parent_name_edit']);
		$gt = $_POST['gender_edit'];
		$ns = $_POST['birthday_edit'];
		$tuoi = $_POST['age_edit'];
		$dc = trim($_POST['address_edit']);
		$sdt = $_POST['phone_number_edit'];
		$email = trim($_POST['email_edit']);
		updateParentbyID($connection, $maph, $ten, $gt, $ns, $tuoi, $dc, $sdt, $email);
		header("Location: manageParent.php");
	}


	if (isset($_POST['refesh'])) {
		header("Location: manageParent.php");
	}

	if (isset($_POST['search'])) {
		$key = trim($_POST['keyword']);
		$listParent = searchParent($connection, $key);
	}

	if (isset($_POST['maph_delete'])) {
		$maph = $_POST['maph_delete'];
		deletetk_ph($connection, $maph);
		deleteParent_ph_hs($connection, $maph);
		deleteParent($connection, $maph);
		header("Location: manageParent.php");
	}

	if (isset($_POST['username-login'])) {
		$username = $_POST['username-login'];
		$pass = $_POST['new-password'];

		updatePassPH($connection, $username, $pass);
		header("Location: manageParent.php");
	}
}


$jsonListParent = json_encode($listParent);
$jsonListph_hs = json_encode($listph_hs);
$jsonLisths_lop = json_encode($lisths_lop);
$jsonListtk_ph =  json_encode($listtk_ph);


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/manageParent.css">

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
				<li><a href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
				<li><a href="#">Quản lý tài khoản</a></li>
			</ul>
		</nav>
	</header>
	<main>

		<h1>Quản lý Phụ huynh</h1>
		<div class="search-container">
			<form id="form-search" method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
				<input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value="">
				<input type="submit" name="search" value="Tìm kiếm" style="width: 100px">
				<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
			</form>

		</div>

		<table>
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên</th>
					<th>Giới tính</th>
					<th>Tuổi</th>
					<th style="width :200px">Địa chỉ</th>
					<th>Phụ huynh của</th>

				</tr>
			</thead>
			<tbody class="tbody-1">
				<?php $i = 1;
				if (!$listParent)
					echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
				else {
					foreach ($listParent as $Parent) : ?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $Parent['TenPH']; ?></td>
							<td><?php echo $Parent['GioiTinh']; ?></td>
							<td><?php echo $Parent['Tuoi']; ?></td>
							<td style="width :200px"><?php echo $Parent['DiaChi']; ?></td>
							<td><?php

								foreach ($listph_hs as $hs) :
									if ($hs['MaPH'] === $Parent['MaPH']) {
										echo $hs['TenHS'];
										echo '<br>';
									}
								endforeach;
								?></td>


						</tr>
				<?php endforeach;
				} ?>



			</tbody>
		</table>

		<!-- Thong tin chi tiet -->
		<div class="modal-bg">
			<div class="modal-content">


				<h2>Thông tin phụ huynh</h2>
				<button id="edit-button" style="position: absolute;top: 40px;right: 60px;">Sửa</button>

				<button id="delete-button" name="delete" style="position: absolute;top: 40px;right: 11px; background-color: #e90000">Xóa</button>

				<div class="container">

					<div class="header">
						<img id="img" alt="Avatar" class="avatar">

						<h1 class="name" id="Parent-name"></h1>
					</div>

					<div class="detail">

						<div class="tab">
							<button class="tablinks" id="tb1" onclick="openTab(event, 'tab1')">Chung</button>
							<button class="tablinks" id="tb2" onclick="openTab(event, 'tab2')"> Lớp học</button>
							<button class="tablinks" id="tb3" onclick="openTab(event, 'tab3')">Tài khoản</button>
						</div>

						<div id="tab1" class="tabcontent">

							<table>
								<tr>
									<th>Mã phụ huynh:</th>
									<td id="Parent-id"></td>
								</tr>
								<tr>
									<th>Giới tính:</th>
									<td id="Parent-gender" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Ngày sinh:</th>
									<td id="Parent-date" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Tuổi:</th>
									<td id="Parent-age" contenteditable="false">43</td>
								</tr>

								<tr>
									<th>Địa chỉ:</th>
									<td id="Parent-address" contenteditable="false"></td>
								</tr>

								<!-- <tr>
									<th>Lớp đang học</th>
									<td id="Parent-class" contenteditable="false"></td>
								</tr> -->

								<tr>
									<th>Phụ huynh của học viên:</th>
									<td id="Parent-parent"></td>
								</tr>

								<tr>
									<th>Số điện thoại: </th>
									<td id="Parent-phone" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Email:</th>
									<td id="Parent-email" contenteditable="false"></td>
								</tr>
							</table>


							<div class="div-student-info">
								<table>
									<tr>
										<td style="unset">
											<p><strong>Tên:</strong> John Doe</p>
										</td>
										<td>
											<p><strong>Tuổi:</strong> 25</p>
										</td>
									</tr>
									<tr>
										<td>
											<p><strong>Giới tính:</strong> Nam</p>
										</td>
										<td>
											<p><strong>Ngày sinh:</strong> 01/01/1998</p>
										</td>
									</tr>
								</table>
								<p><strong>Số điện thoại:</strong> 0123456789</p>
								<p><strong>Email:</strong> johndoe@example.com</p>
								<p><strong>Lớp đang học:</strong> Lập trình web cơ bản</p>
							</div>
						</div>


						<div id="tab2" class="tabcontent">
							<div class="class-of-Parent">

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


				</div>

				<button class="close-btn">Đóng</button>
			</div>
		</div>

		<!-- Sua thong tin -->
		<div class="modal-bg-edit">
			<div class="modal-content-edit">
				<div>
					<form id="form_edit" name="form_edit" method="post">


						<!-- <label for="Parent_id">Mã giáo viên: 1</label>
						<input type="text" id="Parent_id" name="Parent_id" required> -->


						<h1>Sửa thông tin Phụ huynh</h1>

						<h2 id="parent-id_edit"></h2>
						<input type="hidden" id="id_edit" name="id_edit">

						<label for="parent_name">Tên phụ huynh: <label id="lb_name_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="parent_name_edit" name="parent_name_edit" required>

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
						<label for="address_edit">Địa chỉ: <label id="lb_address_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_edit" name="address_edit" required>

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



		<!-- Thong bao -->

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
					<input type="hidden" id="maph_delete" name="maph_delete">
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete" name="delete" value="Xóa"></input>
				</form>
			</div>
		</div>

		<div class="delete-cant">
			<img src="../assets/images/Close-icon.png" alt="" style=" width: 40px;">
			<h3>Học viên đang có lớp theo học <br> Không thể xóa!</h3>
			<button id="close">Đóng</button>
		</div>

		<div class="change-pass-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thay đổi mật khẩu thành công!</h3>
		</div>



	</main>




	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>

	<script>
		const rows = document.querySelectorAll('.tbody-1 tr');
		const modalBg = document.querySelector('.modal-bg');
		const modalContent = document.querySelector('.modal-content');




		var stt_select;
		var ds_phuhuynh;
		// var listClass;



		var ds_phuhuynh = <?php print_r($jsonListParent); ?>; //


		// khi nhấn vào 1 hàng , hiển thị thông tin chi tiêt
		rows.forEach((row) => {
			row.addEventListener('click', () => {

				stt_select = row.cells[0].textContent;

				// listClass = row.cells[5].textContent;
				ds_phuhuynh = <?php print_r($jsonListParent); ?>;
				ds_hs_of_ph = <?php print_r($jsonListph_hs); ?>;
				ds_hs_lop = <?php print_r($jsonLisths_lop); ?>;
				ds_tk_ph = <?php print_r($jsonListtk_ph); ?>;

				//lay tt con cai
				var hs_of_ph = [];
				var j = 0;
				for (var i = 0; i < ds_hs_of_ph.length; i++) {
					if (ds_hs_of_ph[i].MaPH === ds_phuhuynh[stt_select - 1].MaPH) {
						hs_of_ph[j++] = ds_hs_of_ph[i].TenHS;
					}
				}

				document.getElementById('Parent-name').textContent = ds_phuhuynh[stt_select - 1].TenPH;
				document.getElementById('Parent-gender').textContent = ds_phuhuynh[stt_select - 1].GioiTinh;
				document.getElementById('Parent-age').textContent = ds_phuhuynh[stt_select - 1].Tuoi;
				// document.getElementById('Parent-class').textContent = listClass;
				document.getElementById('Parent-id').textContent = ds_phuhuynh[stt_select - 1].MaPH;
				document.getElementById('Parent-address').textContent = ds_phuhuynh[stt_select - 1].DiaChi;
				document.getElementById('Parent-date').textContent = ds_phuhuynh[stt_select - 1].NgaySinh;
				document.getElementById('Parent-phone').textContent = ds_phuhuynh[stt_select - 1].SDT;
				document.getElementById('Parent-email').textContent = ds_phuhuynh[stt_select - 1].Email;



				hs_of_ph.forEach(function(name) {
					const pTag = document.createElement("p"); // Tạo thẻ p mới
					pTag.innerText = name; // Gán giá trị tên vào thẻ p
					pTag.classList.add("infor-student");

					const tdTag = document.getElementById("Parent-parent"); // Lấy đối tượng td có id là Parent-parent
					tdTag.appendChild(pTag);

				});

				// document.getElementById('Parent-parent').textContent =

				document.getElementById('maph_delete').value = ds_phuhuynh[stt_select - 1].MaPH;

				var img = document.getElementById("img");

				if (ds_phuhuynh[stt_select - 1].GioiTinh == "Nam") {
					img.src = "../assets/images/Parent-male-icon.png";
				} else {
					img.src = "../assets/images/Parent-female-icon.png";
				}

				document.getElementById("tab1").classList.add("show");
				document.getElementById("tab2").classList.remove("show");
				document.getElementById("tab3").classList.remove("show");
				document.getElementById("tb1").classList.add("active");
				document.getElementById("tb2").classList.remove("active");
				document.getElementById("tb3").classList.remove("active");

				// thong tin lop cua hoc vien
				// var classes = [];
				// var k = 0;
				// for (var i = 0; i < ds_hs_lop.length; i++) {
				// 	if (ds_hs_lop[i].MaHS === ds_phuhuynh[stt_select - 1].MaHS) {
				// 		classes[k++] = ds_hs_lop[i];
				// 	}
				// }


				// var html = '';

				// if (classes.length === '0'){
				// 	html += '<p>Học viên chưa tham gia lớp học nào </p>';
				// }
				// else {
				// 	html += '<p> Số lớp đã tham gia: ' + classes.length + '</p>';

				// 	for (var i = 0; i < classes.length; i++) {

				// 		html += '<div class="class">' +
				// 			'<p></p>' +
				// 			'<table>' +
				// 			'<tr>' +

				// 			'<td>' +
				// 			'<p id="id-class">Mã lớp học:  ' + classes[i]['MaLop'] + '</p>' +
				// 			'</td>' +

				// 			'<td>' +
				// 			'<p id="num-of-session">Số buổi học:  ' + classes[i]['SoBuoiDaToChuc'] + '/' + classes[i]['SoBuoi'] + ' (Vắng : ' + classes[i]['SoBuoiNghi'] + ') </p>' +
				// 			'</td>' +
				// 			'</tr>' +
				// 			'<tr>' +

				// 			'<td>' +
				// 			'<p id="name-class">Tên lớp học:  ' + classes[i]['TenLop'] + '</p>' +
				// 			'</td>' +

				// 			'<td>' +
				// 			'<p id="name =name-teacher">Tên giáo viên:  ' + classes[i]['TenGV'] + '</p>' +
				// 			'</td>' +
				// 			'</tr>' +
				// 			'<tr>' +

				// 			'<td>' +
				// 			'<p id="fee-class">Học phí:  ' + classes[i]['HocPhi'] + '/buổi' + '</p>' +
				// 			'</td>' +

				// 			'<td>' +
				// 			'<p id="de-fee-class">Giảm học phí:  ' + classes[i]['GiamHocPhi'] + '%' + '</p>' +
				// 			'</td>' +
				// 			'</tr>' +
				// 			'<tr>' +

				// 			'<td>' +
				// 			'<p id="status-class">Trạng thái:  ' + classes[i]['TrangThai'] + '</p>' +
				// 			'</td>' +
				// 			'</tr>' +
				// 			'</table>' +
				// 			'</div>';
				// 	}

				// 	document.querySelector(".class-of-Parent").innerHTML = html;

				// }

				//thong tin tai khoan 
				var username = '';
				var pass = '';
				for (var i = 0; i < ds_tk_ph.length; i++) {
					if (ds_tk_ph[i].MaPH === ds_phuhuynh[stt_select - 1].MaPH) {
						username = ds_tk_ph[i]['UserName'];
						pass = ds_tk_ph[i]['Password']
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
			modalBg.style.display = 'none';

			const paragraphs = document.getElementsByTagName("p");
			while (paragraphs.length > 0) {
				paragraphs[0].parentNode.removeChild(paragraphs[0]);
			}
			document.querySelector(".class-of-Parent").innerHTML = '';

		});



		const editButton = document.getElementById('edit-button');
		// const tdList = document.querySelectorAll('td[contenteditable]');

		const modalBgEdit = document.querySelector('.modal-bg-edit');
		const modalContentEdit = document.querySelector('.modal-content-edit');

		// Khi  nhấn vào nút "Sửa"
		editButton.addEventListener('click', () => {
			document.getElementById('lb_phone_edit').textContent = "";
			document.getElementById('lb_email_edit').textContent = "";
			document.getElementById('lb_name_edit').textContent = "";

			document.getElementById('lb_address_edit').textContent = "";

			document.getElementById('lb_age_edit').textContent = "";
			document.getElementById('lb_birthday_edit').textContent = "";

			modalBgEdit.style.display = "block";


			document.getElementById('parent_name_edit').value = ds_phuhuynh[stt_select - 1].TenPH;

			var gt = ds_phuhuynh[stt_select - 1].GioiTinh;
			var selectTag = document.getElementById("gender_edit");
			for (var i = 0; i < selectTag.options.length; i++) {
				if (selectTag.options[i].value == gt) {
					selectTag.options[i].selected = true; // nếu giống nhau, đặt thuộc tính selected cho option
					break;
				}
			}

			document.getElementById('birthday_edit').value = ds_phuhuynh[stt_select - 1].NgaySinh;
			document.getElementById('age_edit').value = ds_phuhuynh[stt_select - 1].Tuoi;
			document.getElementById('parent-id_edit').textContent = "Mã Học viên : " + ds_phuhuynh[stt_select - 1].MaPH;
			document.getElementById('address_edit').value = ds_phuhuynh[stt_select - 1].DiaChi;
			document.getElementById('phone_number_edit').value = ds_phuhuynh[stt_select - 1].SDT;
			document.getElementById('email_edit').value = ds_phuhuynh[stt_select - 1].Email;

			document.getElementById('id_edit').value = ds_phuhuynh[stt_select - 1].MaPH;
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

			const parent_name = document.getElementById('parent_name_edit').value;
			const age = document.getElementById('age_edit').value;

			const address = document.getElementById('address_edit').value;
			// const education = document.getElementById('education_edit').value;
			const birthday = document.getElementById('birthday_edit').value;

			var erorr_empty = "*Dữ liệu không được để trống";

			//Kiểm tra dữ liệu nhập vào
			if (!parent_name) {
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

			if (!address) {

				document.getElementById('lb_address_edit').textContent = erorr_empty;
				check = false;
			} else
				document.getElementById('lb_address_edit').textContent = "";

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
			// if (listClass.length != 0) {
			// 	document.querySelector('.delete-cant').style.display = 'block';
			// 	return;
			// }

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
		// 	header("Location: manageParent.php");
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

		});


		// hien thi tt hoc sinh

		const infoStudents = document.querySelectorAll(".infor-student");
		const hiddenDiv = document.getElementById("hidden-div");

		// Bắt sự kiện mouseover trên các thẻ p có class "infor-student"
		infoStudents.forEach((infoStudent) => {
			infoStudent.addEventListener("mouseover", () => {
				hiddenDiv.style.display = "block";
			});
		});

		// Bắt sự kiện mouseout để ẩn đi thẻ div
		hiddenDiv.addEventListener("mouseout", () => {
			hiddenDiv.style.display = "none";
		});
	</script>;

</html>