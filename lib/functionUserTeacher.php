<?php


$path_dir = __DIR__ . '/../lib';

include $path_dir . '/database.php';

// select hoc sinh trong lop
function studentOfClass($connection, $magv)
{
    $sql = "SELECT  hs_lop.MaHS , TenHS , hs_lop.MaLop  FROM hs_lop INNER JOIN hocsinh INNER JOIN gv_lop WHERE hs_lop.MaHS = hocsinh.MaHS and gv_lop.MaLop = hs_lop.MaLop and gv_lop.MaGV = ?";
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

// insert diemdanh
function insertDiemDanh($maLop, $mahs, $tg, $dd, $connection)
{
    $sql = "insert into diemdanh values(?,?,?,?)";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $maLop);
        $statement->bindParam(2, $mahs);
        $statement->bindParam(3, $tg);
        $statement->bindParam(4, $dd);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select danh sach lop ma giao vien day
function listClassOfTeacher($connection, $magv, $tt)
{
    $sql = "SELECT lop.MaLop , TenLop , LuaTuoi, ThoiGian, SLHS , SLHSToiDa , HocPhi, SoBuoi, SoBuoiDaToChuc, TrangThai , gv_lop.TienTraGV FROM lop INNER JOIN gv_lop WHERE lop.MaLop = gv_lop.MaLop AND gv_lop.MaGV =  ? AND lop.TrangThai = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->bindParam(2, $tt);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select lich hoc cua lop
function listSchedules($connection)
{
    $sql = "SELECT schedules_class.idSchedules ,schedules_class.MaLop ,schedules.day_of_week , schedules.start_time, schedules.end_time FROM schedules_class INNER JOIN schedules WHERE schedules_class.idSchedules = schedules.idSchedules;";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select danh sach diemd danh
function listDD($connection, $magv)
{
    $sql = "SELECT  diemdanh.MaLop , diemdanh.MaHS , hocsinh.TenHS, ThoiGian, dd FROM diemdanh  INNER JOIN hocsinh INNER JOIN gv_lop WHERE diemdanh.MaHS = hocsinh.MaHS AND diemdanh.MaLop = gv_lop.MaLop and gv_lop.MaGV = ? order by ThoiGian desc";
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


//     // update diem danh

function updateDiemDanh($connection, $dd, $malop, $mahs, $tg)
{

    $sql = "UPDATE diemdanh SET dd = ? WHERE MaLop = ?  AND MaHS = ? and ThoiGian = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $dd);
        $statement->bindParam(2, $malop);
        $statement->bindParam(3, $mahs);
        $statement->bindParam(4, $tg);


        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


//     update hs_lop so buoi nghi

function updateSoBuoiNghi($connection, $soBuoiNghi, $malop, $mahs)
{

    $sql = "UPDATE hs_lop SET SoBuoiNghi = ? WHERE MaLop = ?  AND MaHS = ? ";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $soBuoiNghi);
        $statement->bindParam(2, $malop);
        $statement->bindParam(3, $mahs);

        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select SoBuoiNghi

function selectSoBuoiNghi($connection, $mahs, $malop)
{
    $sql = "SELECT * FROM hs_lop WHERE MaHS = ? AND MaLop = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $malop);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select diem danh
function selectdd($connection, $mahs, $malop, $tg)
{
    $sql = "SELECT * FROM diemdanh WHERE MaLop = ? and MaHS = ? and ThoiGian =?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->bindParam(2, $mahs);
        $statement->bindParam(3, $tg);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// Xoa giao vien
function deleteDiemDanh($connection, $malop, $tg)
{
    $sql = "delete from diemdanh where MaLop = ?  and  ThoiGian = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->bindParam(2, $tg);
        $statement->execute();
        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// select diem danh
function selectddByLopTG($connection, $malop, $tg)
{
    $sql = "SELECT * FROM diemdanh WHERE MaLop = ?  and ThoiGian =?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $malop);

        $statement->bindParam(2, $tg);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// select  so buoi to chuc  lop
function selectSoBuoiDaToChuc($connection, $malop)
{
    $sql = 'SELECT MaLop, SoBuoiDaToChuc FROM lop WHERE MaLop = ? ';
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


//     update lop s

function updateSoBuoiDaToChuc($connection, $so, $malop)
{

    $sql = "UPDATE lop SET SoBuoiDaToChuc = ? WHERE MaLop = ? ";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $so);
        $statement->bindParam(2, $malop);


        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// select luong gv

function selectLuongGV($connection, $magv)
{
    $sql = 'SELECT * FROM luonggv WHERE MaGV = ?  and  TrangThai = "Đã thanh toán"';
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//select danhs sach day hoc
function selectSoBuoiDayAll($connection)
{
    $sql = "SELECT b3.MaGV,b3.MaLop ,b3.TienTraGV ,MONTH(b3.ThoiGian) \"Thang\" ,year(b3.ThoiGian) \"Nam\" , COUNT(DISTINCT b3.ThoiGian) AS SoBuoiDay FROM (SELECT gv_lop.MaGV ,gv_lop.MaLop ,gv_lop.TienTraGV, b2.ThoiGian FROM gv_lop INNER JOIN (SELECT DISTINCT MaLop , ThoiGian FROM diemdanh)b2 INNER JOIN giaovien WHERE gv_lop.MaLop = b2.MaLop)b3 GROUP by b3.MaGV,b3.MaLop, b3.TienTraGV ,MONTH(b3.ThoiGian) ,year(b3.ThoiGian);";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// select ten gv ma gv day
function selectTenGV($connection, $magv)
{

    $sql = "SELECT  TenGV FROM giaovien WHERE MaGV = ?";

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}



    // select tt giao vien

    function selectTeacher($connection,$ma){
        $sql = "select * from giaovien where MaGV = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$ma]);

            $listClass  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listClass;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }