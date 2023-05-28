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
				<li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a href="#">Quản lý phụ huynh</a></li>
				<li><a href="#">Quản lý tài khoản</a></li>
			</ul>
		</nav>
	</header>

	<main>
    <div class="container">
      <h1>Quản lý lớp học</h1>
      <form>
        <label for="classcode">Mã lớp:</label>
        <input type="text" id="classcode" name="classcode" placeholder="Nhập mã lớp...">

        <label for="classname">Tên lớp:</label>
        <input type="text" id="classname" name="classname" placeholder="Nhập tên lớp...">

        <label for="classAge">Lứa tuổi:</label>
        <input type="text" id="classAge" name="classAge" placeholder="Nhập lứa tuổi...">

        <label for="classTimeOpen">Thời gian mở lớp:</label>
        <input type="date" id="classTimeOpen" name="classTimeOpen" placeholder="Nhập thời gian...">
<br>
        <label for="schedule">Lịch học:</label>
        <input type="text" id="schedule" name="schedule" placeholder="Lịch học...">

        <label for="price">Học phí:</label>
        <input type="text" id="price" name="price" placeholder="Nhập học phí...">

        <label for="numberlessons">Tổng số buổi học:</label>
        <input type="text" id="numberlessons" name="numberlessons" placeholder="Nhập số buổi học...">

        <label for="students">Số lượng sinh viên tối đa:</label>
        <input type="text" id="students" name="students" placeholder="Nhập số lượng sinh viên...">

        <label for="teacher">Giảng viên:</label>
        <input type="text" id="teacher" name="teacher" placeholder="Nhập tên giảng viên...">
        <input type="submit" value="Thêm lớp học">
      </form>
      <br>
      <input type="text" id="search" name="search" placeholder="Tìm kiếm lớp học...">
      <br><br>
      <table>
        <thead>
          <tr>
            <th>Tên lớp</th>
            <th>Giảng viên</th>
            <th>Số lượng sinh viên</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Lớp Toán</td>
            <td>Nguyễn Văn A</td>
            <td>30<span>/</span>50</td>
            <td><a href="#">Sửa</a> | <a href="#">Xóa</a></td>
          </tr>
          <tr>
            <td>Lớp Lý</td>
            <td>Trần Thị B</td>
            <td>25</td>
            <td><a href="#">Sửa</a> | <a href="#">Xóa</a></td>
          </tr>
          <tr>
            <td>Lớp Hóa</td>
            <td>Phạm Văn C</td>
            <td>20</td>
            <td><a href="#">Sửa</a> | <a href="#">Xóa</a></td>
          </tr>
    </tbody>
      </table>
    </div>
	</main>

	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>
</body>
</html>
