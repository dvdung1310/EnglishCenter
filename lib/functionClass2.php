<?php
include "../../lib/database.php";


// danh sách lịch học
function listSchedules($connection)
{
    $sql = "SELECT * FROM schedules";
    try {
        $stmt = $connection->query($sql);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}
// danh sách giáo viên
function listTeacher($connection)
{
    $sql = "SELECT * FROM giaovien";
    try {
        $stmt = $connection->query($sql);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

// tạo lớp 
function CreateClass($MaLop, $TenLop, $LuaTuoi, $ThoiGian, $SLHS, $SLHSToiDa, $HocPhi, $SoBuoi, $SoBuoiDaToChuc, $TrangThai, $connection)
{
    $sql = "insert into lop values(?,?,?,?,?,?,?,?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $MaLop);
        $statement->bindParam(2, $TenLop);
        $statement->bindParam(3, $LuaTuoi);
        $statement->bindParam(4, $ThoiGian);
        $statement->bindParam(5, $SLHS);
        $statement->bindParam(6, $SLHSToiDa);
        $statement->bindParam(7, $HocPhi);
        $statement->bindParam(8, $SoBuoi);
        $statement->bindParam(9, $SoBuoiDaToChuc);
        $statement->bindParam(10, $TrangThai);
        $class = $statement->execute();
        if ($class) {
            return $MaLop;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
// xóa lớp
function deleteClass($malop, $connection)
{
    $sql = "delete from lop where MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
// tạo class_gv
function CreateTeacher_Class($magv, $MaLop, $TienTraGV, $connection)
{
    $sql = "insert into gv_lop values(?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->bindParam(2, $MaLop);
        $statement->bindParam(3, $TienTraGV);
        $teacherClass = $statement->execute();
        if ($teacherClass) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// tạo class_lich hoc
function CreateSchedules_Class($idSchedules, $MaLop, $connection)
{
    $sql = "insert into schedules_class values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $idSchedules);
        $statement->bindParam(2, $MaLop);
        $SchedulesClass = $statement->execute();
        if ($SchedulesClass) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// danh sách lớp học
function listClass($connection)
{
    $sql = "SELECT * FROM lop";
    try {
        $stmt = $connection->query($sql);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// giáo viên tương ứng với lớp
function teacherByidClass($idClass, $connection)
{
    $sql = "SELECT magv FROM gv_lop where MaLop = '?' ";
    try {
    } catch (PDOException $e) {
    }
}

// truy vấn dữ liệu ra lịch học với mã lớp
function dataSchedulesByMaLop($malop, $connection)
{
    $sql = "SELECT schedules.idSchedules, schedules.day_of_week , schedules.start_time , schedules.end_time
    from schedules_class
    INNER JOIN lop on schedules_class.MaLop = lop.MaLop
    INNER JOIN schedules on schedules_class.idSchedules = schedules.idSchedules
    WHERE lop.MaLop = ?;";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

// truy vấn dữ liệu ra giáo viên từ mã lớp
function dataTeacherByMaLop($malop, $connection)
{
    $sql = "SELECT giaovien.* , gv_lop.TienTraGV
    from gv_lop
    INNER JOIN giaovien on gv_lop.MAGV = giaovien.MaGV
    INNER JOIN lop on lop.MaLop = gv_lop.MaLop
    WHERE lop.MaLop = ?;";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

// truy vấn ra dữ liệu lớp học có trạng thái là 1 0 2;
function dataClassOnOff($trangthai, $connection)
{
    $sql = "select * from lop where trangthai = ? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $trangthai);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}
// Truy vấn ra dữ liệu lớp học từ mã id lớp 
function dataClassById($malop, $connection)
{
    $sql = "select * from lop where MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}

// thục hiện xóa lớp (xóa lớp , liên kết lớp vs lịch học , lớp vs giáo viên)
function deleteClassById($malop, $connection)
{
    $sql1 = "DELETE from gv_lop where MaLop = ?";
    $sql2 = "DELETE from schedules_class where MaLop = ?";
    $sql3 = "DELETE from lop where MaLop = ?";
    try {
        $statement1 = $connection->prepare($sql1);
        $statement2 = $connection->prepare($sql2);
        $statement3 = $connection->prepare($sql3);

        $statement1->execute([$malop]);
        $statement2->execute([$malop]);
        $statement3->execute([$malop]);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// update lop 
function updateClassbyID(
    $MaLop,
    $TenLop,
    $LuaTuoi,
    $ThoiGian,
    $SLHS,
    $SLHSToiDa,
    $HocPhi,
    $SoBuoi,
    $SoBuoiDaToChuc,
    $TrangThai,
    $connection
) {

    $sql = "update lop set TenLop = ? , LuaTuoi = ?, ThoiGian= ?, SLHS= ? , 
    SLHSToiDa = ?, HocPhi = ?,SoBuoi = ?,
     SoBuoiDaToChuc = ? ,  TrangThai = ? 
      where MaLop = ?";
    try {
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $TenLop);
        $statement->bindParam(2, $LuaTuoi);
        $statement->bindParam(3, $ThoiGian);
        $statement->bindParam(4, $SLHS);
        $statement->bindParam(5, $SLHSToiDa);
        $statement->bindParam(6, $HocPhi);
        $statement->bindParam(7, $SoBuoi);
        $statement->bindParam(8, $SoBuoiDaToChuc);
        $statement->bindParam(9, $TrangThai);
        $statement->bindParam(10, $MaLop);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// update lop_lịch
function updateClass_SchedulesByID($malop, $idSchedules, $newIdSchedules, $connection)
{
    $sql = "delete from schedules_class where  MaLop = ? and idSchedules = ?";
    $sql2 = "insert into schedules_class values(?,?)";
    try {
        $statement1 = $connection->prepare($sql);
        $statement2 = $connection->prepare($sql2);

        $statement1->bindParam(1, $malop);
        $statement1->bindParam(2, $idSchedules);

        $statement2->bindParam(1, $newIdSchedules);
        $statement2->bindParam(2, $malop);

        $statement1->execute();
        $statement2->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// update lop_teacher
function updateClass_TeacherByID($malop, $idTeacher, $newIdteacher, $TeacherSalarie, $newTeacherSalarie, $connection)
{
    $sql = "delete from gv_lop where MAGV = ? and MaLop = ? and TienTraGV = ?";
    $sql2 = "insert into gv_lop values(?,?,?)";
    try {
        $statement1 = $connection->prepare($sql);
        $statement2 = $connection->prepare($sql2);

        $statement1->bindParam(1, $idTeacher);
        $statement1->bindParam(2, $malop);
        $statement1->bindParam(3, $TeacherSalarie);

        $statement2->bindParam(1, $newIdteacher);
        $statement2->bindParam(2, $malop);
        $statement2->bindParam(3, $newTeacherSalarie);


        $statement1->execute();
        $statement2->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function searchClassOn($key, $connection)
{

    $sql = "select lop.* from lop
     INNER JOIN gv_lop on lop.MaLop = gv_lop.MaLop
      INNER JOIN giaovien on gv_lop.MAGV = giaovien.MaGV
      where 
      trangthai = 'Đang mở' and
      (lop.MaLop like :key
    or lop.TenLop like :key 
    or lop.LuaTuoi like :key 
    or lop.ThoiGian like :key 
    or lop.SLHS like :key 
    or lop.SLHSToiDa like :key 
    or  lop.HocPhi like :key 
    or  lop.SoBuoi like :key 
    or giaovien.TenGV like :key)";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
        $statement->execute();

        $listClass  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $listClass;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    // INNER JOIN gv_lop on lop.MaLop = gv_lop.MaLop
    //  INNER JOIN giaovien on gv_lop.MAGV = giaovien.MaGV
}

function searchClassOff($key, $connection)
{
    $sql = "select lop.* from lop
    INNER JOIN gv_lop on lop.MaLop = gv_lop.MaLop
     INNER JOIN giaovien on gv_lop.MAGV = giaovien.MaGV
     where 
     trangthai = 'Chưa mở' and
     (lop.MaLop like :key
   or lop.TenLop like :key 
   or lop.LuaTuoi like :key 
   or lop.ThoiGian like :key 
   or lop.SLHS like :key 
   or lop.SLHSToiDa like :key 
   or  lop.HocPhi like :key 
   or  lop.SoBuoi like :key 
   or giaovien.TenGV like :key)";

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
        $statement->execute();

        $listClass  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $listClass;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// lớp đóng
function searchClassClose($key, $connection)
{
    $sql = "select lop.* from lop
    INNER JOIN gv_lop on lop.MaLop = gv_lop.MaLop
     INNER JOIN giaovien on gv_lop.MAGV = giaovien.MaGV
     where 
     trangthai = 'Đã đóng' and
     (lop.MaLop like :key
   or lop.TenLop like :key 
   or lop.LuaTuoi like :key 
   or lop.ThoiGian like :key 
   or lop.SLHS like :key 
   or lop.SLHSToiDa like :key 
   or  lop.HocPhi like :key 
   or  lop.SoBuoi like :key 
   or giaovien.TenGV like :key)";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
        $statement->execute();

        $listClass  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $listClass;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// danh sách hoc sinh dang học lớp 
function ListStudentByClass($malop, $connection)
{
    $sql = "select * from hocsinh 
                where hocsinh.MaHS in (select hs_lop.MaHS from hs_lop Where hs_lop.MaLop = ? )
        ";

    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// đếm số lần nghĩ học của sinh viên 
function numberAbsences($mahs, $malop, $connection)
{
    $sql = "select COUNT(*) as Absences
            FROM diemdanh
            WHERE MAHS = ? AND dd = false and MaLop = ?;";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// danh sách điểm danh của lớp học
function ListTimeAttendance($malop, $connection)
{
    $sql = "select DISTINCT ThoiGian from diemdanh where MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// đểm số lượng sinh viên đi học bằng thơi gian hôm đó
function TotalStudentByTime($time, $connection)
{
    $sql = "select count(ThoiGian) as total from diemdanh where dd = 1 and ThoiGian = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $time);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// thêm dấu phẩy nhé
function numberWithCommas($x)
{
    return preg_replace('/\B(?=(\d{3})+(?!\d))/', ',', strval($x));
}

// đổi ngày 
function convertDateFormat($dateString)
{
    $dateObject = date_create_from_format('Y-m-d', $dateString);
    $formattedDate = date_format($dateObject, 'd-m-Y');
    return $formattedDate;
}

// truy vấn ra giáo viên đã dạy trong thời gian nào 
function timeTeacher($connection)
{
    $sql = "select schedules_class.idSchedules ,gv_lop.MAGV
        FROM schedules_class
        inner JOIN lop on schedules_class.MaLop = lop.MaLop
        INNER JOIN gv_lop on gv_lop.MaLop = lop.MaLop
        WHERE gv_lop.MAGV in (SELECT giaovien.MaGV from giaovien )";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// truy vấn ra danh sách mã sv điểm danh của ngày hôm đó 
function getCodeStudentByTimeandCodeClass($malop, $time, $connection)
{
    $sql = "select MAHS , dd from diemdanh where MaLop = ? and ThoiGian = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->bindParam(2, $time);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// truy vẫn hs từ mã hs
function getStudentByid($mahs, $connection)
{
    $sql = "select * from hocsinh where MAHS = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// số lượng điểm danh của 1 lớp 
function getCountDD($dd, $malop, $connection)
{
    $sql = "SELECT count(dd) as 'dihoc' FROM `diemdanh` WHERE dd = ? and MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $dd);
        $statement->bindParam(2, $malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
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
        $check =  $statement->execute();
        
        if($check){
            return true;
        }else{
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function setHSDANGKI($SLHS, $Malop, $connection)
{
    $stRegister = $SLHS+1;
    $sql = "update lop set SLHS = ?  where MaLop = ? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $stRegister);
        $statement->bindParam(2, $Malop);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function setExits_hs_lop($mahs, $Malop, $connection)
{
    $sql = "select * from hs_lop  where MaHS = ? and MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $Malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if($data){
            return true;
        }else{
            return false;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function checkExitPH_HS($mahs,$connection){
    $sql = "select * from ph_hs where MAHS = ? ";
    try{
      $statement = $connection->prepare($sql);
      $statement->bindParam(1, $mahs);
      $statement->execute();
      $data = $statement->fetch(PDO::FETCH_ASSOC);
      if($data){
        return true;
      }else{
        return false;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
  }
}


// giảm học phí
function discount($Malop, $connection)
{
    $sql = "select * from lopghp where MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $Malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//
function selectClassGHP( $connection)
{
    $sql = "select * from lopghp ";
    try {
        $statement = $connection->prepare($sql);

        $statement->execute();
        $data =$statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// giảm học phí

function insertDiscountMahs($Malop,$Mahs,$GiamHocPhi, $connection)
{
    $sql = "update hs_lop set GiamHocPhi = ? where MaHS = ? and MaLop = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $GiamHocPhi);
        $statement->bindParam(2, $Mahs);
        $statement->bindParam(3, $Malop);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getDiscount($malop,$connection){
    $sql = "select * from lopghp where MaLop = ?";
    try{
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }catch(PDOException $e) {
        $e->getMessage();
    }
}

function setSLHSToiDa($malop,$connection){
    $sql = "update lop set TrangThai = 'Đang mở' where MaLop = ?";
    try{
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
    }catch(PDOException $e) {
        $e->getMessage();
    }
}


// // select ten hs 
function selectTenHS($connection, $magv)
{

    $sql = "SELECT  TenHS FROM hocsinh WHERE MaHS = ?";

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

function selectStudent($connection,$ma){
    $sql = "select * from hocsinh where MaHS = ?";
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

function selectParent($connection,$ma){
    $sql = "select * from phuhuynh where MaPH = ?";
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

function selectTenPH($connection, $magv)
{

    $sql = "SELECT  TenPH FROM phuhuynh WHERE MaPH = ?";

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


// insert lienketph_hs
function insertLienKet($mahs, $maph, $tenhs, $tenph,$nyc, $connection)
{
    $sql = "insert into lienketph_hs values(?,?,?,?,?)";
    try {
        $statement = $connection->prepare($sql);

        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $maph);
        $statement->bindParam(3, $tenhs);
        $statement->bindParam(4, $tenph);
        $statement->bindParam(5, $nyc);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// // select ds lienket phuhuynh hoc sinh 
function selectdslk($connection, $magv)
{

    $sql = 'SELECT * FROM lienketph_hs WHERE nyc = "hs" and  MaPH = ? ';

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

// // delêt ds lienket phuhuynh hoc sinh 
function deletedslk($connection, $mahs , $maph)
{

    $sql = 'DELETE FROM lienketph_hs WHERE MaHS = ? and MaPH =?';

    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindParam(1, $mahs);
        $statement->bindParam(2, $maph);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// insert ph-hs
function insertPHHS($Mahs, $Maph, $connection)
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

//search HD
function searchHDHocPhi($connection, $key, $maph)
{
    $sql = "SELECT lop.HocPhi , hdhocphi.MaHS, MaHD, TenHD, hdhocphi.MaLop,  hdhocphi.ThoiGian, SoTien, GiamHocPhi, SoTienGiam, SoTienPhaiDong, SoTienDaDong, NoPhiConLai, hdhocphi.TrangThai, hocsinh.TenHS, hocsinh.GioiTinh, hocsinh.NgaySinh, hocsinh.Tuoi, hocsinh.DiaChi, hocsinh.SDT, hocsinh.Email FROM hdhocphi INNER JOIN hocsinh INNER JOIN ph_hs INNER JOIN lop WHERE hdhocphi.MaHS = hocsinh.MaHS AND hdhocphi.MaHS = ph_hs.MaHS and hdhocphi.MaLop= lop.MaLop AND ph_hs.MaPH = ? AND (MaHD LIKE ? OR TenHD LIKE ? OR hdhocphi.ThoiGian LIKE ? OR hdhocphi.TrangThai LIKE ? OR hocsinh.TenHS LIKE ? OR hdhocphi.MaLop LIKE ?) order by MaHD desc";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $maph);
        $keyParam = "%$key%";
        $statement->bindParam(2, $keyParam);
        $statement->bindParam(3, $keyParam);
        $statement->bindParam(4, $keyParam);
        $statement->bindParam(5, $keyParam);
        $statement->bindParam(6, $keyParam);
        $statement->bindParam(7, $keyParam);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}