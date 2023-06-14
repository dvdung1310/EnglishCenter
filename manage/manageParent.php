<?php
require '../lib/functionParent.php';

$listParent = listParent($connection);
$listph_hs = listph_hs($connection);
$lisths_lop = listLopOfchid($connection);
$listtk_ph = listtk_ph($connection);

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
		deleteLKPHHS($connection,$maph);

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
$jsonListtk_ph = json_encode($listtk_ph);

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
			<img src="../assets/images/logo-web.png" alt="Logo">

		</div>
		<nav>
			<ul>
				<li><a href="./ListClass.php">Quản lý lớp học</a></li>
				<li><a href="../manage/manageStudent.php">Quản lý học viên</a></li>
				<li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a style="color: #0088cc;" href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
				<li><a href="../manage/ManageFinance.php">Quản lý tài chính</a></li>
				<li><a href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
				<li><a href="../pages/home/home.php" style="display: flex;"><img src="../assets/images/icon-logout.png" alt="" style="width:20px"></a></li>

			</ul>
		</nav>
	</header>
	<main>

		<h1>Quản lý Phụ huynh</h1>
		<div class="search-container">
			<form id="form-search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
				<input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value="<?php if(isset($_POST['keyword'])) echo  $_POST['keyword']?>">
				<input type="submit" name="search" value="Tìm kiếm" style="width: 100px">
				<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
			</form>

		</div>

		<table id="table-1">
			<thead>
				<tr>
					<th onclick="sortTable(0)">STT</th>
					<th onclick="sortTable(1)">Mã phụ huynh</th>
					<th onclick="sortTable(2)">Họ tên</th>
					<th onclick="sortTable(3)">Giới tính</th>
					<th onclick="sortTable(4)">Tuổi</th>
					<th onclick="sortTable(5)" style="width :200px">Địa chỉ</th>
					<th onclick="sortTable(6)">Phụ huynh của</th>

				</tr>
			</thead>
			<tbody class="tbody-1">
				<?php $i = 1;
				$nam=0;$nu = 0;
				if (!$listParent) {
					echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
				} else {
					foreach ($listParent as $Parent) : ?>
					<?php if($Parent['GioiTinh'] == 'Nam') $nam++;
							else $nu++; ?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $Parent['MaPH']; ?></td>
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
							<button class="tablinks" id="tb2" onclick="openTab(event, 'tab2')">Học viên liên kết</button>
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



						</div>





						<div id="tab2" class="tabcontent">
							<div id="child-infor">


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
												<h5 id="err-pass" style="color: red;font-style: italic;  font-size: 14px;"></h5>
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
												<h5 id="err-repass" style="color: red;font-style: italic;  font-size: 14px;"></h5>
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


		<p style="margin-left: 80%; font-style:italic; font-size:13px"> <?php echo '*Tổng số phụ huynh: '. $i-1 . '  Nam: '.$nam.'  Nữ: '.$nu ?> </p>

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
		var ds_phuhuynh;
		var parent_select;



		var ds_phuhuynh = <?php print_r($jsonListParent); ?>; //


		// khi nhấn vào 1 hàng , hiển thị thông tin chi tiêt
		rows.forEach((row) => {
			row.addEventListener('click', () => {

				stt_select = row.cells[1].textContent;

				// listClass = row.cells[5].textContent;
				ds_phuhuynh = <?php print_r($jsonListParent); ?>;
				ds_hs_of_ph = <?php print_r($jsonListph_hs); ?>;
				ds_hs_lop = <?php print_r($jsonLisths_lop); ?>;
				ds_tk_ph = <?php print_r($jsonListtk_ph); ?>;

				for (var i = 0; i < ds_phuhuynh.length; i++) {
					if (stt_select == ds_phuhuynh[i].MaPH)
						parent_select = ds_phuhuynh[i];
				}
				//lay tt con cai
				var hs_of_ph = [];
				var j = 0;
				for (var i = 0; i < ds_hs_of_ph.length; i++) {
					if (ds_hs_of_ph[i].MaPH === parent_select.MaPH) {
						hs_of_ph[j++] = ds_hs_of_ph[i].TenHS;
					}
				}

				document.getElementById('Parent-name').textContent = parent_select.TenPH;
				document.getElementById('Parent-gender').textContent = parent_select.GioiTinh;
				document.getElementById('Parent-age').textContent = parent_select.Tuoi;
				// document.getElementById('Parent-class').textContent = listClass;
				document.getElementById('Parent-id').textContent = parent_select.MaPH;
				document.getElementById('Parent-address').textContent = parent_select.DiaChi;
				document.getElementById('Parent-date').textContent =  convertDateFormat(parent_select.NgaySinh);
				document.getElementById('Parent-phone').textContent = parent_select.SDT;
				document.getElementById('Parent-email').textContent = parent_select.Email;


				var html_hs = '';
				hs_of_ph.forEach(function(name) {
					// const pTag = document.createElement("h4"); // Tạo thẻ p mới
					// pTag.innerText = name; // Gán giá trị tên vào thẻ p
					// pTag.classList.add("infor-student");
					html_hs += '<p class ="infor-student">' + name + '</p>';
					// tdTag.appendChild(pTag);
				});
				const tdTag = document.getElementById("Parent-parent"); // Lấy đối tượng td có id là Parent-parent
				tdTag.innerHTML = html_hs;




				// document.getElementById('Parent-parent').textContent =

				document.getElementById('maph_delete').value = parent_select.MaPH;

				var img = document.getElementById("img");

				if (parent_select.GioiTinh == "Nam") {
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

				//thong tin con cua phu huynh
				var child = [];
				var k = 0;
				for (var i = 0; i < ds_hs_of_ph.length; i++) {
					if (ds_hs_of_ph[i].MaPH === parent_select.MaPH) {
						child[k++] = ds_hs_of_ph[i];
					}
				}






				var html = '';

				if (child.length === '0') {
					html += '<p> Phụ huynh này chưa liên kết với học viên</p>';
				} else {
					html += '<p> Số học viên liên kết : ' + child.length + '</p>';

					for (var i = 0; i < child.length; i++) {



						html += '<div class="child">' +
							'<p></p>' +
							'<table>' +
							'<tr>' +

							'<td>' +
							'<p ><strong> Họ tên :</strong>' + '   ' + child[i]['TenHS'] + '</p>' +
							'</td>' +

							'<td>' +
							'<p ><strong> Tuổi :</strong>' + '   ' + child[i]['Tuoi'] + '</p>' +
							'</td>' +

							'</tr>' +


							'<tr>' +

							'<td>' +
							'<p ><strong> Giới tính :</strong>' + '   ' + child[i]['GioiTinh'] + '</p>' +
							'</td>' +

							'<td>' +
							'<p ><strong> Ngày sinh :</strong>' + '   ' + convertDateFormat(child[i]['NgaySinh']) + '</p>' +
							'</td>' +
							'</tr>' +
							'<tr>' +

							'<td>' +
							'<p ><strong>Số điện thoại :</strong>' + '   ' + child[i]['SDT'] + '</p>' +
							'</td>' +

							'<td>' +
							'<p ><strong>Email :</strong>' + '   ' + child[i]['Email'] + '</p>' +
							'</td>' +
							'</tr>' +
							'<tr>' +

							'<td>' +
							'<p ><strong> Lớp học :</strong>' + '   ';

						var k=true;
						for (var j = 0; j < ds_hs_lop.length; j++) {
							if (ds_hs_lop[j].MaHS === child[i]['MaHS']) {
								html += ds_hs_lop[j].MaLop + ' ;  ';
								k=false;
							}
						}
						if(k){
							html +="(Chưa tham gia lớp học nào)"
						}




						html += '</p>' +
							'</td>' +
							'</tr>' +

							'</table>' +
							'</div>';
					}

					document.querySelector("#child-infor").innerHTML = html;

				}

				//thong tin tai khoan
				var username = '';
				var pass = '';
				for (var i = 0; i < ds_tk_ph.length; i++) {
					if (ds_tk_ph[i].MaPH === parent_select.MaPH) {
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
			document.getElementById('err-pass').textContent = '';
			document.getElementById('err-repass').textContent = '';
			const paragraphs = document.getElementsByTagName("p");
			while (paragraphs.length > 0) {
				paragraphs[0].parentNode.removeChild(paragraphs[0]);
			}

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


			document.getElementById('parent_name_edit').value = parent_select.TenPH;

			var gt = parent_select.GioiTinh;
			var selectTag = document.getElementById("gender_edit");
			for (var i = 0; i < selectTag.options.length; i++) {
				if (selectTag.options[i].value == gt) {
					selectTag.options[i].selected = true; // nếu giống nhau, đặt thuộc tính selected cho option
					break;
				}
			}

			document.getElementById('birthday_edit').value = parent_select.NgaySinh;
			document.getElementById('age_edit').value = parent_select.Tuoi;
			document.getElementById('parent-id_edit').textContent = "Mã Học viên : " + parent_select.MaPH;
			document.getElementById('address_edit').value = parent_select.DiaChi;
			document.getElementById('phone_number_edit').value = parent_select.SDT;
			document.getElementById('email_edit').value = parent_select.Email;

			document.getElementById('id_edit').value = parent_select.MaPH;
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
			document.getElementById('err-pass').textContent = '';
			document.getElementById('err-repass').textContent = '';
			document.getElementById('div-change-pass').style.display = 'none';

		});


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