
<?php
include "./lib/function.php";
$name = $gender = $date = $address = $age = $phone = $email = ""; 
$error_name = $error_gender = $error_date = $error_address = $error_age = $error_phone = $error_email = ""; 
if(isset($_POST['submit'])){
    if(empty($_POST['name'])){
        $error_name = "chưa đăng nhập tên ";
    }else{
       $name = $_POST['name'] ; 
    }

    if(empty($_POST['gender'])){
        $error_gender = "chưa ấn giới tính ";
    }else{
       $gender = $_POST['gender'] ; 
    }

    if(empty($_POST['date'])){
        $error_date = "chưa điền đủ thông tin ngày sinh ";
    }else{
       $date = $_POST['date'] ; 
    }

    if(empty($_POST['address'])){
        $error_address = "chưa đăng nhập địa chỉ ";
    }else{
       $address = $_POST['address'] ; 
    }

    if(empty($_POST['age'])){
        $error_age = "chưa đăng nhập tuổi";
    }else{
       $age = $_POST['age'] ; 
    }

    if(empty($_POST['phone'])){
        $error_phone = "chưa đăng nhập số điện thoại ";
    }else{
       $phone = $_POST['phone'] ; 
    }

    if(empty($_POST['email'])){
        $error_email = "chưa đăng nhập email ";
    }else{
       $email = $_POST['email']; 
    }

    if(empty($_POST['mahs'])){
      $mahs = null ;
    }else{
       $mahs = $_POST['mahs'] ; 
    }
}
$test = false;
if(isset($_POST['submit'])){
    $test = empty($error_name) && empty($error_gender) && empty($error_address) && empty($error_age) && empty($error_date) && empty($error_email) && empty($error_phone);
}
if($test){
    $result = registerTableParents($name,$gender,$date,$age,$address,$phone,$email,$connection);
    if($result != null){
        header("Location: RegisterAcountParents.php?id=$result&&mahs=$mahs");
        exit();
    }else{
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo-login</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <div class="login-star">
        <img src="./assets/images/login_stars.png" alt="">
    </div>
    <div id="contain">
        <div class="login-student">
            <div class="login-student-img">
                <img src="./assets/images/Apollo-Logo.png" alt="">
            </div>

            <div style="padding: 0 100px;" class="login-student-form">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div style="display: flex;justify-content: start;">
                        <h1>Thông tin phụ huynh</h1>
                    </div>
                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="text" name="name" placeholder="Tên học phụ huynh :">
                    </div>
                    <p style="color:red">
                            <?php
                            echo $error_name;
                            ?>
                    </p>

                    <div style="display: flex;" class="login-student-form-center">
                        <div>
                            <h1>Gíơi tính</h1>
                        </div>
                       <select name="gender">
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                        <option value="lgbt">LGBT</option>
                       </select>
                    </div>
                    <p style="color:red">
                            <?php
                            echo $error_gender;
                            ?>
                    </p>

                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="date" name="date" placeholder="Ngày sinh :">
                    </div>

                    <p style="color:red">
                            <?php
                            echo $error_date;
                            ?>
                    </p>

                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="text" name="age" placeholder="Tuổi:">
                    </div>

                    <p style="color:red">
                            <?php
                            echo $error_age;
                            ?>
                    </p>

                    <div>
                        <input name="address" class="login-student-form-input" type="text" placeholder="Địa Chỉ : ">
                    </div>
                    <p style="color:red">
                            <?php
                            echo $error_address;
                            ?>
                    </p>

                    <div>
                        <input name="phone" class="login-student-form-input" type="text" placeholder="Số điện thoại : ">
                    </div>
                    <p style="color:red">
                            <?php
                            echo $error_phone;
                            ?>
                    </p>

                    <div>
                        <input name="email" class="login-student-form-input" type="text" placeholder="Email : ">
                    </div>
                    
                    <p style="color:red">
                            <?php
                            echo $error_email;
                            ?>
                    </p>
                    <div>
                        <input name="mahs" class="login-student-form-input" type="text" placeholder="Mã học sinh (nếu có) : ">
                    </div>
                    <p style="color:red ; margin-bottom: 20px;">
                    <?php
                    if(isset($_POST['submit']))
                           
                    ?></p>
                    <div style="display: flex; justify-content: space-around;">
                        <a class="form-a" href="/login.php">Làm sao để đăng nhập ?</a>
                        <input class="form-submit" type="submit" name="submit" value="Tiếp theo">
                    </div>

                    <div>
                        <a style="color: #fff;" href="">Quên mật khẩu</a>
                    </div>

                    <div>
                        <a class="form-submit" href="">Giáo viên bấm vào đây</a>
                    </div>


                </form>
            </div>


        </div>

        <div class="login-slogan">
            <img style="width: 350px; height: 125px; margin-bottom: 10px;" src="./assets/images/LoginSlogan.png" alt="">
            <div>
                <a href=""><img style="width: 150px;" src="./assets/images/app-store-badge.png" alt=""></a>
                <a href=""><img style="width:170px" src="./assets/images/google-play-badge.png" alt=""></a>
            </div>
        </div>
    </div>
    <footer>
        <p class="footer-p">Copyright © Smart Education is Now, All rights reserved</p>
    </footer>
</body>

</html>