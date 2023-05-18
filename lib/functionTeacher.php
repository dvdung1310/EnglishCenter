<?php

    
    $path_dir = __DIR__.'/../lib';

    include $path_dir.'/database.php';
    // select danh sách giáo viên
    function listTeacher($connection){
        $sql = "select * from giaovien";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute();

            $listTeacher  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listTeacher;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    // select những lớp mà giáo viên x dạy

    function classOfTeacher($connection,$magv){
        $sql = "select * from gv_lop where MaGV = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$magv]);

            $listClass  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listClass;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    //  check tài khoản ADMIN có trong database hay ko ?
function checkAcountAdmin($userName, $passWord, $connection)
{
    $sql = "select * from admin where BINARY  userName = ? and BINARY  passWord = ? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$userName, $passWord]);
        $student = $statement->fetch();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


?>