<?php


$path_dir = __DIR__.'/../../lib';  
include $path_dir.'/function.php';



$name = $gender = $date = $address = $age = $phone = $email = $maph = "";
$error_name = $error_gender = $error_date = $error_address = $error_age = $error_phone = $error_email = "";
$check = true;
$error_check = "";
if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $error_name = "Chưa nhập tên";
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['gender'])) {
        $error_gender = "Chưa chọn giới tính ";
    } else {
        $gender = $_POST['gender'];
    }

    if (empty($_POST['date'])) {
        $error_date = "Chưa điền đủ thông tin ngày sinh ";
    } else {
        $date = $_POST['date'];
    }

    if (empty($_POST['address'])) {
        $error_address = "Chưa nhập địa chỉ ";
    } else {
        $address = $_POST['address'];
    }

    if (empty($_POST['age'])) {
        $error_age = "Chưa nhập tuổi";
    } else {
        $age = $_POST['age'];
        if ((!is_int($age) && $age <= 0)) {
            $error_age = "Nhập sai dữ liệu tuổi";
        }
    }

    if (empty($_POST['phone'])) {
        $error_phone = "";
        $phone = '';
    } else {
        $phone = $_POST['phone'];
        if (!(preg_match('/^(0[0-9]{9})$/', $phone))) {
            $error_phone = "Số điện thoại không hợp lệ";
        }
    }

    if (empty($_POST['email'])) {
        $error_email = "";
        $email = "";
    } else {
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_email = "Nhập Email không hợp lệ";
        }
    }


}

$check_empty = false;
if (isset($_POST['submit'])) {
    $check_empty = empty($error_name) && empty($error_gender) && empty($error_address) && empty($error_age) && empty($error_date) && empty($error_check) && empty($error_email) && empty($error_phone);
}

if ($check_empty) {

    if (empty($phone)) {
        $phone = ' ';
    }

    if (empty($email)) {
        $email = ' ';
    }

    setcookie('name', $name);
    setcookie('gender', $gender);
    setcookie('date', $date);
    setcookie('age', $age);
    setcookie('address', $address);
    setcookie('phone', $phone);
    setcookie('email', $email);
    header('Location: RegisterStudent2.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoDuHi-login</title>
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>

<body>
    <div class="login-star">
        <img src="../../assets/images/login_stars.png" alt="">
    </div>
    <div id="contain">
        <div class="login-student">
            <div class="login-student-img">

            <a href="../home/home.php"><img src="../../assets/images/logo-web.png" alt=""></a>            </div>

            <div style="padding: 0 100px;" class="login-student-form">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div style="display: flex;justify-content: start;">
                        <h1>Nhập thông tin cá nhân</h1>
                    </div>
                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="text" name="name" placeholder="Họ và tên :"  value="<?php echo $name ?>">
                    </div>
                    <p style="color:red;font-size : 18px" >
                        <?php
                        echo $error_name;
                        ?>
                    </p>

                    <div style="display: flex; " class="login-student-form-center">
                        <div>
                            <h1 style="font-size : 25px; margin-right: 120px">Giới tính </h1>
                            <select name="gender" style="font-size: 20px;">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>

                            </select>
                        </div>

                    </div>
                    <p style="color:red;font-size : 18px" >
                        <?php
                        echo $error_gender;
                        ?>
                    </p>

                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="date" name="date" placeholder="Ngày sinh :" value="<?php echo $date ?>">
                    </div>

                    <p style="color:red;font-size : 18px ">
                        <?php
                        echo $error_date;
                        ?>
                    </p>
                    
                    <div class="login-student-form-center">
                        <input class="login-student-form-input"  type ="text" name="age" placeholder="Tuổi:"  value="<?php echo $age ?>">
                    </div>

                    <p style="color:red;font-size : 18px">
                        <?php
                        echo $error_age;
                        ?>
                    </p>

                    <div>
                        <input name="address" class="login-student-form-input" type="text" placeholder="Địa Chỉ : "  value="<?php echo $address ?>">
                    </div>
                    <p style="color:red;font-size : 18px">
                        <?php
                        echo $error_address;
                        ?>
                    </p>

                    <div>
                        <input name="phone" class="login-student-form-input" type="text" placeholder="Số điện thoại(nếu có) : " value="<?php echo $phone ?>">
                    </div>
                    <p style="color:red;font-size : 18px">
                        <?php
                        echo $error_phone;
                        ?>
                    </p>

                    <div>
                        <input name="email" class="login-student-form-input" type="text" placeholder="Email (nếu có) : " value="<?php echo $email ?>">
                    </div>

                    <p style="color:red;font-size : 18px">
                        <?php
                        echo $error_email;
                        ?>
                    </p>
                   
                    <p style="color:red;font-size : 18px">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo $error_check;
                        }

                        ?></p>
                    <p style="color:red;font-size : 18px ; margin-bottom: 20px;">
                        <?php
                        if (isset($_POST['submit'])) {;
                        }
                        ?></p>
                    <div style="display: flex; justify-content: space-around;">
                        <a class="form-a" href="../login_pages/login.php">Quay trở lại trang đăng nhập</a>
                        <input class="form-submit" type="submit" name="submit" value="Tiếp theo">
                    </div>

                    <div>
                        <a style="color: #fff;" href=""></a>
                    </div>

                    <div>

                    </div>


                </form>
            </div>


        </div>

        <div class="login-slogan">
            <img style="width: 350px; height: 125px; margin-bottom: 10px;" src="../../assets/images/LoginSlogan.png" alt="">
            <div>
                <a href=""><img style="width: 150px;" src="../../assets/images/app-store-badge.png" alt=""></a>
                <a href=""><img style="width:170px" src="../../assets/images/google-play-badge.png" alt=""></a>
            </div>
        </div>
    </div>
    <footer>
        <p class="footer-p" style="position: relative; bottom: 0;">Copyright © Smart Education is Now, All rights reserved</p>
    </footer>
</body>

</html>