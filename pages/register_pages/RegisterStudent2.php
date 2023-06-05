<?php
$path_dir = __DIR__.'/../../lib';  
include $path_dir.'/function.php';

$userName = $passWord = $confirmPassword = "";
$userName_error = $passWord_error = $confirmPassword_error = "";
$success = "";



if (isset($_POST['submit'])) {

    if (empty($_POST['userName'])) {
        $userName_error = "Bạn chưa nhập tên đăng nhập";
    } else {
        $userName = htmlspecialchars($_POST['userName']);
    }

    if (empty($_POST['passWord'])) {
        $passWord_error = "Bạn chưa nhập mật khẩu";
    } else {
        $passWord = htmlspecialchars($_POST['passWord']);
    }

    if (empty($_POST['confirmpassWord'])) {
        $confirmPassword_error = "Bạn chưa xác nhận lại mật khẩu";
    } else {
        $confirmPassword = htmlspecialchars($_POST['confirmpassWord']);
    }

    if (empty($userName_error) && empty($passWord_error) && empty($confirmPassword_error)) {
        $check = false;
        if (checkExitUser($userName, $connection)) {
            $userName_error = "Tài khoản bạn đã bị trùng";
            $check = true;
        }
        if (!testConfirmPassWord($passWord, $confirmPassword)) {
            $passWord_error = $confirmPassword_error = "Mật khẩu không trùng khớp";
            $check = true;
        }

        if (!$check) {
            $maHS = registerTableStudent($_COOKIE['name'], $_COOKIE['gender'], $_COOKIE['date'], $_COOKIE['age'], $_COOKIE['address'], $_COOKIE['phone'], $_COOKIE['email'], $connection);
            registerAcountStudent($userName, $passWord, $maHS, $connection);
            
            insertNgayDK($maHS,date('Y-m-d'),$connection);
    
            if ($_COOKIE['maph']!=' ') {
                createTablPH_HS($maHS, $_COOKIE['maph'], $connection);
            }

            $success = 'Tạo tài khoản thành công';
        }
    }

    // if($userName!=""){
    //     $result = checkExitUser($userName,$connection);
    //     if($result){
    //         $userName_error = "Tài khoản bạn đã bị trùng";
    //     }else if(!empty($passWord) && !empty($confirmPassword)){
    //         $check = testConfirmPassWord($passWord,$confirmPassword);
    //         if($check){
    //             $student = registerAcountStudent($userName, $passWord, $maHS,$connection);
    //             if($student){
    //               $success = "Bạn đã tạo tài khoản thành công";
    //               $maph = $_GET['maph'];
    //               if($maHS != null){
    //                 createTablPH_HS($maHS,$maph,$connection);
    //               }
    //             }else{
    //                 $success = "Lỗi !!!";
    //             }
    //         }else{
    //             $confirmPassword_error = "Mật khẩu không trùng khớp";
    //         }
    //     }

    // }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apollo-register</title>
    <link rel="stylesheet" href="/assets/css/login.css">
</head>

<body>
    <div class="login-star">
        <img src="/assets/images/login_stars.png" alt="">
    </div>
    <div id="contain">

        <div class="login-student" style=" width: 500px;">
            <div class="login-student-img">
                <img src="/assets/images/Apollo-Logo.png" alt="">
            </div>

            <div class="login-student-form">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div style="display: flex;justify-content: start;">
                        <h1>Tạo tài khoản</h1>
                    </div>
                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="text" name="userName" placeholder="Nhập tên đăng nhập:" value="<?php echo $userName ?>">
                    </div>
                    <p style="color:red ; margin-bottom: 20px;font-size : 18px">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo "$userName_error";
                        }

                        ?></p>
                    <div>
                        <input name="passWord" class="login-student-form-input" type="password" placeholder="Nhập mật khẩu : ">
                    </div>
                    <p style="color:red ; margin-bottom: 20px;font-size : 18px">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo "$passWord_error";
                        }

                        ?></p>

                    <div>
                        <input name="confirmpassWord" class="login-student-form-input" type="password" placeholder="Xác nhận mật khẩu : ">
                    </div>
                    <p style="color:red ; margin-bottom: 20px;font-size : 18px">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo "$confirmPassword_error";
                        }

                        ?></p>
                    <p style="color:lime; margin-bottom: 20px;font-size : 18px">
                        <?php
                        if (isset($_POST['submit'])) {
                            echo "$success";
                        }

                        ?></p>
                    <div style="display: flex; justify-content: space-around;">
                        <a class="form-a" style="padding: 15px 30px" href="./RegisterStudent.php">Trở lại</a>
                        <input class="form-submit" type="submit" name="submit" style="padding: 15px 30px" value="Đăng kí">
                    </div>

                    <div>
                        <a style="color: #fff;" href=""> </a>
                    </div>

                    <div>
                        <a class="form-submit" href="login.php">Quay lại trang đăng nhập</a>
                    </div>


                </form>
            </div>


        </div>

        <div class="login-slogan">
            <img style="width: 350px; height: 125px; margin-bottom: 10px;" src="/assets/images/LoginSlogan.png" alt="">
            <div>
                <a href=""><img style="width: 150px;" src="/assets/images/app-store-badge.png" alt=""></a>
                <a href=""><img style="width:170px" src="/assets/images/google-play-badge.png" alt=""></a>
            </div>
        </div>
    </div>
    <footer>
        <p class="footer-p">Copyright © Smart Education is Now, All rights reserved</p>
    </footer>
</body>

</html>