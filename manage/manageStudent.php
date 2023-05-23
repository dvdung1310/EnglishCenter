<?php
require '../lib/functionStudent.php';



// unset($_POST['update']);
// unset($_POST['add']);
// unset($_POST['delete']);



$listStudent = listStudent($connection);
$listph_hs = listph_hs($connection);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['sudent_name_edit'])) {

		$mahs = $_POST['id_edit'];
		$ten = trim($_POST['sudent_name_edit']);
		$gt = $_POST['gender_edit'];
		$ns = $_POST['birthday_edit'];
		$tuoi = $_POST['age_edit'];
		$dc = trim($_POST['address_edit']);
		$sdt = $_POST['phone_number_edit'];
		$email = trim($_POST['email_edit']);
		updateStudentbyID($connection, $mahs, $ten, $gt, $ns, $tuoi, $dc, $sdt, $email);
		header("Location: manageStudent.php");
	}



	// if (isset($_POST['Student_name_add'])) {


	// 	$ten = trim($_POST['Student_name_add']);
	// 	$gt = $_POST['gender_add'];
	// 	$ns = $_POST['birthday_add'];
	// 	$tuoi = $_POST['age_add'];
	// 	$qq = trim($_POST['hometown_add']);
	// 	$dc = trim($_POST['address_add']);
	// 	$td = trim($_POST['education_add']);
	// 	$sdt = $_POST['phone_number_add'];
	// 	$email = trim($_POST['email_add']);

	// 	$mahs = insertStudent($connection, $ten, $gt, $ns, $tuoi, $qq, $dc, $td, $sdt, $email);
	// 	inserttk_gv($mahs, $sdt, '12345678', $connection);

	// 	header("Location: manageStudent.php");
	// }

	if (isset($_POST['refesh'])) {
		header("Location: manageStudent.php");
	}

	if (isset($_POST['search'])) {
		$key = trim($_POST['keyword']);
		$listStudent = searchStudent($connection, $key);
	}

	if (isset($_POST['mahs_delete'])) {
		$mahs = $_POST['mahs_delete'];
		deletetk_hs($connection, $mahs);
		deleteStudent_ph_hs($connection, $mahs);
		deleteStudent($connection, $mahs);
		header("Location: manageStudent.php");
	}
}


$jsonListStudent = json_encode($listStudent);
$jsonListph_hs = json_encode($listph_hs);


?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/manageStudent.css">

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
				<li><a href="#">Quản lý phụ huynh</a></li>
				<li><a href="#">Quản lý tài khoản</a></li>
			</ul>
		</nav>
	</header>
	<main>

		<h1>Quản lý Học viên</h1>
		<div class="search-container">
			<form id="form-search" method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
				<input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value="">
				<input type="submit" name="search" value="Tìm kiếm" style="width: 100px">
				<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
			</form>


			<div>
				<button class="add-Student-button">Thêm giáo viên</button>
			</div>
		</div>

		<table>
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên</th>
					<th>Giới tính</th>
					<th>Tuổi</th>
					<th>Quê Quán</th>
					<th>Lớp đang học</th>
					<th></th>

				</tr>
			</thead>
			<tbody class="tbody-1">
				<?php $i = 1;
				if (!$listStudent)
					echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
				else {
					foreach ($listStudent as $Student) : ?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $Student['TenHS']; ?></td>
							<td><?php echo $Student['GioiTinh']; ?></td>
							<td><?php echo $Student['Tuoi']; ?></td>
							<td><?php echo $Student['DiaChi']; ?></td>
							<td><?php
								$listClass = classOfStudent($connection, $Student['MaHS']);
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


				<h2>Thông tin học viên</h2>
				<button id="edit-button" style="position: absolute;top: 40px;right: 60px;">Sửa</button>

				<button id="delete-button" name="delete" style="position: absolute;top: 40px;right: 11px; background-color: #e90000">Xóa</button>

				<div class="container">

					<div class="header">
						<img id="img" alt="Avatar" class="avatar">

						<h1 class="name" id="Student-name"></h1>
					</div>

					<div class="detail">

						<div class="tab">
							<button class="tablinks" id="tb1" onclick="openTab(event, 'tab1')">Chung</button>
							<button class="tablinks" id="tb2" onclick="openTab(event, 'tab2')"> Lớp học</button>
							<button class="tablinks" id="tb3" onclick="openTab(event, 'tab3')">Tab 3</button>
						</div>

						<div id="tab1" class="tabcontent">

							<table>
								<tr>
									<th>Mã học viên:</th>
									<td id="Student-id"></td>
								</tr>
								<tr>
									<th>Giới tính:</th>
									<td id="Student-gender" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Ngày sinh:</th>
									<td id="Student-date" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Tuổi:</th>
									<td id="Student-age" contenteditable="false">43</td>
								</tr>

								<tr>
									<th>Địa chỉ:</th>
									<td id="Student-address" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Lớp đang học</th>
									<td id="Student-class" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Phụ huynh:</th>
									<td id="Student-parent"></td>
								</tr>

								<tr>
									<th>Số điện thoại: </th>
									<td id="Student-phone" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Email:</th>
									<td id="Student-email" contenteditable="false"></td>
								</tr>
							</table>
						</div>


						<div id="tab2" class="tabcontent">
							<div class="class-of-student">
								<p id="none-class"></p>

								<div class="class">
									<p></p>
									<table>

										<tr>
											<td>
												<p>Mã lớp học :</p>
											</td>
											<td>
												<p id="id-class"></p>
											</td>

											<td>
												<p>Số buổi học: </p>
											</td>
											<td>
												<p id="num-of-session"></p>
											</td>

										</tr>
										<tr>
											<td>
												<p>Tên lớp học :</p>
											</td>
											<td>
												<p id="name-class"></p>
											</td>

											<td>
												<p>Giáo viên : </p>
											</td>
											<td>
												<p id=""></p>
											</td>

										</tr>

										<tr>
											<td>
												<p>Học phí:</p>
											</td>
											<td>
												<p id="fee-class"></p>
											</td>

											<td>
												<p>Giảm học phí : </p>
											</td>
											<td>
												<p id="de-fee-class"></p>
											</td>

										</tr>

										<tr>
											<td>
												<p>Trạng thái:</p>
											</td>
											<td>
												<p id="status-class"></p>
											</td>

										</tr>

									</table>
								</div>



							</div>
						</div>

						<div id="tab3" class="tabcontent">
							<h2>Tab 3 Content</h2>
							<p>This is the content for Tab 3.</p>
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


						<!-- <label for="Student_id">Mã giáo viên: 1</label>
						<input type="text" id="Student_id" name="Student_id" required> -->


						<h1>Sửa thông tin học viên</h1>

						<h2 id="Student-id_edit"></h2>
						<input type="hidden" id="id_edit" name="id_edit">

						<label for="Student_name">Tên học viên: <label id="lb_name_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="sudent_name_edit" name="sudent_name_edit" required>

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
						<label for="address">Địa chỉ: <label id="lb_address_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_edit" name="address_edit" required>

						<!-- <label for="education">Trình độ: <label id="lb_education_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="education_edit" name="education_edit" required> -->

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


		<!-- Them giao vien -->
		<div class="modal-bg-add">
			<div class="modal-content-add">
				<div>
					<form id="form_add" name="form_add" method="post">


						<!-- <label for="Student_id">Mã giáo viên: 1</label>
						<input type="text" id="Student_id" name="Student_id" required> -->


						<h1>Thêm Giáo viên</h1>



						<label for="Student_name">Tên giáo viên: <label id="lb_name_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="Student_name_add" name="Student_name_add" required>

						<label for="gender">Giới tính:</label>
						<select id="gender_add" name="gender_add">
							<option>Nam</option>
							<option>Nữ</option>
						</select>

						<label for="birthday_add">Ngày sinh:</label>
						<input type="date" id="birthday_add" name="birthday_add" required><label id="lb_birthday_add" style="color:red; font-size:13px ; font-style: italic "></label>

						<label for="age" style="margin-left: 150px;">Tuổi:</label>
						<input type="number" id="age_add" name="age_add" required> <label id="lb_age_add" style="color:red; font-size:13px ; font-style: italic "></label>
						<br>
						<label for="hometown">Quê quán: <label id="lb_hometown_add" style="color:red; font-size:13px ; font-style: italic "></label> </label>
						<input type="text" id="hometown_add" name="hometown_add" required>

						<label for="address">Địa chỉ: <label id="lb_address_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_add" name="address_add" required>

						<label for="education">Trình độ: <label id="lb_education_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="education_add" name="education_add" required>

						<label for="phone_number">Số điện thoại: <label id="lb_phone_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="tel" id="phone_number_add" name="phone_number_add" required>

						<label for="email">Email: <label id="lb_email_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="email" id="email_add" name="email_add" required>


						<input type="submit" id='add' name="add" value="Thêm">

					</form>
					<button class="cancle-btn-add">Hủy bỏ</button>
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
					<input type="hidden" id="mahs_delete" name="mahs_delete">
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete" name="delete" value="Xóa"></input>
				</form>
			</div>
		</div>

		<div class="delete-cant">
			<img src="../assets/images/Close-icon.png" alt="" style=" width: 40px;">
			<h3>Học viên đang có lớp theo học <br> Không thể xóa!</h3>
			<button id="close">Đóng</button>
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
		var ds_hocsinh;
		var listClass;


		var ds_hocsinh = <?php print_r($jsonListStudent); ?>; //


		// khi nhấn vào 1 hàng , hiển thị thông tin chi tiêt
		rows.forEach((row) => {
			row.addEventListener('click', () => {

				stt_select = row.cells[0].textContent;

				listClass = row.cells[5].textContent;
				ds_hocsinh = <?php print_r($jsonListStudent); ?>;
				ds_ph_hs = <?php print_r($jsonListph_hs); ?>;

				// lay tt phu huynh
				var phhs = [];
				var j = 0;
				for (var i = 0; i < ds_ph_hs.length; i++) {
					if (ds_ph_hs[i].MaHS === ds_hocsinh[stt_select - 1].MaHS) {
						phhs[j++] = ds_ph_hs[i].TenPH;
					}
				}

				document.getElementById('Student-name').textContent = ds_hocsinh[stt_select - 1].TenHS;
				document.getElementById('Student-gender').textContent = ds_hocsinh[stt_select - 1].GioiTinh;
				document.getElementById('Student-age').textContent = ds_hocsinh[stt_select - 1].Tuoi;
				document.getElementById('Student-class').textContent = listClass;
				document.getElementById('Student-id').textContent = ds_hocsinh[stt_select - 1].MaHS;
				document.getElementById('Student-address').textContent = ds_hocsinh[stt_select - 1].DiaChi;
				document.getElementById('Student-date').textContent = ds_hocsinh[stt_select - 1].NgaySinh;
				document.getElementById('Student-phone').textContent = ds_hocsinh[stt_select - 1].SDT;
				document.getElementById('Student-email').textContent = ds_hocsinh[stt_select - 1].Email;

				phhs.forEach(function(name) {
					const pTag = document.createElement("p"); // Tạo thẻ p mới
					pTag.innerText = name; // Gán giá trị tên vào thẻ p
					const tdTag = document.getElementById("Student-parent"); // Lấy đối tượng td có id là Student-parent
					tdTag.appendChild(pTag);
				});

				// document.getElementById('Student-parent').textContent =

				document.getElementById('mahs_delete').value = ds_hocsinh[stt_select - 1].MaHS;

				var img = document.getElementById("img");

				if (ds_hocsinh[stt_select - 1].GioiTinh == "Nam") {
					img.src = "../assets/images/Student-male-icon.png";
				} else {
					img.src = "../assets/images/Student-female-icon.png";
				}

				document.getElementById("tab1").classList.add("show");
				document.getElementById("tb1").classList.add("active");
				document.getElementById("tb2").classList.remove("active");
				document.getElementById("tb3").classList.remove("active");

				modalBg.style.display = 'block';



			});
		});
		document.querySelector('.close-btn').addEventListener('click', () => {
			modalBg.style.display = 'none';
			const paragraphs = document.getElementsByTagName("p");
			while (paragraphs.length > 0) {
				paragraphs[0].parentNode.removeChild(paragraphs[0]);
			}
		});



		const editButton = document.getElementById('edit-button');
		// const tdList = document.querySelectorAll('td[contenteditable]');

		const modalBgEdit = document.querySelector('.modal-bg-edit');
		const modalContentEdit = document.querySelector('.modal-content-edit');

		// Khi người dùng nhấn vào nút "Sửa"
		editButton.addEventListener('click', () => {
			document.getElementById('lb_phone_edit').textContent = "";
			document.getElementById('lb_email_edit').textContent = "";
			document.getElementById('lb_name_edit').textContent = "";

			document.getElementById('lb_address_edit').textContent = "";
			// document.getElementById('lb_education_edit').textContent = "";
			document.getElementById('lb_age_edit').textContent = "";
			document.getElementById('lb_birthday_edit').textContent = "";

			modalBgEdit.style.display = "block";


			document.getElementById('sudent_name_edit').value = ds_hocsinh[stt_select - 1].TenHS;

			var gt = ds_hocsinh[stt_select - 1].GioiTinh;
			var selectTag = document.getElementById("gender_edit");
			for (var i = 0; i < selectTag.options.length; i++) {
				if (selectTag.options[i].value == gt) {
					selectTag.options[i].selected = true; // nếu giống nhau, đặt thuộc tính selected cho option
					break;
				}
			}

			document.getElementById('birthday_edit').value = ds_hocsinh[stt_select - 1].NgaySinh;
			document.getElementById('age_edit').value = ds_hocsinh[stt_select - 1].Tuoi;
			document.getElementById('Student-id_edit').textContent = "Mã Học viên : " + ds_hocsinh[stt_select - 1].MaHS;
			document.getElementById('address_edit').value = ds_hocsinh[stt_select - 1].DiaChi;
			document.getElementById('phone_number_edit').value = ds_hocsinh[stt_select - 1].SDT;
			document.getElementById('email_edit').value = ds_hocsinh[stt_select - 1].Email;
			// document.getElementById('education_edit').value = ds_hocsinh[stt_select - 1].TrinhDo;
			document.getElementById('id_edit').value = ds_hocsinh[stt_select - 1].MaHS;
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

			const Student_name = document.getElementById('sudent_name_edit').value;
			const age = document.getElementById('age_edit').value;

			const address = document.getElementById('address_edit').value;
			// const education = document.getElementById('education_edit').value;
			const birthday = document.getElementById('birthday_edit').value;

			var erorr_empty = "*Dữ liệu không để trống";

			//Kiểm tra dữ liệu nhập vào
			if (!Student_name) {
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


		//Thêm giáo viên
		const modalBgAdd = document.querySelector('.modal-bg-add');
		const modalContentAdd = document.querySelector('.modal-content-add');

		// Khi nhấn "thêm giáo viên"
		document.querySelector('.add-Student-button').addEventListener('click', () => {
			modalBgAdd.style.display = 'block';
		})
		// Huy bo 
		document.querySelector('.cancle-btn-add').addEventListener('click', () => {
			modalBgAdd.style.display = 'none';
		});

		// Khi nhấn Thêm
		const submit_add = document.getElementById('add');
		submit_add.addEventListener('click', function(event) {

			const form2 = document.getElementById('form_add')
			// Ngăn chặn việc submit form mặc định để xử lý dữ liệu trước khi gửi form đi
			event.preventDefault();
			const phone_number = document.getElementById('phone_number_add').value;
			const email = document.getElementById('email_add').value;
			const Student_name = document.getElementById('Student_name_add').value;
			const age = document.getElementById('age_add').value;
			const hometown = document.getElementById('hometown_add').value;
			const address = document.getElementById('address_add').value;
			const education = document.getElementById('education_add').value;
			const birthday = document.getElementById('birthday_add').value;

			var erorr_empty = "*Dữ liệu không để trống";

			//Kiểm tra dữ liệu nhập vào

			if (!Student_name) {
				document.getElementById('lb_name_add').textContent = erorr_empty;
				return;
			} else
				document.getElementById('lb_name_add').textContent = "";

			if (!birthday) {
				document.getElementById('lb_birthday_add').textContent = erorr_empty;
				return;
			} else
				document.getElementById('lb_birthday_add').textContent = "";

			if (!age) {
				document.getElementById('lb_age_add').textContent = erorr_empty;
				return;
			} else
				document.getElementById('lb_age_add').textContent = "";

			if (!hometown) {

				document.getElementById('lb_hometown_add').textContent = erorr_empty;
				return;
			} else
				document.getElementById('lb_hometown_add').textContent = "";

			if (!address) {

				document.getElementById('lb_address_add').textContent = erorr_empty;
				return;
			} else
				document.getElementById('lb_address_add').textContent = "";
			if (!education) {

				document.getElementById('lb_education_add').textContent = erorr_empty;
				return;
			} else
				document.getElementById('lb_education_add').textContent = "";
			if (!(/^(0[0-9]{9})$/.test(phone_number))) {
				document.getElementById('lb_phone_add').textContent = "*Số điện thoại không chính xác (0[0-9]; 10 chữ số)";
				return;
			} else
				document.getElementById('lb_phone_add').textContent = "";

			if (!(/\S+@\S+\.\S+/.test(email))) {
				document.getElementById('lb_email_add').textContent = "*Email không chính xác (example@xxx.com)";
				return;
			} else
				document.getElementById('lb_email_add').textContent = "";


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
		// 	header("Location: manageStudent.php");
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

		// document.getElementById("defaultTab").click();

		// function openTab(evt, tabName) {
		// 	var i, tabcontent, tablinks;
		// 	tabcontent = document.getElementsByClassName("tabcontent");
		// 	for (i = 0; i < tabcontent.length; i++) {
		// 		tabcontent[i].style.display = "none";
		// 	}
		// 	tablinks = document.getElementsByClassName("tablinks");
		// 	for (i = 0; i < tablinks.length; i++) {
		// 		tablinks[i].className = tablinks[i].className.replace(" active", "");
		// 	}
		// 	document.getElementById(tabName).style.display = "block";
		// 	evt.currentTarget.className += " active";
		// }
	</script>;





</html>