<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Xử lý Form PHP</title>
 <style>
 #table_form{
 border-collapse: collapse;
 border: 1px red solid;
 background-color: aqua;
 }
 #container{
 display: flex;
 }
 #div1{
 width: 20%;
 }
 #div2{
 width: 60%;
 }
 #div3{
 width: 20%;
 }
 .col1{
 color: red;
 background-color: antiquewhite;
 }
 .error{
 display: none;
 }
 span{
 color: red;
 }
 #show_error{
 color: red;
 }
 input.invalid{
 border-color: red;
 }
 </style>
</head>
<body>
<!--Dreamware2020 để tạo form đăng ký và kiểm tra input bằng php-->
 <?php
 //Khai báo biế
 $username = $userID = $password = $repass =$email = $gender = $interest = $address = 
$bird="";
 $flag = false;
 $errors = $err_day="";
 $day = $month = $year = "";
 
 $err_username = $err_userID = $err_password = $err_repass =$err_email = $err_gender = 
$err_interest = $err_address = $err_bird='';
 if($_SERVER['REQUEST_METHOD']="POST"){
 //Kiểm tra họ và tên
 if(empty($_POST["username"])){
 $err_username = "Không được để họ tên là trống";
 
 }
 else{
 $username = check_data($_POST["username"]);
 }
 //Kiểm tra Tên đăng nhập
 if(empty($_POST["userID"])){
 $err_userID = "Không được để Tên đăng nhập là trống";
 
 }
 else{
 $userID = check_data($_POST["userID"]);
 }
 //Biểu thức chính quy kiểm tra tên đăng nhập
 if(!preg_match("/^[a-zA-Z0-9]+$/",$userID)){
 $err_userID = "Tên đăng nhập phải theo đúng chuẩn chỉ có chữ và số";
 }
 //Kiểm tra Mật khẩu
 if(empty($_POST["password"])){
 $err_password = "Không được để mật khẩu là trống";
 
 }
 else{
 $password = check_data($_POST["password"]);
 }
 //Biểu thức chính quy kiểm tra nhập mật khẩu
 if(!preg_match("/^[a-zA-Z0-9]{8,30}$/",$password)){
 $err_userID = "TMật khẩu phải đủ ít nhất 8 ký tự và theo chuẩn";
 }
 //Kiểm tra nhập lại mật khẩu Mật khẩu
 if(empty($_POST["repass"])){
 $err_repass = "Không được để nhập lại password là trống";
 
 }
 else{
 $repass = check_data($_POST["repass"]);
 }
//Biểu thức chính quy kiểm tra mật khẩu và nhập lại mật khẩu
if(!preg_match("/^[a-zA-Z0-9]{8,30}$/",$repass)){
    $err_repass = "Nhập lại pass phải đủ ít nhất 8 ký tự và theo chuẩn";
    }
    if($password!=$repass)
    {
    $errors = "Mật khẩu và nhập lại mật khẩu không khớp";
    }
    //Kiểm tra Email
    if(empty($_POST["email"])){
    $err_email = "Email không được để trống";
    
    }
    else{
    $email = check_data($_POST["email"]);
    }
    //Biểu thức chính quy kiểm tra email
    if(!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-z]+$/",$email)){
    $err_userID = "Phải nhập đúng định dạng email có @ và dấu chấm";
    }
    //Kiểm tra năm sinh phải đúng chuẩn
    //tháng 1,3,5,7,8,10,12: có 31 ngày
    //Thangs 4,6,9,11: Có 30 ngày
    //Thang2: năm chia hết cho 4, năm chia hết cho 100 thì phải chia hết cho 400 sẽ có 29 ngày 
    //còn không thì 28 ngày
    $day = $_POST["day"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    switch ($month){
    case 1:
    case 3:
    case 5:
    case 7:
    case 8:
    case 10:
    case 12:
    break;
    case 4: 
    case 6: 
    case 9: 
    case 11: 
    if($day>30){
    $err_bird = "Lỗi ngày không khớp với tháng.";
    break;
    }
    case 2:
    if($year%4==0){
    if($year%100==0){
    if($year%400==0){
        if($day>29){
            $err_bird = "Lỗi ngày không khớp với tháng.";
            }
            
            }
            else{
            if($day>28){
            $err_bird = "Lỗi ngày không khớp với tháng.";
            } 
            }
            }
            else{
            if($day>29){
            $err_bird = "Lỗi ngày không khớp với tháng.";
            }
            }
            }
            else{
            if($day>28){
            $err_bird = "Lỗi ngày không khớp với tháng.";
            } 
            }
            
            
            }
            }
            $address = check_data($address);
            
            function check_data($data){
            $data = trim($data); //Cắt khoảng trắng 2 đầu
            $data = stripslashes($data); //Cắt bỏ ký tự \
            $data = htmlspecialchars($data); //Bỏ tác dụng của thẻ HTML, tương tự hàm htmlentities()
            return $data;
            }
            ?>
            <div id="container">
            <div id="div1"></div>
            <div id="div2">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" name="Register" 
           method="post" >
            <table cellpadding="5" cellspacing="0" id="table_form" align="center">
            <tr>
            <td width="30%" class="col1"><label for="username">Họ và tên người 
           dùng:</label></td>
            <td><input type="text" size="40" id="username" name="username" value="<?php echo 
           $username ?>"></input><span id="eruser" class="error">*</span></td>
            </tr>
            <tr>
            <td width="30%" class="col1"><label for="userID">Tên Đăng nhập:</label></td>
            <td><input type="text" size="40" id="userID" name="userID" value="<?php echo 
$userID ?>"></input><span id="eruserID" class="error">*</span></td>
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="password">Mật khẩu:</label></td>
 <td><input type="password" size="40" id="password" name="password" value="<?php 
echo $password ?>"></input><span id="erPass" class="error">*</span></td>
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="repass">Nhập lại mật khẩu:</label></td>
 <td><input type="password" size="40" id="repass" name="repass" value="<?php echo 
$repass ?>"></input><span id="erRePass" class="error">*</span></td>
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="email">Email:</label></td>
 <td><input type="text" size="40" id="email" name="email" value="<?php echo $email 
?>"></input><span id="erEmail" class="error">*</span></td>
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="rgender">Giới tính:</label></td>
 <td><input type="radio" id="male" name="rgender" value="Nam" 
checked="checked"><label for="male">Nam</label></input><input type="radio" id="female" 
name="rgender" value="Nữ"><label for="female">Nữ</label></input></td>
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="rgender">Sở thích:</label></td>
 <td>
 <input type="checkbox" id="game" name="sothich" value="game"><label 
for="game">Chơi game</label>
 <input type="checkbox" id="shopping" name="sothich" value="Mua sắm"><label 
for="shopping">Mua sắm</label>
 <input type="checkbox" id="travel" name="sothich" value="Du lịch"><label 
for="travel">Du lịch</label>
 <input type="checkbox" id="other" name="sothich" value="khác" checked><label 
for="other">Khác</label>
 </td> 
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="">Năm sinh:</label></td>
 <td>
 <label for="day">Ngày</label>
 <select id="day" name="day">
 <script>
 for(var i = 1; i<=31;i++){
 document.write("<option value=\""+i+"\">"+i+"<//option>");
 }
 </script>
 </select>
 <label for="month"> Tháng</label>
 <select id="month" name="month">
 <script>
 for(var j = 1; j<=12;j++){
 document.write("<option value=\""+j+"\">"+j+"<//option>");
 }
 </script>
 </select>
 <label for="year"> Năm</label>
 <select id="year" name="year">
 <script>
 var d = new Date();
 var _year = d.getFullYear();
 for(var k = 1900; k<=_year;k++){
 document.write("<option value=\""+k+"\">"+k+"<//option>");
 }
 </script>
 </select>
 </td>
 </tr>
 <tr>
 <td width="30%" class="col1"><label for="address">Địa chỉ:</label></td>
 <td><textarea id="address" name="address"></textarea></td>
 </tr>
 <tr>
 <td colspan="2" align="center"><input type="submit" name="submit" 
value="Submit"><input type="reset" name="reset" value="Reset"></td>
 </tr>
 </table>
 </form>
 <p id="show_error"></p>
 </div>
 <div id="div3"></div>
 </div>
 
<?php
 //Hiển thị ra các lỗi trong form
 if(!empty($err_username)){
 $flag = TRUE;
 echo $err_username."<br>";
 }
 
 if(!empty($err_userID)){
 $flag = true;
 echo $err_userID."<br>";
 }
 
 if(!empty($err_password))
 {
    $flag = true;
    echo $err_password."<br>";
    }
    
    if(!empty($err_repass)){
    $flag = true;
    echo $err_repass."<br>"; 
    }
    
    if(!empty($errors)){
    $flag = true;
    echo $errors."<br>"; 
    }
    
    if(!empty($err_email)){
    $flag = true;
    echo $err_email."<br>";
    }
    if(!empty($err_bird)){
    $flag = true;
    echo $err_bird."<br>";
    }
    if(!$flag){
    echo "họ và tên: ".$username."<br>";
    echo "Tên đăng nhập: ".$userID."<br>";
    echo "Email: ".$email."<br>";
    }
   ?>
   </body>
   </html>           