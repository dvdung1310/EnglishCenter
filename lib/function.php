<?php
 require './lib/database.php';
//  check có trùng user đã tồn tại hay không ?
 function checkExitUser($user,$connection){
    $sql = "select * from tk_hs Where TenDN = ?";
    try{
        $statement = $connection->prepare($sql);
       $statement->execute([$user]);
       $student = $statement->fetch();
       if($student){
         return true;
       }else{
        return false;
       }

    }catch(PDOException $e){
        echo $e->getMessage();
    }
 }

  //check mật khẩu có trùng nhau hay không  
function testConfirmPassWord($passWord,$confirmPassword){
    if($passWord === $confirmPassword) {
        return true;
    } else {
        return false;
    }   
    }

//  check tài khoản có trong database hay ko ?
      function checkAcount($userName,$passWord,$connection){
        $sql = "select * from tk_hs where BINARY  TenDN = ? and BINARY  passWord = ? ";
        try{
           $statement = $connection->prepare($sql);
           $statement->execute([$userName,$passWord]);
           $student = $statement->fetch();
           if($student){
            return true;
           }else{
            return false;
           }
        }catch(PDOException $e){
             $e->getMessage();
        }
      }

    // đăng kí bảng thông tin sinh viên
    function registerTableStudent($name,$gender,$date,$age,$address,$phone,$email,$connection){
        $sql = "insert into HOCSINH(TENHS,GioiTinh,NgaySinh,Tuoi,DIACHI,sdt,Email) values(?,?,?,?,?,?,?)";
    try{
       $statement = $connection->prepare($sql);
       $statement->bindParam(1,$name);
       $statement->bindParam(2,$gender);
       $statement->bindParam(3,$date);
       $statement->bindParam(4,$age);
       $statement->bindParam(5,$address);
       $statement->bindParam(6,$phone);
       $statement->bindParam(7,$email);
       $statement->execute();
       $id = $connection->lastInsertId();
   if($id){
    return $id;
   }else{
    return null;
   }
    }catch(PDOException $e){
         $e->getMessage();
    }
    }

    // đăng kí tài khoản Học sinh
    function registerAcountStudent($TenDN, $MaHS, $passWord,$connection){
        $sql = "insert into TK_HS values(?,?,?)";
    try{
       $statement = $connection->prepare($sql);
       $statement->bindParam(1,$TenDN);
       $statement->bindParam(2,$MaHS);
       $statement->bindParam(3,$passWord);
       $statement->execute();
       $id = $connection->lastInsertId();
   if($id){
    return $id;
   }else{
    return null;
   }
    }catch(PDOException $e){
         $e->getMessage();
    }
    }
