<?php
 include "../lib/database.php";

// danh sách lịch học
 function listSchedules($connection){
    $sql = "SELECT * FROM schedules";
    try{
        $stmt = $connection->query($sql);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }catch(PDOException $e){
        $e->getMessage();
    }
    return null;
 }
// danh sách giáo viên
 function listTeacher($connection){
    $sql = "SELECT * FROM giaovien";
    try{
        $stmt = $connection->query($sql);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }catch(PDOException $e){
        $e->getMessage();
    }
    return null;
 }

 // tạo lớp 
 function CreateClass($MaLop, $TenLop, $LuaTuoi, $ThoiGian,$SLHS,$SLHSToiDa,$HocPhi,$SoBuoi,$SoBuoiDaToChuc,$TrangThai,$connection)
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
function deleteClass($malop,$connection){
    $sql = "delete from lop where MaLop = ?";
    try{
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
    }catch(PDOException $e){
        $e->getMessage();
    }
}
// tạo class_gv
function CreateTeacher_Class($magv,$MaLop,$connection)
{
    $sql = "insert into gv_lop values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $magv);
        $statement->bindParam(2, $MaLop);
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
function CreateSchedules_Class($idSchedules,$MaLop,$connection)
{
    $sql = "insert into schedules_class values(?,?)";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $idSchedules);
        $statement->bindParam(2, $MaLop);
        $SchedulesClass = $statement->execute();
        if ($SchedulesClass){
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

// danh sách lớp học
function listClass($connection){
    $sql = "SELECT * FROM lop";
    try{
        $stmt = $connection->query($sql);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }catch(PDOException $e){
        $e->getMessage();
    }
}

// giáo viên tương ứng với lớp
function teacherByidClass($idClass,$connection){
    $sql = "SELECT magv FROM gv_lop where MaLop = '?' ";
    try{
        
    }catch(PDOException $e){
       
    }
}

// truy vấn dữ liệu ra lịch học với mã lớp
function dataSchedulesByMaLop($malop,$connection){
    $sql = "SELECT schedules.idSchedules, schedules.day_of_week , schedules.start_time , schedules.end_time
    from schedules_class
    INNER JOIN lop on schedules_class.MaLop = lop.MaLop
    INNER JOIN schedules on schedules_class.idSchedules = schedules.idSchedules
    WHERE lop.MaLop = ?;";
    try{
       $statement = $connection->prepare($sql);
       $statement->bindParam(1, $malop);
       $statement->execute();
       $data = $statement->fetchAll(PDO::FETCH_ASSOC);
       return $data;
    }catch(PDOException $e){
       $e->getMessage();
    }
    return null;
}

// truy vấn dữ liệu ra giáo viên với mã lớp
function dataTeacherByMaLop($malop,$connection){
    $sql = "SELECT giaovien.*
    from gv_lop
    INNER JOIN giaovien on gv_lop.MAGV = giaovien.MaGV
    INNER JOIN lop on lop.MaLop = gv_lop.MaLop
    WHERE lop.MaLop = ?;";
    try{
       $statement = $connection->prepare($sql);
       $statement->bindParam(1, $malop);
       $statement->execute();
       $data = $statement->fetchAll(PDO::FETCH_ASSOC);
       return $data;
    }catch(PDOException $e){
       $e->getMessage();
    }
    return null;
}


// truy vấn ra dữ liệu lớp học có trạng thái là 1 ;
function dataClassOn($connection){
    $sql = "select * from lop where trangthai = '0' ";
    try{
       $statement = $connection->prepare($sql);
       $statement->execute();
       $data = $statement->fetchAll(PDO::FETCH_ASSOC);
       return $data;
    }catch(PDOException $e){
       $e->getMessage();
    }
    return null;
}
// Truy vấn ra dữ liệu lớp học từ mã id lớp 
function dataClassById($malop,$connection){
     $sql = "select * from lop where MaLop = ?";
     try{
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $malop);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
     }catch(PDOException $e){
        $e->getMessage();
     }
     return null;
}

// thục hiện xóa lớp (xóa lớp , liên kết lớp vs lịch học , lớp vs giáo viên)
function deleteClassById($malop,$connection){
   $sql1 = "DELETE from gv_lop where MaLop = ?";
   $sql2 = "DELETE from schedules_class where MaLop = ?";
   $sql3 = "DELETE from lop where MaLop = ?";
   try{
    $statement1 = $connection->prepare($sql1);
    $statement2 = $connection->prepare($sql2);
    $statement3 = $connection->prepare($sql3);
    
    $statement1->execute([$malop]);
    $statement2->execute([$malop]);
    $statement3->execute([$malop]);
    return true;
   }catch(PDOException $e){
      $e->getMessage();
   }
   return false;
}
  
?>