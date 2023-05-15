<?php

$path_dir = __DIR__.'/../../lib';  
include $path_dir.'/function.php';

$userName = $passWord = "";
$userName_error = $passWord_error = "";

if (isset($_POST['submit'])) {
	if (empty($_POST['username'])) {
		$userName_error = "Bạn chưa nhập tên đăng nhập!";
	} else {
		$userName = htmlspecialchars($_POST['username']);
	}
	if (empty($_POST['password'])) {
		$passWord_error = "Bạn chưa nhập mật khẩu!";
	} else {
		$passWord = htmlspecialchars($_POST['password']);
	}
}

$test = false;

if (isset($_POST['submit'])) {
	$test = empty($userName_error) && empty($passWord_error);

}


if ($test) {
    $result = checkAcountAdmin($userName, $passWord, $connection);
    if ($result) {
        session_start();
        $_SESSION['userName'] = htmlspecialchars($userName);
        header("Location: ../main_pages/homeAdmin.php");
        exit();
    } else {
        $passWord_error = "Tài khoản hoặc mật khẩu bạn sai";
    }
}

// if ($test) {
// 	$result = checkAcount($userName, $passWord, $connection);
// 	$checkParents = checkAcountParents($userName, $passWord, $connection);
// 	if ($result || $checkParents) {
// 		session_start();
// 		$_SESSION['userName'] = htmlspecialchars($userName);
// 		header("Location: pages/homeAdmin.php");
// 		exit();
// 	} else {
// 		$passWord_error = "Username hoặc password của bạn sai!";
// 	}
// }


?>





<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<style>
		body {
			background-color: #333;
		}

		.login {
			width: 400px;
			background-color: #fff;
			margin: 10% auto;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
		}

		.login h1 {
			text-align: center;
			color: #333;
			font-size: 32px;
			margin-bottom: 20px;
			font-weight: normal;
		}

		.login input[type="text"],
		.login input[type="password"] {
			width: 100%;
			padding: 10px;
			border: none;
			background-color: #f5f5f5;
			margin-bottom: 20px;
			font-size: 16px;
			border-radius: 5px;
			box-shadow: none;
		}

		.login input[type="submit"] {
			width: 105%;
			background-color: #333;
			color: #fff;
			padding: 10px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			cursor: pointer;
			transition: background-color 0.3s ease-in-out;
		}

		.login input[type="submit"]:hover {
			background-color: #444;
		}



		.back:hover {
			color: #aaa;
		}

		.back {
			width: 100%;
			background-color: yellowgreen;
			color: #fff;
			padding: 10px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			cursor: pointer;
			transition: background-color 0.3s ease-in-out;
			margin-top: 15px;
			text-align: center;
			display: inline-block;
		}
	</style>
</head>

<body>
	<div class="login">
		<h1>Admin Login</h1>
		<form action="#" method="post">
			<input type="text" name="username" placeholder="Username">
			<p style="color:red ; margin-bottom: 20px;font-size : 18px">
				<?php
				if (isset($_POST['submit']))
					echo $userName_error;
				?></p>
			<input type="password" name="password" placeholder="Password">
			<p style="color:red ; margin-bottom: 20px;font-size : 18px">
				<?php
				if (isset($_POST['submit']))
					echo $passWord_error;
				?></p>
			<input type="submit" name="submit" value="Login">

		</form>
		<a href="./login.php" class="back">Back</a>
	</div>
</body>

</html>