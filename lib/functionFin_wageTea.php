<?php


$path_dir = __DIR__ . '/../lib';

include $path_dir . '/database.php';
// select danh sách hoa don
// function listBill($connection)
// {
//     $sql = "select * from hdhocphi";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }


// // select danh sách hoc sinh
// function listStudent($connection)
// {
//     $sql = "select * from hocsinh";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }


// //select danh sách lớp "Đang mở"
// function listClassOpen($connection)
// {
//     $sql = "SELECT * FROM `lop` WHERE TrangThai = \"Đang mở\";";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }


// // Select số buổi điểm danh

// function attendOfMonth($connection, $month, $year)
// {
//     $begin = date("$year-$month-01");

//     $finish = date("Y-m-t", strtotime($begin));


//     $sql = 'SELECT MaLop, MaHS, COUNT(*) AS "SoBuoiDiemDanh" FROM diemdanh WHERE ThoiGian BETWEEN "2023-05-01" AND "2023-05-31" and dd = true GROUP BY MaLop, MaHS';
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $statement->bindParam(1, $begin);
//         $statement->bindParam(2, $finish);

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

// // insert hdhocpho
// function insertHDHocPhi($connection, $tenHD, $maLop, $maHS, $ThoiGian, $SoTien, $GiamHocPhi, $SoTienGiam, $SoTienPhaiDong)
// {
//     $s = 'Chưa đóng';
//     $sql = "insert into  hdhocphi (TenHD, MaLop, MaHS, ThoiGian, SoTien, GiamHocPhi, SoTienGiam, SoTienPhaiDong, NoPhiConLai,TrangThai) values(?,?,?,?,?,?,?,?,?,?)";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);

//         $statement->bindParam(1, $tenHD);
//         $statement->bindParam(2, $maLop);
//         $statement->bindParam(3, $maHS);
//         $statement->bindParam(4, $ThoiGian);
//         $statement->bindParam(5, $SoTien);
//         $statement->bindParam(6, $GiamHocPhi);
//         $statement->bindParam(7, $SoTienGiam);
//         $statement->bindParam(8, $SoTienPhaiDong);
//         $statement->bindParam(9, $SoTienPhaiDong);
//         $statement->bindParam(10, $s);
//         $statement->execute();


//         $connection = null;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

// // select hocPhiHS
// function selecths_hocPhi($connection)
// {
//     $sql = "SELECT MaHS , hs_lop.MaLop , GiamHocPhi , lop.HocPhi  FROM hs_lop INNER JOIN lop WHERE hs_lop.MaLop =  lop.MaLop;";

//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $list = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

//search  LuongGV x giaovien
function searchLuongGV($connection, $key)
{
    $sql = "SELECT luonggv.MaGV , MaLuong, TenHD ,ThoiGian, Lop,ThoiGianTT, SoTien, TrangThai, giaovien.TenGV, giaovien.TenGV, giaovien.GioiTinh, giaovien.NgaySinh, giaovien.Tuoi, giaovien.QueQuan, giaovien.DiaChi, giaovien.TrinhDo, giaovien.SDT, giaovien.Email  FROM luonggv INNER JOIN giaovien WHERE luonggv.MaGV =  giaovien.MaGV and
         (MaLuong like :key or luonggv.MaGV like :key or giaovien.TenGV like :key or ThoiGian like :key or ThoiGianTT like :key or Lop like :key  or TenHD like :key)";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
        $statement->execute();

        $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//select  gv_lop x lop

function select_gv_LopxLop($connection)
{
    $sql = "SELECT gv_lop.MaLop , MaGV, TienTraGV, lop.TenLop, lop.LuaTuoi, lop.ThoiGian, lop.SLHS, lop.SLHSToiDa, lop.HocPhi,lop.SoBuoi,lop.SoBuoiDaToChuc,lop.TrangThai  FROM gv_lop INNER JOIN lop WHERE gv_lop.MaLop = lop.MaLop AND lop.TrangThai = 'Đang mở';";
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

function select_gv_LopxDD($connection)
{
    $sql = "SELECT gv_lop.MaGV ,giaovien.TenGV ,gv_lop.MaLop , b2.ThoiGian FROM gv_lop INNER JOIN (SELECT DISTINCT MaLop , ThoiGian FROM diemdanh)b2 INNER JOIN giaovien WHERE gv_lop.MaLop = b2.MaLop AND gv_lop.MaGV = giaovien.MaGV;";
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

// select so buoi day

function selectSoBuoiDay($connection, $month, $year,$magv)
{
    $begin = date("$year-$month-01");

    $finish = date("Y-m-t", strtotime($begin));

    $sql = 'SELECT gv_lop.MaGV ,gv_lop.MaLop ,gv_lop.TienTraGV,count(DISTINCT b2.ThoiGian) "SoBuoiDay" FROM gv_lop INNER JOIN (SELECT DISTINCT MaLop , ThoiGian FROM diemdanh)b2 INNER JOIN giaovien WHERE gv_lop.MaLop = b2.MaLop and gv_lop.MaGV = ? AND b2.ThoiGian BETWEEN ? AND ? group By gv_lop.MaGV , gv_lop.MaLop, gv_lop.TienTraGV;';
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $connection->prepare($sql);
        $statement->bindParam(2, $begin);
        $statement->bindParam(3, $finish);
        $statement->bindParam(1, $magv);
        $statement->execute();

        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        $connection = null;
        return $list;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

// insert Luong gv
function insertluongGV($connection, $tenHD, $magv, $lop, $tg, $st)
{
    $s = 'Chưa thanh toán';
    $sql = "insert into  luonggv (TenHD, MaGV, Lop, ThoiGian, SoTien, TrangThai) values(?,?,?,?,?,?)";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $tenHD);
        $statement->bindParam(2, $magv);
        $statement->bindParam(3, $lop);
        $statement->bindParam(4, $tg);
        $statement->bindParam(5, $st);
        $statement->bindParam(6, $s);

        $statement->execute();


        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//select danhs sach giao vien
function selectTeacher($connection)
{
    $sql = "select * from giaovien";
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


// update trang thai luonggv
function updateStatusLuonggv($connection, $tt, $tg,$mal)
{

    $sql = "update luonggv set  TrangThai = ?  , ThoiGianTT = ? where MaLuong = ?";
    try {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);

        $statement->bindParam(1, $tt);
        $statement->bindParam(2, $tg);
        $statement->bindParam(3, $mal);


        $statement->execute();

        $connection = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

 //Xoa hoa don hoc phi
function deleteLuongGV($connection, $mahd)
{
    $sql = "delete from luonggv where MaLuong = ?";
    try {
        $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement =  $connection->prepare($sql);
        $statement-> execute([$mahd]);
        $connection = null;
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


// select hs_lop hocsinh
// function lisths_lopxHS($connection)
// {
//     $sql = "SELECT hs_lop.MaHS , MaLop , hocsinh.TenHS, hocsinh.GioiTinh,hocsinh.NgaySinh, hocsinh.Tuoi, hocsinh.DiaChi, hocsinh.SDT, hocsinh.Email FROM hs_lop INNER JOIN hocsinh WHERE hs_lop.MaHS = hocsinh.MaHS;";

//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

// function updateHoaDonHocPhi($connection, $tenhd, $tg, $tt, $mahd)
// {

//     $sql = "update hdhocphi set TenHD = ? , ThoiGian = ? , TrangThai = ?  where MaHD = ?";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);

//         $statement->bindParam(1, $tenhd);
//         $statement->bindParam(2, $tg);
//         $statement->bindParam(3, $tt);
//         $statement->bindParam(4, $mahd);

//         $statement->execute();

//         $connection = null;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

//  //Xoa hoa don hoc phi
// function deleteHDHocPhi($connection, $mahd)
// {
//     $sql = "delete from hdhocphi where MaHD = ?";
//     try {
//         $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement-> execute([$mahd]);
//         $connection = null;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }

// }

//  //Xoa ls thu hoc phi
//  function deleteLSTHPbyMaHD($connection, $mahd)
//  {
//      $sql = "delete from lsthp where MaHD = ?";
//      try {
//          $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//          $statement =  $connection->prepare($sql);
//          $statement-> execute([$mahd]);
//          $connection = null;
//      } catch (PDOException $e) {
//          echo $e->getMessage();
//      }

//  }
//  //select lsthp
//  function listLSTHP($connection)
// {
//     $sql = "select * from lsthp";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute();

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }
// //insert lsthp

// function insertlsthp($mahd, $tg ,$st, $connection)
// {
//     $sql = "insert into lsthp(MaHD,ThoiGian,SoTien) values (?,?,?)";
//     try {
//         $statement = $connection->prepare($sql);
        
//         $statement->bindParam(1, $mahd);
//         $statement->bindParam(2, $tg);
//         $statement->bindParam(3, $st);
//         $statement->execute();
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

// // select sotienphaiDong , so Tien da Dong no Phi con lai
// function selectSTPD_NPCL($connection,$mahd)
// {
//     $sql = "select MaHD , SoTienPhaiDong  , SoTienDaDong , NoPhiConLai from hdhocphi  where MaHD = ?";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute([$mahd]);

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

// // update hoadon thu hoc phi khi them giao dich
// function updateHDTHP_addLSTHP($connection, $stdd, $npcl,$tt , $mahd)
// {

//     $sql = "update hdhocphi set  SoTienDaDong = ? , NoPhiConLai = ? , TrangThai = ?  where MaHD = ?";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);

        
//         $statement->bindParam(1, $stdd);
//         $statement->bindParam(2, $npcl);
//         $statement->bindParam(3, $tt);
//         $statement->bindParam(4, $mahd);

//         $statement->execute();

//         $connection = null;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }



// // update lsthp

// function updateLSTHP($connection, $tg, $st,$magd)
// {

//     $sql = "update lsthp set  ThoiGian = ? ,SoTien = ?   where MaGD = ?";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);

        
//         $statement->bindParam(1, $tg);
//         $statement->bindParam(2, $st);
//         $statement->bindParam(3, $magd);
  

//         $statement->execute();

//         $connection = null;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }  
// //  
// function selectLSTHPbyMaHD($connection,$mahd)
// {
//     $sql = "select MaHD , MaGD from lsthp  where MaHD = ?";
//     try {
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement->execute([$mahd]);

//         $list  = $statement->fetchAll(PDO::FETCH_ASSOC);

//         $connection = null;
//         return $list;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }
// }

// //
// function deleteLSTHPbyMaGD($connection, $magd)
// {
//     $sql = "delete from lsthp where MaGD = ?";
//     try {
//         $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $statement =  $connection->prepare($sql);
//         $statement-> execute([$magd]);
//         $connection = null;
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }

// }




