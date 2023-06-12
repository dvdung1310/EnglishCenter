<?php

include '../../lib/function.php';

$userName = $passWord = "";
$userName_error = $passWord_error = "";
if (isset($_POST['submit'])) {
    if (empty($_POST['userName'])) {
        $userName_error = "Bạn chưa nhập tên đăng nhập!";
    } else {
        $userName = htmlspecialchars($_POST['userName']);
    }
    if (empty($_POST['passWord'])) {
        $passWord_error = "Bạn chưa nhập mật khẩu!";
    } else {
        $passWord = htmlspecialchars($_POST['passWord']);
    }
}
$test = false;
if (isset($_POST['submit'])) {
    $test = empty($userName_error) && empty($passWord_error);
}

if ($test) {
    $check_student = checkAcount($userName, $passWord, $connection);

    if ($check_student){
        session_start();
        $mahs = getMaHS($userName,$connection);
        $_SESSION['MaHS'] = $mahs;
        header("Location: ../main_pages/homeStudent.php");
        exit();
    } else {
        $check_parent = checkAcountParents($userName, $passWord, $connection);
        if ($check_parent) {
            session_start();
            $maph = getMaPH($userName,$connection);
            $_SESSION['MaPH'] = $maph;
            header("Location: ../main_pages/homeParent.php");
            exit();
        } else {
            $passWord_error = "Tên đăng nhập hoặc mật khẩu của  bạn sai!";
        }
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
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>

<body>
    <div class="admin-login" style="float : right">
        <button><a href="./loginAdmin.php">Đăng nhập Admin</a></button>
    </div>

    <div class="login-star">
        <img src="../../assets/images/login_stars.png" alt="">
    </div>
    <div id="contain-login">

        <div class="login-student">
            <div class="login-student-img">
                <img src="../../assets/images/logo-web.png" alt="">
            </div>
            <div class="login-student-form">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div style="display: flex;justify-content: start;">
                        <h1>Đăng nhập</h1>
                    </div>
                    <div class="login-student-form-center">
                        <input class="login-student-form-input" type="text" name="userName" placeholder="Tên đăng nhập">
                    </div>
                    <p style="color:red ; margin-bottom: 20px;font-size : 18px"><?php
                                                                echo "$userName_error";
                                                                ?></p>
                    <div>
                        <input name="passWord" class="login-student-form-input" type="password" placeholder="Mật khẩu : ">
                    </div>
                    <p style="color:red ; margin-bottom: 20px;font-size : 18px">
                        <?php
                        if (isset($_POST['submit']))
                            echo "$passWord_error";
                        ?></p>
                    <div style="display: flex; margin-right: 10px; justify-content: space-around;">
                        <a class="form-a" href="../register_pages/RegisterStudent.php">Đăng kí tài khoản học sinh</a>
                        <a class="form-a" href="../register_pages/RegisterParent.php">Đăng kí tài khoản phụ huynh</a>
                    </div>

                    <div>
                        <input class="form-submit" type="submit" name="submit" value="Đăng nhập">
                    </div>

                    <div>
                        <a class="form-submit" href="./loginGV.php">Giáo viên bấm vào đây</a>
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
        <p class="footer-p">Copyright © Smart Education is Now, All rights reserved</p>
    </footer>
</body>

<script>
    
</script>

</html>