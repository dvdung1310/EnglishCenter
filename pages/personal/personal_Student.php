<?php
require '../../lib/functionPersonal.php';

session_start();
$ma = $_SESSION['MaHS'];

$mahs = $ma['MaHS'];

$detailStudent = selectStudent($connection, $mahs);
$accountStudent = selectAcountStudent($connection, $mahs);

$jsdetailStudent = json_encode($detailStudent);
$jsaccountStudent = json_encode($accountStudent);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['name-input'])) {
        $mahs = $_POST['id-input'];
        $ten = trim($_POST['name-input']);
        $gt = $_POST['gender-input'];
        $ns = $_POST['birthday-input'];
        $tuoi = $_POST['age-input'];
       
        $dc = trim($_POST['address-input']);

        $sdt = $_POST['phone-input'];
        $email = trim($_POST['email-input']);


        updateStudentbyID($connection,$mahs,$ten,$gt,$ns,$tuoi,$dc,$sdt,$email);
        header("Location: personal_Student.php");
    }





    if (isset($_POST['new-pass'])) {
        $username = $_POST['username'];
        $pass = $_POST['new-pass'];

       
        updatePassHS($connection, $username, $pass);
        header("Location: personal_Student.php");
    }
    if (isset($_POST['btn-logout'])) {

        session_start();
        session_unset();
        session_destroy();
        header("Location: ../home/home.php");
      }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/personal.css" />
    <link rel="stylesheet" href="../../assets/fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../../assets/css/home.css" />
    <link rel="stylesheet" href="../../plugins/bootstrap-5.2.3-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/common.css">

    <title>Thông tin cá nhân</title>
</head>

<body>
    <div class="personal-wrap">
        <div id="menu-bar"></div>

        <div class="personal-bg-wrap">
        <h2 style="margin-left:40%;  margin-top: 10px;">  Thông tin cá nhân</h2>
        </div>
        <div class="personal-inner">
            <div class="personal-avt-wrap">
                <img src="../../assets/images/Student-male-icon.png" alt="" class="personal-avt">
            </div>
            <div class="personal-inner-name"></div>
            <div class="personal-inner-info">
                <div class="edit-div">
                    <button class="edit-wrap edit-info">
                        <i class="ti-pencil-alt edit-icon"></i>
                    </button>
                </div>
                <form action="" method="POST" id='form-update'>
                    <div class=" personal-inner-item">
                        <div class="personal-inner-key">Mã giáo viên :</div>
                        <div id="id" class="personal-inner-value personal-inner-value-info">Long</div>
                    </div>
                    <div id="id-inp" class="personal-inner-edit-range personal-inner-edit-range-info"></div>
                    <input id="id-input" name="id-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="hidden"></input>

                    <div class=" personal-inner-item personal-inner-item-first">
                        <div class="personal-inner-key">Tên : <strong style="color: red; font-size: 12px;font-style: italic;" id="err-name"></strong></div>
                        <div id="name" class="personal-inner-value personal-inner-value-info">Long</div>
                    </div>

                    <input id="name-input" name="name-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="tetxt" placeholder="Nhập tên" required></input>

                    <div class="personal-inner-item">
                        <div class="personal-inner-key">Giới tính : <strong style="color: red; font-size: 12px;font-style: italic;" id="err-gender"></strong></div>
                        <div id="gender" class="personal-inner-value personal-inner-value-info">Nữ</div>
                    </div>
                    <select id="gender-input" name="gender-input" class="personal-inner-edit-range personal-inner-edit-range-info" required>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>


                    <div class="personal-inner-item">
                        <div class="personal-inner-key">Ngày sinh : <strong style="color: red; font-size: 12px;font-style: italic;" id="err-birthday"></strong></div>
                        <div id="birthday" class="personal-inner-value personal-inner-value-info">11-12-2122</div>
                    </div>
                    <input id="birthday-input" name="birthday-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="date" required></input>

                    <div class="personal-inner-item">
                        <div class="personal-inner-key">Tuổi : <strong style="color: red; font-size: 12px;font-style: italic;" id="err-age"></strong></div>
                        <div id="age" class="personal-inner-value personal-inner-value-info">12</div>
                    </div>
                    <input id="age-input" name="age-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="number" placeholder="Nhập tuổi" required></input>


              
                    <div class="personal-inner-item">
                        <div class="personal-inner-key">Địa chỉ : <strong style="color: red; font-size: 12px;font-style: italic;" id="err-address"></strong></div>
                        <div id="address" class="personal-inner-value personal-inner-value-info">Longabc@gmail.com</div>
                    </div>
                    <input id="address-input" name="address-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="tetxt" placeholder="Nhập dịa chỉ" required></input>


                  

                    <div class="personal-inner-item">
                        <div class="personal-inner-key">Email: <strong style="color: red; font-size: 12px;font-style: italic;" id="err-email"></strong></div>
                        <div id="email" class="personal-inner-value personal-inner-value-info">Longabc@gmail.com</div>
                    </div>
                    <input id="email-input" name="email-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="tetxt" placeholder="Nhập Email" required></input>

                    <div class="personal-inner-item">
                        <div class="personal-inner-key">Số điện thoại: <strong style="color: red; font-size: 12px;font-style: italic;" id="err-phone"></strong></div>
                        <div id="phone" class="personal-inner-value personal-inner-value-info">01234567</div>
                    </div>
                    <input id="phone-input" name="phone-input" class="personal-inner-edit-range personal-inner-edit-range-info" type="tetxt" placeholder="Nhập số điện thoại" required></input>
                    <div class="personal-inner-control control-info">
                        <button type="button" class="personal-btn personal-cancel info-cancel">Huỷ</button>
                        <button type="submit" class="personal-btn personal-accept info-accept" id="btn-update">Cập nhật</button>
                    </div>
                </form>
            </div>
            <div class="personal-inner-info personal-inner-password">
                <div class="edit-div">
                    <button class="edit-wrap edit-pass">
                        <i class="ti-pencil-alt edit-icon"></i>
                    </button>
                </div>

                <div class="personal-inner-item personal-inner-item-first">
                    <div class="personal-inner-key">Mật khẩu: <strong style="color: red; font-size: 12px;font-style: italic;" id="err-pass"></strong></div>
                    <input id='password' class="personal-inner-value personal-inner-value-pass" type="password" readonly></input>

                    <button style="width:25px ; margin-top:2px;  height:25px; margin-left:90%; background-image: url(https://icons.veryicon.com/png/o/miscellaneous/hekr/action-hide-password.png);background-size: cover; " onclick="togglePassword()" class="personal-inner-value personal-inner-value-pass"></button>
                </div>


                <form action="" method="post" id="form-change-pass">
                    <input id="new-pass" name="new-pass" class="personal-inner-edit-range personal-inner-edit-range-pass" type="password" placeholder="Nhập mật khẩu mới" required></input>
                    <div class="personal-inner-control control-pass">

                        <button type="button" class="personal-btn personal-cancel password-cancel">Hủy</button>

                        <input type="hidden" name="username" id="username">
                        <button class="personal-btn personal-accept password-accept" id="btn-change">Lưu</button>


                    </div>

                    <!-- <div class="personal-inner-item personal-inner-item-first">
                        <div class="personal-inner-key">Nhập lại Mật khẩu:</div>
                        <div class="personal-inner-value">********</div>
                    </div> -->
                    <!-- <input class="personal-inner-edit-range" type="password"></input> -->


                </form>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!--boostrap.js-->
    <script src="../../plugins/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <!--slick.js-->
    <!-- <script src="./personal.js"></script> -->
    <!-- <script src="../common/menubar.js"></script> -->
    <script>
          var detailStudent = <?php print_r($jsdetailStudent); ?>;
    var accountStudent = <?php print_r($jsaccountStudent); ?>;
 
    const authMenuBarHTMl = ` <div class="PageMenuBar" style ="position:absolute">
<a class="PageLogoWrap" href="../main_pages/homeStudent.php">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav"  href="../main_pages/userStudent_class.php" >Thông tin lớp học</a>
  <a class="menubar-nav  last-nav" href="../main_pages/userStudent_link.php">Liên kết với phụ huynh</a>

  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">` +  detailStudent[0].TenHS + `</div>
     
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu" id ="a123">
              <li class="menubar-dropdown-item"><a  href="../personal/personal_Student.php">Thông tin cá nhân</a></li>
      
              <li class="menubar-dropdown-item">  <form action="" method="post"> <input type="submit" name ="btn-logout"  id ="btn-logout" value ="Đăng xuất" style="border: none;background-color: unset;"></form></li>          </ul>
          </ul>
        </div>
    </div>
  </div>
</div>

</div>`
  //isAuthentication === true
  document.querySelector("#menu-bar").innerHTML = authMenuBarHTMl
  var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)



$(".menubar-drop-btn").onclick = ()=>{
   
    $(".menubar-dropdown-menu").classList.toggle("menubar-show")
 
}
    </script>
</body>

<script>
  


    document.getElementById('id').innerHTML = detailStudent[0].MaHS;
    document.getElementById('id-inp').innerHTML = detailStudent[0].MaHS;

    document.getElementById('name').innerHTML = detailStudent[0].TenHS;
    document.getElementById('name-input').value = detailStudent[0].TenHS;

    document.getElementById('gender').innerHTML = detailStudent[0].GioiTinh;
    var img = document.querySelector(".personal-avt");
    var img2 = document.querySelector(".menubar-avt");
    if (detailStudent[0].GioiTinh == "Nam") {
        img.src = "../../assets/images/Student-male-icon.png";
        img2.src =  "../../assets/images/Student-male-icon.png";
    } else {
        img.src = "../../assets/images/Student-female-icon.png";
        img2.src =  "../../assets/images/Student-female-icon.png";
    }

    var selectTag = document.getElementById("gender-input");
    for (var i = 0; i < selectTag.options.length; i++) {
        if (selectTag.options[i].value == detailStudent[0].GioiTinh) {
            selectTag.options[i].selected = true;
            break;
        }
    }

    document.getElementById('birthday').innerHTML = formatDate(detailStudent[0].NgaySinh);
    document.getElementById('birthday-input').value = detailStudent[0].NgaySinh;

    document.getElementById('age').innerHTML = detailStudent[0].Tuoi;
    document.getElementById('age-input').value = detailStudent[0].Tuoi;



    document.getElementById('address').innerHTML = detailStudent[0].DiaChi;
    document.getElementById('address-input').value = detailStudent[0].DiaChi;



    document.getElementById('email').innerHTML = detailStudent[0].Email;
    document.getElementById('email-input').value = detailStudent[0].Email;

    document.getElementById('phone').innerHTML = detailStudent[0].SDT;
    document.getElementById('phone-input').value = detailStudent[0].SDT;

    document.getElementById('password').value = accountStudent[0].Password;

    function togglePassword() {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    function formatDate(dateString) {
        var dateParts = dateString.split('-'); // Tách ngày, tháng, năm thành mảng
        var year = dateParts[0];
        var month = dateParts[1];
        var day = dateParts[2];

        var formattedDate = day + '-' + month + '-' + year;
        return formattedDate;
    }

    // Khi nhấn nút Cập nhật
    const submit_update = document.getElementById('btn-update');
    submit_update.addEventListener('click', function(event) {

        var check = true;

        const form1 = document.getElementById('form-update')

        event.preventDefault();

        const phone = document.getElementById('phone-input').value;
        const email = document.getElementById('email-input').value;

        const name = document.getElementById('name-input').value;
        const gender = document.getElementById('gender-input').value;
        const birthday = document.getElementById('birthday-input').value;
        const age = document.getElementById('age-input').value;
        
        const address = document.getElementById('address-input').value;




        var erorr_empty = "*Dữ liệu không để trống";

        //Kiểm tra dữ liệu nhập vào
        if (!name) {
            document.getElementById('err-name').textContent = erorr_empty;
            check = false;
        } else
            document.getElementById('err-name').textContent = "";

        if (!gender) {
            document.getElementById('err-gender').textContent = erorr_empty;
            check = false;
        } else
            document.getElementById('err-gender').textContent = "";

        if (!birthday) {
            document.getElementById('err-birthday').textContent = erorr_empty;
            check = false;
        } else
            document.getElementById('err-birthday').textContent = "";

        if (!age) {

            document.getElementById('err-age').textContent = erorr_empty;
            check = false;
        } else
            document.getElementById('err-age').textContent = "";

      
        if (!address) {

            document.getElementById('err-address').textContent = erorr_empty;
            check = false;
        } else
            document.getElementById('err-address').textContent = "";
     


        if (!(/^(0[0-9]{9})$/.test(phone))) {
            document.getElementById('err-phone').textContent = "*Số điện thoại không chính xác (0..; 10 chữ số)";
            check = false;
        } else
            document.getElementById('err-phone').textContent = "";

        if (!(/\S+@\S+\.\S+/.test(email))) {
            document.getElementById('err-email').textContent = "*Email không chính xác (example@xxx.com)";
            check = false;
        } else
            document.getElementById('err-email').textContent = "";

        if (!check)
            return;


        document.getElementById('id-input').value = detailStudent[0].MaHS;
        form1.submit();

        // Gửi form đi nếu tất cả dữ liệu hợp lệ

    });


    document.getElementById('btn-change').addEventListener('click', function(event) {

        var check = true;

        const form1 = document.getElementById('form-change-pass')

        event.preventDefault();

        const pass = document.getElementById('new-pass').value;



        //Kiểm tra dữ liệu nhập vào

        if (!pass) {

            document.getElementById('err-pass').textContent = "Chưa nhập mật khẩu mới";
            check = false;
        } else
            document.getElementById('err-pass').textContent = "";

        if (!check)
            return;

        document.getElementById('username').value = accountStudent[0].UserName;
        form1.submit();

        // Gửi form đi nếu tất cả dữ liệu hợp lệ

    });




    // initial setup
    var $ = document.querySelector.bind(document)
    var $$ = document.querySelectorAll.bind(document)



    var isEdit = false
    const editBtn = $(".edit-info")

    $$(".personal-inner-value").forEach(item => {
        item.classList.add("personal-act-inline")
    })
    const inputdata = {
        name: "",
        email: "",
        phone: "",
    }
    //func chuyển dạng
    const onChangeEditType = (type, opt) => {
        isEdit = type

        if (isEdit) {
            $$(`.personal-inner-value-${opt}`).forEach((item) => {
                item.classList.remove("personal-act-inline")
            })
            $(`.control-${opt}`).classList.add("personal-act-flex")
            $$(`.personal-inner-edit-range-${opt}`).forEach((item) => {
                item.classList.add("personal-active")
            })
            // khởi tạo giá trị của input khi chuyển sang dạng edit
            if (opt === "info") {
                console.log("active")

            }
        } else {
            $$(`.personal-inner-edit-range-${opt}`).forEach((item) => {
                item.classList.remove("personal-active")
            })
            $$(`.personal-inner-value-${opt}`).forEach((item) => {
                item.classList.add("personal-act-inline")
            })
            $(`.control-${opt}`).classList.remove("personal-act-flex")
        }
    }



    editBtn.onclick = () => {
        onChangeEditType(!isEdit, "info")
    }

    $(".edit-pass").onclick = () => {
        onChangeEditType(!isEdit, "pass")
    }

    $(".info-cancel").onclick = () => {
        onChangeEditType(false, "info");
      
            document.getElementById('err-name').textContent = "";    
            document.getElementById('err-gender').textContent = "";
            document.getElementById('err-birthday').textContent = "";
            document.getElementById('err-age').textContent = "";
            document.getElementById('err-address').textContent = "";
            document.getElementById('err-phone').textContent = "";
            document.getElementById('err-email').textContent = "";
    }
    $(".password-cancel").onclick = () => {
        onChangeEditType(false, "pass");
        document.getElementById('err-pass').textContent = "";
    }
</script>

</html>