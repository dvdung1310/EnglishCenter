<?php

    
    $path_dir = __DIR__.'/../lib';

    include $path_dir.'/database.php';
    // select danh sách học viên
    function listStudent($connection){
        $sql = "select * from hocsinh";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute();

            $listStudent  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listStudent;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    //select những lớp mà  học viên học

    function classOfStudent($connection,$MaHS){
        $sql = "select * from hs_lop where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);

            $listClass  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listClass;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


     // select  hoc vien
     function StudentByMaHS($connection,$MaHS){
        $sql = "select * from hocsinh where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);

            $listStudent  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listStudent;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // update hoc vien

    function updateStudentbyID($connection,$MaHS,$ten,$gt,$ns,$tuoi,$dc,$sdt,$email){

        $sql = "update hocsinh set TenHS = ? , GioiTinh = ? , NgaySinh = ?, Tuoi= ?, DiaChi = ?, SDT = ? ,  Email = ?  where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);

            $statement->bindParam(1, $ten);
            $statement->bindParam(2, $gt);
            $statement->bindParam(3, $ns);
            $statement->bindParam(4, $tuoi);
            $statement->bindParam(5, $dc);
            $statement->bindParam(6, $sdt);
            $statement->bindParam(7, $email);
            $statement->bindParam(8, $MaHS);
          
            $statement-> execute();
           
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


 

    // search Hoc vien
    function searchStudent($connection,$key){
        $sql = "select * from hocsinh where MaHS like :key or TenHS like :key or GioiTinh like :key or NgaySinh like :key or Tuoi like :key  or  DiaChi like :key  or  SDT like :key or  Email like :key";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
            $statement->execute();

            $listStudent  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listStudent;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    function deleteNgaydk($connection,$MaHS){
        $sql = "delete from ngaydkhs where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    //
    function deleteLKPHHS($connection,$MaHS){
        $sql = "delete from lienketph_hs where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    function deleteDiemDanh($connection,$MaHS){
        $sql = "delete from diemdanh where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    function deleteHDHP($connection,$MaHS){
        $sql = "delete from hdhocphi where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    

    // truy vấn ma hdhocphi cua lop
function selectMaHD( $connection, $malop)
{
    $sql = "SELECT MaHD FROM  hdhocphi   WHERE MaHS = ?";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$malop]);
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}
/// xoa lsthp

function deleteLSTHP($connection,$mahd)
{
    $sql = "delete  from lsthp where MaHD = ? ";
    try {
        $statement = $connection->prepare($sql);
        $statement->execute([$mahd]);

    } catch (PDOException $e) {
        $e->getMessage();
    }
    return null;
}



     // Xoa hoc vien
     function deleteStudent($connection,$MaHS){
        $sql = "delete from hocsinh where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    // Xoa hs trong ph_hs
    function deleteStudent_ph_hs($connection,$MaHS){
        $sql = "delete from ph_hs where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    

    // Xoa  tai khoan hoc vien
    function deletetk_hs($connection,$MaHS){
        $sql = "delete from tk_hs where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    // select phu huynh cua hoc sinh


    function parentOfStudent($connection,$MaHS){
        $sql = "select * from ph_hs where MaHS = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$MaHS]);

            $list = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $list;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
        // select ds ph_hs cung tt phu huynh
    function listph_hs($connection){
        $sql = " SELECT ph_hs.MaHS , ph_hs.MaPH, phuhuynh.TenPH, phuhuynh.GioiTinh, phuhuynh.NgaySinh , phuhuynh.Tuoi , phuhuynh.DiaChi, phuhuynh.SDT , phuhuynh.Email FROM `ph_hs`INNER JOIN phuhuynh WHERE ph_hs.MaPH = phuhuynh.MaPH;";

        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute();

            $list = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $list;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // select ds hs_lop cung tt lop
    
    function lisths_lop($connection){
        $sql = "SELECT MaHS, lop.MaLop , lop.TenLop, lop.LuaTuoi, lop.ThoiGian, lop.SLHS, lop.SLHSToiDa, lop.HocPhi, lop.SoBuoi, lop.SoBuoiDaToChuc, lop.TrangThai , hs_lop.SoBuoiNghi , hs_lop.GiamHocPhi , giaovien.TenGV FROM `hs_lop` inner JOIN lop INNER JOIN gv_lop INNER JOIN giaovien WHERE hs_lop.MaLop = lop.MaLop AND lop.MaLop = gv_lop.MaLop AND gv_lop.MAGV = giaovien.MaGV order  by TrangThai desc; ";

        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute();

            $list = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $list;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // select tai khoan


    function listtk_hs($connection){

        $sql = "select * from tk_hs ";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute();

            $list = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $list;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // update mat khau tk HS
    function updatePassHS($connection,$username,$pass){

        $sql = "update tk_hs set Password = ? where  UserName= ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);

            $statement->bindParam(1, $pass);
            $statement->bindParam(2, $username);
   
          
            $statement-> execute();
           
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    
    



    




?>


