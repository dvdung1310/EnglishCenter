<?php
require '../lib/functionFin_wageTea.php';

// $listBill = listBill($connection);

$listBill = searchLuongGV($connection, '');
$listgv_lopxlop = select_gv_LopxLop($connection);
$listgv_lopxdd = select_gv_LopxDD($connection);
$listTeacher = selectTeacher($connection);
$listSoBuoiDayAll =  selectSoBuoiDayAll($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST['bill-name-add'])) {

		$ten = trim($_POST['bill-name-add']);
		$thang = $_POST['bill-month-add'];
		$nam = $_POST['bill-year-add'];
		$thoiGian = $thang . "/" . $nam;


		if (!empty($_POST['teacher-add-bill'])) {
			$gv = $_POST['teacher-add-bill'];
		
			$arrayTeacher = explode(",", $gv);
		}

		foreach ($arrayTeacher as $t) {
			$lop = '';
			$st = 0;
			echo $t;
			$listBDay = selectSoBuoiDay($connection, $thang, $nam, $t);
			for ($i = 0; $i < count($listBDay); $i++) {

				if ($i == count($listBDay) - 1) {
					$lop .= $listBDay[$i]['MaLop'];
				} else {
					$lop .= $listBDay[$i]['MaLop'] . ', ';
				}
				$st +=  $listBDay[$i]['SoBuoiDay'] * $listBDay[$i]['TienTraGV'];
			}


			insertluongGV($connection, $ten, $t, $lop, $thoiGian, $st);
			header("Location: manageFinance_wageTea.php");
		}
	}

	if (isset($_POST['status-detail'])) {

		
		$tt = $_POST['status-detail'];
		$maL = $_POST['id-wage'];
		
		if($tt == 'Đã thanh toán'){
			$tg = date('Y-m-d');
		}
		else
		$tg = null;
		updateStatusLuonggv($connection,$tt,$tg,$maL);


		header("Location: manageFinance_wageTea.php");
	}



	if (isset($_POST['bill-name-add-ps'])) {

		$ten = trim($_POST['bill-name-add-ps']);
		$magv = $_POST['name-teacher-s'];
		$soTien =  $_POST['money-add-bill'];
		$soTien =  str_replace(',', '', $soTien);

		$thoiGian = date('n/Y');
		echo $magv;

		insertluongGV($connection, $ten, $magv, '', $thoiGian, $soTien);


		header("Location: manageFinance_wageTea.php");
		
	}

	if (isset($_POST['refesh'])) {
		header("Location: manageFinance_wageTea.php");
	}

	if (isset($_POST['search'])) {
		$key = trim($_POST['keyword']);
		$listBill = searchLuongGV($connection, $key);
	}

		if (isset($_POST['mahd-delete'])) {

			$mahd = $_POST['mahd-delete'];
			
			deleteLuongGV($connection, $mahd);
			header("Location: manageFinance_wageTea.php");
		}

		if (isset($_POST['mahd-delete-2'])) {

			$mahd = $_POST['mahd-delete-2'];
		
			deleteLuongGV($connection, $mahd);

			header("Location: manageFinance_wageTea.php");
		}

	
}

$jslistBill = json_encode($listBill);
$jslistgv_lopxlop = json_encode($listgv_lopxlop);
$jslistgv_lopxdd = json_encode($listgv_lopxdd);

$jslistTeacher = json_encode($listTeacher);
$jslistSoBuoiDayAll = json_encode($listSoBuoiDayAll);




?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/manageFinance_wageTea.css">

</head>

<body>
	<header>
		<div class="logo">
			<img src="../assets/images/logo-web.png" alt="Logo">
		</div>
		<nav>
			<ul>
				<li><a href="./ListClass.php">Quản lý lớp học</a></li>
				<li><a href="../manage/ManageStudent.php">Quản lý học viên</a></li>
				<li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
				<li><a style="color: #0088cc;"href="../manage/ManageFinance.php">Quản lý tài chính</a></li>
				<li><a href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
				<li><a href="../pages/home/home.php" style="display: flex;"><img src="../assets/images/icon-logout.png" alt="" style="width:20px"></a></li>
			</ul>
		</nav>
	</header>
	<main>

		<div class="tab">
			<button class="tablinks" id='btn-tab1'>Thu học phí</button>
			<button class="tablinks" id='btn-tab2'>Chi phí</button>
			<button class="tablinks" id='btn-tab3'>Lịch sử thu chi</button>
		
		</div>
		<div id="nav-container-Tab2">

			<a href="./manageFinance_wageTea.php" id="btn-tab-luongGV">Lương giáo viên</a>
			<a href="./manageFinance_OtherFee.php" id="btn-tab-chiPhiKhac">Chi phí khác</a>
			

		</div>

		<div id="Tab1" class="tabcontent">
			<h1>Thông tin lương giáo viên</h1>
			<div class="search-container">
				<form id="form-search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
					<input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value=" <?php if(isset($_POST['keyword'])) echo  $_POST['keyword']?> ">
					<input type="submit" name="search" id="search" value="Tìm kiếm" style="width: 100px">
					<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
				</form>
				<div style="display:inline-flex">
                    <h3 style="margin-right:5px">Trạng thái :</h3>
                    <select style=" border: groove;background-color: beige;font-size: 14px;padding:0; width:200px;height:50px" id="select-status">
                        <option value="">...</option>
					<option value="Chưa thanh toán">Chưa thanh toán</option>
						<option value="Đã thanh toán">Đã thanh toán</option>
					</select>
				</div>
				<div>

					<button class="add-bill-button"> + Tạo lương tháng mới</button>
				</div>
			</div>



			<div>
				<table id="table-1">
					<?php $i = 1;
					if (!$listBill) {
						echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
					}
					?>
					<thead id="thead-1">
						<tr>
							<th data-column="0" style="width:20px" onclick="sortTable(0)">STT</th>
							<th data-column="1" onclick="sortTable(1)">Mã hóa đơn</th>
							<th data-column="2" onclick="sortTable(2)">Tên hóa đơn</th>
							<th data-column="3" onclick="sortTable(3)">Mã Giáo viên</th>
							<th data-column="4" onclick="sortTable(4)">Tên Giáo viên</th>
							<th data-column="5" onclick="sortTable(5)">Lớp</th>
							<th data-column="6" onclick="sortTable(6)">Thời gian </th>
							<th data-column="7" onclick="sortTable(7)">Số tiền </th>
							<th data-column="8" onclick="sortTable(8)">Thời gian thanh toán </th>
							<th data-column="9" onclick="sortTable(9)">Trạng thái </th>

						</tr>
					</thead>
					<tbody class="tbody-1">



					</tbody>
					<tbody class="tbody-5">



					</tbody>

				</table>
			</div>
			<!-- Them hoa don -->
			<div class="modal-bg-add">
				<div class="modal-content-add" style="height :fit-content">
					<div class="tab-add" style="display:inline-flex; padding-bottom:0;padding-left:0">
						<button class="tablinks-add" id='btn-tab1-add' onclick="openTab_add(event, 'Tab1-add')">Thêm hóa đơn tháng</button>
						<button class="tablinks-add" id='btn-tab2-add' onclick="openTab_add(event, 'Tab2-add')">Thênm hóa đơn cá nhân</button>
					
					</div>

					<div id="Tab1-add" class="tabcontent-add">
						<div>
							<h1>Tạo hóa đơn lương giáo viên</h1>
							<form id="form-add-bill" name="form-add-bill" method="post">

								<table>
									<tbody style="max-height:fit-content; overflow:unset">
										<td>
											<label for="bill-name-add">Tên hóa đơn : <label id="lb-name-add" style="color:red; font-size:13px ; font-style: italic "></label></label>
											<input type="text" id="bill-name-add" name="bill-name-add" placeholder="Nhập tên hóa đơn">
										</td>


										<tr>
											<td>
												<label>Thời gian : <label id="lb-time-add" style="color:red; font-size:13px ; font-style: italic "></label></label>
												<br>
												<label style="margin-left: 100px" for="bill-month-add">Tháng :</label>
												<select style="width:fit-content" name="bill-month-add" id="bill-month-add">
													<option value="">Chọn tháng</option>
													<option value="1">Tháng 1</option>
													<option value="2">Tháng 2</option>
													<option value="3">Tháng 3</option>
													<option value="4">Tháng 4</option>
													<option value="5">Tháng 5</option>
													<option value="6">Tháng 6</option>
													<option value="7">Tháng 7</option>
													<option value="8">Tháng 8</option>
													<option value="9">Tháng 9</option>
													<option value="10">Tháng 10</option>
													<option value="11">Tháng 11</option>
													<option value="12">Tháng 12</option>
												</select>

												<label style="margin-left: 100px" for="bill-month-add">Năm :</label>
												<select style="width:fit-content" name="bill-year-add" id="bill-year-add">

													<option value="">Chọn năm</option>
													<?php for ($i = 2020; $i <= 2100; $i++) { ?>
														<option value="<?php echo $i ?>">
															<?php echo $i ?>
														</option>
													<?php } ?>
												</select>


											</td>
										</tr>
										<br>
										<td>
											<label for="bill-teacher-add">Giáo viên : <label id="lb-class-add" style="color:red; font-size:13px ; font-style: italic "></label></label>

											<br>

											<select style="width: 50%;" name="bill-teacher-add" id="bill-teacher-add">

												<option value="">Chọn Giáo viên</option>



											</select>
											<button type="button" id="reset-class" style="margin-left: 20px;background-color: yellowgreen;padding: 10px;">Reset</button>
											<br>
											<div id="div-bill-class-add">

											</div>
											<input type="hidden" name="teacher-add-bill" id="teacher-add-bill">

										</td>
										<tr>
											<td>
												<button style="background-color: teal;" id="reset-1" type="reset">Làm mới</button>
											</td>
											<td>
												<input style="font-size: 14px; padding: 15px 35px; background-color: teal" type="submit" id="sumit-bill-add" value="Tạo">
											</td>
										</tr>

									</tbody>
								</table>
							</form>

						</div>
					</div>
					<div id="Tab2-add" class="tabcontent-add">
						<div>
							<h1>Tạo hóa đơn lương cá nhân</h1>
							<form id="form-add-bill-ps" name="form-add-bill-ps" method="post">

								<label for="bill-name-add-ps">Tên hóa đơn : <label id="lb-name-add-ps" style="color:red; font-size:13px ; font-style: italic "></label></label>
								<input type="text" id="bill-name-add-ps" name="bill-name-add-ps" placeholder="Nhập tên hóa đơn">

								<label for="bill-teacher-add-ps">Giáo viên : <label id="lb-class-add-ps" style="color:red; font-size:13px ; font-style: italic "></label></label>
								<br>
								<input type="text" id="name-teacher-add-bill" name="name-teacher-add-bill" oninput="filterTeachers()" placeholder="Nhập tên giáo viên">
								<ul id="teacher-list">

								</ul>
								<input type="hidden" id="name-teacher-s" name="name-teacher-s">
								<!-- <select style="width: 50%;" name="bill-teacher-add-ps" id="bill-teacher-add-ps">

									<option value="">Chọn giáo viên</option>

									<?php
									foreach ($listTeacher as $teacher) {
									?>
										<option value="<?php echo $teacher['MaGV']; ?>"> <?php echo $teacher['MaGV'] . ' - ' . $teacher['TenGV']; ?> </option>
									<?php } ?>
									

								</select> -->

								<br>
								<br>
								<label for="money-add-bill">Số tiền : <label id="lb-money-add-ps" style="color:red; font-size:13px ; font-style: italic "></label></label>

								<br>
								<input type="text" style="width: 50%;" id="money-add-bill" name="money-add-bill" pattern="[0-9,]+" oninput="formatNumber(this)" placeholder="Nhập số tiền">
								<br>


								<button style="background-color: teal;margin-top: 25px;" id="reset-2" type="reset">Làm mới</button>

								<input style="font-size: 14px; padding: 15px 35px; background-color: teal;margin-top: 25px;" type="submit" id="sumit-bill-add-ps" value="Tạo">

							</form>
						</div>


					</div>
					<div id="Tab3-add" class="tabcontent-add">
						<h1>3</h1>

					</div>
					<div id="Tab4-add" class="tabcontent-add">
						<h1>4</h1>

					</div>
					<button style="margin-left: 45%;" class="btn-close-add">Đóng</button>
				</div>

			</div>





		</div>
	
		<div class="modal-bg">
			<div class="modal-content">

				<div class="btn-tab-3">
					<button class="tablinks-3" id="btn-tab-3-1" >Thông tin hóa đơn</button>
				</div>

				<div id="tab-3-1" class="tabcontent-3">
					<h2>Thông tin hóa đơn lương giáo viên</h2>
					<button id="btn-delete-bill" style="position: absolute;top: 75px;right: 11px; background-color: #e90000">Xóa</button>

					<div class="container">


						<div class="detail">
							<table>
								<tbody style=" max-height: fit-content;">
									<tr>
										<td>
											<div style="display:inline-flex ">
												<h3 class="lb-detail-bill">Mã hóa đơn : </h3>
												<h3 id="id-bill-detail"> </h3>
											</div>
										</td>
									</tr>
									<tr>
										<th class="lb-detail-bill">Tên hóa dơn :</th>
										<td id="name-bill-detail"></td>
									</tr>

									<tr>
										<th class="lb-detail-bill">Mã giáo viên :</th>
										<td id="id-st-detail"></td>
									</tr>
									<tr>
										<th class="lb-detail-bill">Tên giáo viên :</th>
										<td id="name-st-bill-detail"></td>
									</tr>
									<tr>
										<th class="lb-detail-bill"> Lớp :</th>
										<td style="line-height: 30px;" id="class-bill-detail"></td>
									</tr>
									<tr>
										<th class="lb-detail-bill">Thời gian :</th>
										<td id="time-bill-detail"></td>
									</tr>

									<tr>
										<th class="lb-detail-bill">Số tiền :</th>
										<td id="st-bill-detail"></td>
									</tr>
									<tr>
                                        <th class="lb-detail-bill">Thời gian thanh toán :</th>
                                        <td id="time-tt-bill-detail"></td>
                                    </tr>
									<tr>
										<th class="lb-detail-bill">Trạng thái:</th>
										<!-- <td id="status-bill-detail"></td> -->
										<form action="" id='form-update-status' method="post">
											<td><select name="status-detail" id="status-detail" style="width: 50%;">
													<option style="color: green;" value="Đã thanh toán">Đã thanh toán</option>
													<option style="color: red;" value="Chưa thanh toán">Chưa thanh toán</option>

												</select>
												<input type="hidden" id="id-wage" name ="id-wage">
												<input type="submit" id="update-tt" name='update-tt' value="Cập nhật" style="margin-left:100px">
											</td>

										</form>
									</tr>

								</tbody>
							</table>




						</div>
					</div>
				</div>
				
				
				<button class="close-btn">Đóng</button>
			</div>
		</div>



		<!-- thong bao -->
		<div class="add-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3 id='tb1'></h3>
		</div>

		<!-- xóa hóa đơn -->
		<div class="delete-bill-ques">
			<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
			<h4>Bạn chắc chắn muốn xóa?</h4>
			<div style="display:flex ;justify-content: space-evenly;align-items: center">

				<button style="background-color:#52a95f; height: 44px;width: 80px" id="btn-cancle-delete-bill">Hủy bỏ</button>
				<form id="form-delete-bill" action="" method="POST">
					<input type="hidden" id="mahd-delete" name="mahd-delete">
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete-bill" name="delete=bill" value="Xóa"></input>
				</form>
			</div>
		</div>

		<div class="delete-bill-ques-2">
			<img src="../assets/images/warning-icon.png" alt="" style=" width: 40px;">
			<h4>Hóa đơn đã có dữ liệu thanh toán</h4>
			<h4>Bạn chắc chắn muốn xóa?</h4>
			<div style="display:flex ;justify-content: space-evenly;align-items: center">

				<button style="background-color:#52a95f; height: 44px;width: 80px" id="btn-cancle-delete-bill-2">Hủy bỏ</button>
				<form id="form-delete-bill-2" action="" method="POST">
					<input type="hidden" id="mahd-delete-2" name="mahd-delete-2">
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete-bill-2" name="delete=bill-2" value="Xóa"></input>
				</form>
			</div>
		</div>

		<div class="delete-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Xóa thành công!</h3>
		</div>

		<!-- <div class="delete-ques">
			<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
			<h4>Bạn chắc chắn muốn xóa?</h4>
			<div style="display:flex ;justify-content: space-evenly;align-items: center">

				<button style="background-color:#52a95f; height: 44px;width: 80px" id="btn-cancle-delete-bill">Hủy bỏ</button>
				<form id="form-delete-bill" action="" method="POST">
					<input type="hidden" id="mahd-delete" name="mahd-delete">
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete-bill" name="delete=bill" value="Xóa"></input>
				</form>
			</div>
		</div> -->
		<!--  -->

		<div class="delete-ques-trans">
			<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
			<h4>Bạn chắc chắn muốn xóa?</h4>
			<div style="display:flex ;justify-content: space-evenly;align-items: center">

				<button style="background-color:#52a95f; height: 44px;width: 80px " id="btn-cancle-delete-trans">Hủy bỏ</button>


				<button type="button" style="background-color: #d52828;  height: 44px;width: 80px;border-radius: 7px;" id="delete-trans">Xóa</button>

			</div>
		</div>
	</main>

	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>
</body>




<script>
	var dsHoaDon = <?php print_r($jslistBill); ?>;
	var dsgv_lop = <?php print_r($jslistgv_lopxlop); ?>;
	var dsgv_lopxdd = <?php print_r($jslistgv_lopxdd); ?>;
	var dsgv = <?php print_r($jslistTeacher); ?>;
	var dssoBuoiDay = <?php print_r($jslistSoBuoiDayAll); ?>;
</script>

<script src="../assets/js/manageFinance_wageTea.js"></script>

</html>