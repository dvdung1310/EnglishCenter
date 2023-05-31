<?php

$path_dir = __DIR__ . '/../lib';

include $path_dir . '/database.php';
// select danh sách hoa don
function listBill($connection)
{
    $sql = "select * from hdhocphi";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select danh sách hoc sinh
function listStudent($connection)
{
    $sql = "select * from hocsinh";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//select danh sách lớp "Đang mở"
function listClassOpen($connection)
{
    $sql = "SELECT MaLop, ThoiGian FROM diemdanh;";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// select danh sach diem danh
function listDD($connection)
{
    $sql = "SELECT * FROM diemdanh;";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Select số buổi điểm danh

function attendOfMonth($connection, $month, $year)
{
    $begin = date("$year-$month-01");

    $finish = date("Y-m-t", strtotime($begin));

    $sql = 'SELECT MaLop, MaHS, COUNT(*) AS "SoBuoiDiemDanh" FROM diemdanh WHERE ThoiGian BETWEEN ? AND ? AND dd = true GROUP BY MaLop, MaHS';
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $begin);
        $statement->bindParam(2, $finish);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

// insert hdhocpho
function insertHDHocPhi($connection, $tenHD, $maLop, $maHS, $ThoiGian, $SoTien, $GiamHocPhi, $SoTienGiam, $SoTienPhaiDong)
{
    $s = 'Chưa đóng';
    $sql = "insert into  hdhocphi (TenHD, MaLop, MaHS, ThoiGian, SoTien, GiamHocPhi, SoTienGiam, SoTienPhaiDong, NoPhiConLai,TrangThai) values(?,?,?,?,?,?,?,?,?,?)";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $tenHD);
        $statement->bindParam(2, $maLop);
        $statement->bindParam(3, $maHS);
        $statement->bindParam(4, $ThoiGian);
        $statement->bindParam(5, $SoTien);
        $statement->bindParam(6, $GiamHocPhi);
        $statement->bindParam(7, $SoTienGiam);
        $statement->bindParam(8, $SoTienPhaiDong);
        $statement->bindParam(9, $SoTienPhaiDong);
        $statement->bindParam(10, $s);
        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select hocPhiHS
function selecths_hocPhi($connection)
{
    $sql = "SELECT MaHS , hs_lop.MaLop , GiamHocPhi , lop.HocPhi  FROM hs_lop INNER JOIN lop WHERE hs_lop.MaLop =  lop.MaLop;";

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//search HD
function searchHDHocPhi($connection, $key)
{
    $sql = "SELECT hdhocphi.MaHS , MaHD, TenHD,MaLop , ThoiGian, SoTien, GiamHocPhi,SoTienGiam, SoTienPhaiDong, SoTienDaDong, NoPhiConLai,TrangThai ,hocsinh.TenHS, hocsinh.GioiTinh, hocsinh.NgaySinh, hocsinh.Tuoi, hocsinh.DiaChi, hocsinh.SDT, hocsinh.Email  FROM `hdhocphi` INNER JOIN hocsinh WHERE hdhocphi.MaHS = hocsinh.MaHS and

         (MaHD like :key or TenHD like :key or ThoiGian like :key or TrangThai like :key or hocsinh.TenHS like :key or MaLop like :key )";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// select hs_lop hocsinh
function lisths_lopxHS($connection)
{
    $sql = "SELECT hs_lop.MaHS , MaLop , hocsinh.TenHS, hocsinh.GioiTinh,hocsinh.NgaySinh, hocsinh.Tuoi, hocsinh.DiaChi, hocsinh.SDT, hocsinh.Email FROM hs_lop INNER JOIN hocsinh WHERE hs_lop.MaHS = hocsinh.MaHS;";

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function updateHoaDonHocPhi($connection, $tenhd, $tg, $tt, $mahd)
{

    $sql = "update hdhocphi set TenHD = ? , ThoiGian = ? , TrangThai = ?  where MaHD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $tenhd);
        $statement->bindParam(2, $tg);
        $statement->bindParam(3, $tt);
        $statement->bindParam(4, $mahd);

        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//Xoa hoa don hoc phi
function deleteHDHocPhi($connection, $mahd)
{
    $sql = "delete from hdhocphi where MaHD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute([$mahd]);
        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

//Xoa ls thu hoc phi
function deleteLSTHPbyMaHD($connection, $mahd)
{
    $sql = "delete from lsthp where MaHD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute([$mahd]);
        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}
//select lsthp
function listLSTHP($connection)
{
    $sql = "select * from lsthp";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//insert lsthp

function insertlsthp($mahd, $tg, $st, $connection)
{
    $sql = "insert into lsthp(MaHD,ThoiGian,SoTien) values (?,?,?)";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $mahd);
        $statement->bindParam(2, $tg);
        $statement->bindParam(3, $st);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select sotienphaiDong , so Tien da Dong no Phi con lai
function selectSTPD_NPCL($connection, $mahd)
{
    $sql = "select MaHD , SoTienPhaiDong  , SoTienDaDong , NoPhiConLai from hdhocphi  where MaHD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute([$mahd]);

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// update hoadon thu hoc phi khi them giao dich
function updateHDTHP_addLSTHP($connection, $stdd, $npcl, $tt, $mahd)
{

    $sql = "update hdhocphi set  SoTienDaDong = ? , NoPhiConLai = ? , TrangThai = ?  where MaHD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $stdd);
        $statement->bindParam(2, $npcl);
        $statement->bindParam(3, $tt);
        $statement->bindParam(4, $mahd);

        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// update lsthp

function updateLSTHP($connection, $tg, $st, $magd)
{

    $sql = "update lsthp set  ThoiGian = ? ,SoTien = ?   where MaGD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $tg);
        $statement->bindParam(2, $st);
        $statement->bindParam(3, $magd);

        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//
function selectLSTHPbyMaHD($connection, $mahd)
{
    $sql = "select MaHD , MaGD from lsthp  where MaHD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute([$mahd]);

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//
function deleteLSTHPbyMaGD($connection, $magd)
{
    $sql = "delete from lsthp where MaGD = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->execute([$magd]);
        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}
