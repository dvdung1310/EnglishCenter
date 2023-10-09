<?php

$path_dir = __DIR__.'/../lib';

include $path_dir.'/database.php';

//  check có trùng user học sinh đã tồn tại hay không ?
function checkExitUser($user, $connection)
{
    $sql = "select * from tk_hs Where UserName = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$user]);
        $student = $statement->fetch();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//  check có trùng user phụ huynh đã tồn tại hay không ?
function checkExitParents($user, $connection)
{
    $sql = "select * from tk_ph Where UserName = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$user]);
        $student = $statement->fetch();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// check đã tồn tại mã học sinh chưa 
function checkCodeStudents($mahs, $connection)
{
    $sql = "select * from tk_hs Where mahs = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$mahs]);
        $student = $statement->fetch();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// check đã tồn tại mã phụ huynh chưa 
function checkCodeParents($maph, $connection)
{
    $sql = "select * from tk_ph Where maph = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$maph]);
        $student = $statement->fetch();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//check mật khẩu có trùng nhau hay không  
function testConfirmPassWord($passWord, $confirmPassword)
{
    if ($passWord === $confirmPassword) {
        return true;
    } else {
        return false;
    }
}

//  check tài khoản HOC SINH có trong database hay ko ?
function checkAcount($userName, $passWord, $connection)
{
    $sql = "select * from tk_hs where BINARY  userName = ? and BINARY  passWord = ? ";
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

//  check tài khoản PHU HUYNH có trong database hay ko ?
function checkAcountParents($userName, $passWord, $connection)
{
    $sql = "select * from tk_ph where BINARY  userName = ? and BINARY  passWord = ? ";
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
//  check tài khoản GIAO VIEN có trong database hay ko ?
function checkAcountTeacher($userName, $passWord, $connection)
{
    $sql = "select * from tk_gv where   UserName = ? and   Password = ? ";
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


// đăng kí bảng thông tin sinh viên
function registerTableStudent($name, $gender, $date, $age, $address, $phone, $email, $connection)
{
    $sql = "insert into HOCSINH(TENHS,GioiTinh,NgaySinh,Tuoi,DIACHI,sdt,Email) values(?,?,?,?,?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $name);
        $statement->bindParam(2, $gender);
        $statement->bindParam(3, $date);
        $statement->bindParam(4, $age);
        $statement->bindParam(5, $address);
        $statement->bindParam(6, $phone);
        $statement->bindParam(7, $email);
        $statement->execute();
        $id = $connection->lastInsertId();
        if ($id) {
            return $id;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// đăng kí tài khoản Học sinh
function registerAcountStudent($userName, $passWord, $MaHS, $connection)
{
    $sql = "insert into TK_HS values(?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $userName);
        $statement->bindParam(2, $passWord);
        $statement->bindParam(3, $MaHS);
        $student = $statement->execute();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}


function insertNgayDK($mahs, $date, $connection)
{
    $sql = "insert into ngaydkhs values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $date);

        $student = $statement->execute();
        if ($student) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// đăng kí thông tin Phụ Huynh
function registerTableParents($name, $gender, $date, $age, $address, $phone, $email, $connection)
{
    $sql = "insert into phuhuynh(tenph,gioitinh,NgaySinh,Tuoi,DIACHI,sdt,Email) values(?,?,?,?,?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $name);
        $statement->bindParam(2, $gender);
        $statement->bindParam(3, $date);
        $statement->bindParam(4, $age);
        $statement->bindParam(5, $address);
        $statement->bindParam(6, $phone);
        $statement->bindParam(7, $email);
        $statement->execute();
        $id = $connection->lastInsertId();
        if ($id) {
            return $id;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// đăng kí tài khoản phụ huynh
function registerAcountParents($userName, $passWord, $Maph, $connection)
{
    $sql = "insert into tk_ph values(?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $userName);
        $statement->bindParam(2, $passWord);
        $statement->bindParam(3, $Maph);
        $Parents = $statement->execute();
        if ($Parents) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function createTablPH_HS($Mahs, $Maph, $connection)
{
    $sql = "insert into ph_hs values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $Mahs);
        $statement->bindParam(2, $Maph);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// select giao cvien
function selectTeacherbyUsername($connection, $magv)
{
    $sql = "SELECT tk_gv.MaGV , giaovien.TenGV , giaovien.GioiTinh, giaovien.NgaySinh, giaovien.Tuoi , giaovien.QueQuan, giaovien.DiaChi, giaovien.TrinhDo, giaovien.SDT, giaovien.Email  FROM tk_gv INNER JOIN giaovien  WHERE tk_gv.MaGV = giaovien.MaGV AND UserName = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->execute([$magv]);

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select mã học sinh
function getMaHS($userName, $connection)
{
    $sql = "select MaHS from tk_hs where UserName = ? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $userName);
        $statement->execute();
        $data  = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select mã phu huynh
function getMaPH($userName, $connection)
{
    $sql = "select MaPH from tk_ph where UserName = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $userName);
        $statement->execute();
        $data  = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// đăng kí lớp học
function createTabHS_LOP($Mahs, $Malop, $connection)
{
    $sql = "insert into hs_lop(MAHS,MaLop) values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $Mahs);
        $statement->bindParam(2, $Malop);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}