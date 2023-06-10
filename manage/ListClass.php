<?php
include "../lib/FunctionClass.php";

$listClass = listClass($connection);
$result = listSchedules($connection);
$listTeacher = listTeacher($connection);
$dataClassOnOff = dataClassOnOff('Đang mở', $connection);
// lịch của giáo viên
$timeTeacher = timeTeacher($connection);
// $arrTime = array();
// $i = 0 ;
// foreach ($listClass as $dataCodeClass) {
// 	$arrTime[$i] = $dataCodeClass;
// 	$i++;
// };
$listtimeTeacher = json_encode($timeTeacher);

$arr = array();
$dem = 0;
foreach ($listClass as $dataCodeClass) {
	$arr[$dem] = $dataCodeClass['MaLop'];
	$dem++;
};
$listClassJson = json_encode($arr);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['classcode'])) {
		$classcode = trim($_POST['classcode']);
		$classname = trim($_POST['classname']);
		$classAge = $_POST['classAge'];
		$classTimeOpen = $_POST['classTimeOpen'];
		$schedules0 = $_POST['schedules0'];
		$condition = $_POST['SelectCondition'];
		if (isset($_POST['schedules1'])) {
			$schedules1 = $_POST['schedules1'];
		} else {
			$schedules1 = "schedules1";
		}

		if (isset($_POST['schedules2'])) {
			$schedules2 = $_POST['schedules2'];
		} else {
			$schedules2 = "schedules2";
		}

		$price = trim($_POST['price']);
		$numberlessons = trim($_POST['numberlessons']);
		$students = trim($_POST['students']);

		$teachers = $_POST['teachers'];
		$maLop = CreateClass($classcode, $classname, $classAge, $classTimeOpen, 0, $students, $price, $numberlessons, 0, $condition, $connection);
		if ($maLop != null) {
			$schedulesClass0 = CreateSchedules_Class($schedules0, $maLop, $connection);
			if ($schedules1 != "schedules1") {
				$schedulesClass1 = CreateSchedules_Class($schedules1, $maLop, $connection);
			}
			if ($schedules2 != "schedules2") {
				$schedulesClass2 = CreateSchedules_Class($schedules2, $maLop, $connection);
			}
			$tientraGV = $_POST['TeacherSalarie'];
			$teacherClass = CreateTeacher_Class($teachers, $maLop, $tientraGV, $connection);
			if($teacherClass && isset($_POST['startDiscount']) && isset($_POST['endDiscount']) && isset($_POST['discountpercent'])){
				insertDiscount($_POST['startDiscount'],$_POST['endDiscount'],$_POST['discountpercent'],$maLop,$connection);
			}else{
				insertDiscount('2023-1-1','2023-1-1',0,$maLop,$connection);
			}
			header("Location: ListClass.php");
			exit();
		}
	}
}


?>

<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/manageClass.css">
	<script src="https://code.jquery.com/jquery-3.6.4.js"></script>
	<script src="../assets/js/ajaxListClass.js"></script>
	<style>
		button {
			border: none;
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
				<li><a style="color: #0088cc;" href="../manage/ListClass.php">Quản lý lớp học</a></li>
				<li><a href="../manage/manageStudent.php">Quản lý học viên</a></li>
				<li><a href="manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a href="manageParent.php">Quản lý phụ huynh</a></li>
				<li><a href="#">Quản lý tài khoản</a></li>
			</ul>
		</nav>
	</header>
	<main>
		<div class="">
			<button id="open-btn">Thêm lớp</button>
		</div>
		<div>

			<div class="searchClass" id="searchClass">
				<div>
					<input type="text" class="timkiem" placeholder="Tìm kiếm...">
				</div>
			</div>

			<div>
				<select name="province" id="province">
					<option value="1">Lớp đang mở</option>
					<option value="0">Lớp chưa mở </option>
					<option value="2">Lớp đã đóng</option>
				</select>
			</div>
			<h1 style="color: #0088cc;">Danh sách lớp học</h1>
			<!-- lớp on -->
			<div class="class-container" id="district">
				<?php
				if ($dataClassOnOff != null) :
					foreach ($dataClassOnOff as $datas) :
						$maLop = $datas['MaLop'];
						$nameTeacher = dataTeacherByMaLop($maLop, $connection);
						$schedules = dataSchedulesByMaLop($maLop, $connection); ?>
						<a class='class' href='DetailsClass.php?maLop=<?php echo $maLop ?>'>
							<div>
								<div class='class-code1'>
									<?php echo $datas['MaLop'] ?>
								</div>
								<div class='info'>
									<h2>
										<?php echo  $datas['TenLop'] ?>
									</h2>
									<p>Giảng viên:
										<?php foreach ($nameTeacher as $nameTeachers) {
											echo	 $nameTeachers['TenGV'];
										} ?>
									</p>
									<div class='column'>
										<p>Thời gian:
										</p>
										<div class='center'>
											<?php
											foreach ($schedules as $listschedules) {

												echo $listschedules['day_of_week'] . ' - ' . $listschedules['start_time'] . '-' . $listschedules['end_time'];
												echo "<br>";
											}
											?>
										</div>
									</div>

									<p>Lứa tuổi:
										<?php echo  $datas['LuaTuoi'] ?>
									</p>
									<p>Số lượng học sinh:
										<?php echo $datas['SLHS'] . ' / ' . $datas['SLHSToiDa'] ?>
									</p>
								</div>
							</div>
							<div class='details'>Xem chi tiết</div>
						</a>
					<?php endforeach ?>
				<?php endif ?>
			</div>

			<div id="overlay">
				<div id="box">
					<button id="close-btn">&times;</button>
					<div class="">
						<h1 style="color: #0088cc;">Thêm lớp học</h1>
						<form id="form_add" name="form_add" method="post">
							<label for="classcode">Mã lớp:<label class="lbStyle" id="lbclasscode" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="classcode" name="classcode" placeholder="Nhập mã lớp...">

							<label for="classname">Tên lớp:<label class="lbStyle" id="lbclassname" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="classname" name="classname" placeholder="Nhập tên lớp...">

							<label for="classAge">Lứa tuổi:<label class="lbStyle" id="lbclassAge" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="classAge" name="classAge" placeholder="Nhập lứa tuổi...">

							<label for="classTimeOpen">Thời gian tạo lớp:</label>
							<input type="date" id="classTimeOpen" name="classTimeOpen" placeholder="Nhập thời gian..."><label id="lbclassTimeOpen" style="color:red; font-size:13px ; font-style: italic "></label>
							<br>

							<label for="schedules">Lịch học:<label class="lbStyle" id="lbschedules" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<br><select name="schedules0" id="schedules0">
								<option value="">Thời gian</option>
								<?php foreach ($result as $results) : ?>
									<option style="height: 30px;" <?php if (isset($_POST['schedules0']) && $_POST['schedules0'] == $results['idSchedules']) echo 'selected' ?> value="<?php echo $results['idSchedules']  ?>">

										<?php echo $results['day_of_week'] . ' - ' . $results['start_time'] . '-' . $results['end_time']   ?>
									</option>
								<?php endforeach; ?>
							</select>

							<button style="background-color: chartreuse; border: 1px solid #fff; border-radius:5px ; padding: 5px 4px;" type="button" onclick="addCard()">Thêm lịch học</button>
							<div id="addSchedules"></div>


							<br>
							<label for="price">Học phí:<label class="lbStyle" id="lbprice" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="price" name="price" placeholder="Nhập học phí...">

							<label for="numberlessons">Tổng số buổi học:<label class="lbStyle" id="lbnumberlessons" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="numberlessons" name="numberlessons" placeholder="Nhập số buổi học...">

							<label for="students">Số lượng sinh viên tối đa:<label class="lbStyle" id="lbstudents" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="students" name="students" placeholder="Nhập số lượng sinh viên...">

							<label for="teacher">Giáo viên:<label class="lbStyle" id="lbteacher" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<br>
							<select name="teachers" id="teachers">
								<option value="">Tên giáo viên</option>
								<?php foreach ($listTeacher as $listTeachers) : ?>
									<option value="<?php echo $listTeachers['MaGV'] ?>">
										<?php echo $listTeachers['TenGV'] . ' - ' . $listTeachers['TrinhDo'] ?>
									</option>
								<?php endforeach; ?>
							</select>
							<br><label for="TeacherSalarie">Lương giáo viên:<label class="lbStyle" id="lbTeacherSalarie" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<input type="text" id="TeacherSalarie" name="TeacherSalarie" placeholder="Nhập lương giáo viên">

							<label for="condition">Trạng thái:<label class="lbStyle" id="lbcondition" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<br><select name="SelectCondition" id="SelectCondition">
								<option value="">Trạng thái</option>
								<option value="Chưa mở">Chưa mở</option>
								<option value="Đang mở">Đang mở</option>
								<option value="Đã đóng">Đã đóng</option>
							</select>
							<br>

							<button style="background-color: chartreuse; border: 1px solid #fff; border-radius:5px ; padding: 5px 4px;" type="button" onclick="addDiscount()">Thêm khuyến mại</button>
							<div id="addDiscount">
							</div>


							<input type="submit" id='add' name="add" value="Thêm">
						</form>

						<div id="card-container"></div>
					</div>
				</div>
			</div>
	</main>
	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>

	<div class="add-success">
		<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
		<h3>Thêm lớp thành công!</h3>
	</div>
</body>


<script>
	var listtimeTeacher = <?php echo $listtimeTeacher ?>;
	// hiển thị box chính
	const openBtn = document.getElementById('open-btn');
	const overlay = document.getElementById('overlay');
	const box = document.getElementById('box');
	const closeBtn = document.getElementById('close-btn');

	openBtn.addEventListener('click', () => {
		overlay.classList.add('active');
		box.classList.add('active');
	});

	closeBtn.addEventListener('click', () => {
		overlay.classList.remove('active');
		box.classList.remove('active');
	});

	// add class
	var counter = 1; // Biến đếm ban đầu
	<?php $counter = 1 ?>

	function addCard() {
		var container = document.getElementById("addSchedules");
		var card = document.createElement("div");
		card.className = "card";
		card.innerHTML = `
  <select style='' name="schedules${counter}" id="schedules${counter}">
          <option value="">Thời gian</option>
          <?php foreach ($result as $results) : ?>
            <?php $counter = 1 ?>
            <option <?php if (isset($_POST['schedules']) && $_POST['schedules'] == $results['idSchedules']) echo 'selected' ?>
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

	
	function addDiscount() {
		var container = document.getElementById("addDiscount");
		var card = document.createElement("div");
		card.className = "card";
		card.innerHTML = `
		<label for="">Khuyến mại :<label class="lbStyle" id="lbdiscount" style="color:red; font-size:13px ; font-style: italic "></label></label>
							<br>
							
							Thời gian bát đầu : <input type="date" name="startDiscount" id="startDiscount" ><br>
							Thời gian kết thúc: <input type="date" name="endDiscount" id="endDiscount">
							<input type="text" name="discountpercent" id="discountpercent" placeholder="Nhập % khuyến mại">
							<button class="delete-button" onclick="deleteDiscount(this)">Xóa</button>
  `;
		container.appendChild(card);
	}

	function deleteDiscount(button) {
		var index = button.getAttribute("data-index");
		var card = button.parentNode;
		var container = card.parentNode;
		container.removeChild(card);

	}
	// Khi nhấn Thêm
	const submit_add = document.getElementById('add');
	submit_add.addEventListener('click', function(event) {

		const form2 = document.getElementById('form_add')
		// Ngăn chặn việc submit form mặc định để xử lý dữ liệu trước khi gửi form đi
		event.preventDefault();
		const classcode = document.getElementById('classcode').value;

		// Kiểm tra mã lớp có tồn tại hay không
		const listClass = <?php echo $listClassJson; ?>;
		let found = false;
		for (let i = 0; i < listClass.length; i++) {
			if (classcode === listClass[i]) {
				found = true;
				break;
			}
		}

		const classname = document.getElementById('classname').value;
		const classAge = document.getElementById('classAge').value;
		const classTimeOpen = document.getElementById('classTimeOpen').value;
		const price = document.getElementById('price').value;
		const numberlessons = document.getElementById('numberlessons').value;
		const students = document.getElementById('students').value;
		const teachers = document.getElementById('teachers').value;
		const teacherSalarie = document.getElementById('TeacherSalarie').value

		// trạng thái
		const condition = document.getElementById('SelectCondition').value;


		// lịch
		const element0 = document.getElementById('schedules0');
		const idSchedules0 = element0 ? element0.value : "";
		var element1 = document.getElementById('schedules1');
		if (element1 === null) {
			element1 = 1;
		}
		const idSchedules1 = element1 ? element1.value : "";
		const element2 = document.getElementById('schedules2');
		const idSchedules2 = element2 ? element2.value : "";

		// dữ liệu giảm học phí
		const element_startDiscount = document.getElementById('startDiscount');
		const startDiscount = element_startDiscount ? element_startDiscount.value : "";

		const element_endDiscount = document.getElementById('endDiscount');
		const endDiscount = element_endDiscount ? element_endDiscount.value : "";

		const element_discountpercent = document.getElementById('discountpercent');
		const discountpercent = element_discountpercent ? element_discountpercent.value : "";


		var erorr_empty = "*Dữ liệu không để trống";

		const teacherScheduleArray = [{
				idSchedules: idSchedules0,
				MAGV: teachers
			},
			{
				idSchedules: idSchedules1,
				MAGV: teachers
			},
			{
				idSchedules: idSchedules2,
				MAGV: teachers
			}
		];

		function hasDuplicateElements(arr1, arr2) {
			for (let i = 0; i < arr1.length; i++) {
				for (let j = 0; j < arr2.length; j++) {
					if (arr1[i].MAGV === arr2[j].MAGV && arr1[i].idSchedules === arr2[j].idSchedules) {
						return true;
					}
				}
			}
			return false;
		}

		const hasDuplicates = hasDuplicateElements(teacherScheduleArray, listtimeTeacher);
		//Kiểm tra dữ liệu nhập vào
		if (!classcode) {
			document.getElementById('lbclasscode').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbclasscode').textContent = "";

		if (found) {
			document.getElementById('lbclasscode').textContent = '*Mã lớp đã tồn tại';
			return;
		} else
			document.getElementById('lbclasscode').textContent = "";

		if (!classname) {
			document.getElementById('lbclassname').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbclassname').textContent = "";

		if (!classAge) {
			document.getElementById('lbclassAge').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbclassAge').textContent = "";

		if (!classTimeOpen) {
			document.getElementById('lbclassTimeOpen').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbclassTimeOpen').textContent = "";

		if (idSchedules0 === idSchedules1 || idSchedules0 === idSchedules2 || idSchedules2 === idSchedules1) {
			document.getElementById('lbschedules').textContent = '*Lịch học trùng nhau';
			return;
		} else {
			document.getElementById('lbschedules').textContent = "";
		}

		if (!price) {
			document.getElementById('lbprice').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbprice').textContent = "";

		if (!numberlessons) {
			document.getElementById('lbnumberlessons').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbnumberlessons').textContent = "";
		if (!students) {

			document.getElementById('lbstudents').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbstudents').textContent = "";

		if (!teachers) {
			document.getElementById('lbteacher').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbteacher').textContent = "";

		if (!teacherSalarie) {
			document.getElementById('lbTeacherSalarie').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbTeacherSalarie').textContent = "";
		if (!condition) {
			document.getElementById('lbcondition').textContent = erorr_empty;
			return;
		} else
			document.getElementById('lbcondition').textContent = "";

		// lịch học giáo viên 
		if (hasDuplicates) {
			document.getElementById('lbschedules').textContent = '*Lịch học của giáo viên đã tồn tại ';
			return;
		} else {
			document.getElementById('lbschedules').textContent = "";
		}
        
		if(startDiscount){
		if(!startDiscount || !endDiscount || !discountpercent){ 
            document.getElementById('lbdiscount').textContent = '*Bạn đang thiếu dữ liệu';
			return;
		}else if(startDiscount == endDiscount){
			document.getElementById('lbdiscount').textContent = '*Lịch trùng nhau';
			return;
		}
		else{
			document.getElementById('lbdiscount').textContent = "";
		}
	}

		


		document.querySelector('.add-success').style.display = 'block';

		setTimeout(function() {
			document.querySelector('.add-success').style.display = 'none';
			form2.submit();
		}, 1000);

		// Gửi form đi nếu tất cả dữ liệu hợp lệ
		// form2.submit();
	});

	// 	$(document).ready(function () {
	//     $('.timkiem').keyup(function(){
	//         var txt = $('.timkiem').val();
	//         $.post('ajax_get_listClass.php',{data:txt},function(data){
	//              $('.class-container').html(data);
	//         })
	//     })
	// })
</script>




</html>