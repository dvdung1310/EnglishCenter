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


     // select giáo viên
     function teacherByMaGV($connection,$magv){
        $sql = "select * from giaovien where MaGV = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$magv]);

            $listTeacher  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listTeacher;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // update giao vien

    function updateTeacherbyID($connection,$magv,$ten,$gt,$ns,$tuoi,$qq,$dc,$td,$sdt,$email){

        $sql = "update giaovien set TenGV = ? , GioiTinh = ? , NgaySinh = ?, Tuoi= ?, QueQuan= ? , DiaChi = ?, TrinhDo = ?, SDT = ? ,  Email = ?  where MaGV = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);

            $statement->bindParam(1, $ten);
            $statement->bindParam(2, $gt);
            $statement->bindParam(3, $ns);
            $statement->bindParam(4, $tuoi);
            $statement->bindParam(5, $qq);
            $statement->bindParam(6, $dc);
            $statement->bindParam(7, $td);
            $statement->bindParam(8, $sdt);
            $statement->bindParam(9, $email);
            $statement->bindParam(10, $magv);
          
            $statement-> execute();
           
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    // insert giao vien

    function insertTeacher($connection,$ten,$gt,$ns,$tuoi,$qq,$dc,$td,$sdt,$email){
        $sql = "insert into  giaovien (TenGV, GioiTinh, NgaySinh, Tuoi, QueQuan, DiaChi, TrinhDo, SDT, Email) values(?,?,?,?,?,?,?,?,?)";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);

            $statement->bindParam(1, $ten);
            $statement->bindParam(2, $gt);
            $statement->bindParam(3, $ns);
            $statement->bindParam(4, $tuoi);
            $statement->bindParam(5, $qq);
            $statement->bindParam(6, $dc);
            $statement->bindParam(7, $td);
            $statement->bindParam(8, $sdt);
            $statement->bindParam(9, $email);
            $statement-> execute();
            $magv = $connection->lastInsertId();

            if ($magv) {
                return $magv;
            } else {
                return null;
            }

            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    //insert tk_gv

    function inserttk_gv($magv, $username ,$pass, $connection)
{
    $sql = "insert into tk_gv values(?,?,?)";
    try {
        $statement = $connection->prepare($sql);
        
        $statement->bindParam(1, $username);
        $statement->bindParam(2, $pass);
        $statement->bindParam(3, $magv);
        $statement->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


    // search Giao vien
    function searchTeacher($connection,$key){
        $sql = "select * from giaovien where MaGV like :key or TenGV like :key or GioiTinh like :key or NgaySinh like :key or Tuoi like :key or QueQuan like :key or  DiaChi like :key or  TrinhDo like :key or  SDT like :key or  Email like :key";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement->bindValue(':key', "%$key%", PDO::PARAM_STR);
            $statement->execute();

            $listTeacher  = $statement-> fetchAll(PDO:: FETCH_ASSOC);

            $connection = null;
            return $listTeacher;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


     // Xoa giao vien
     function deleteTeacher($connection,$magv){
        $sql = "delete from giaovien where MaGV = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$magv]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // Xoa  tai khoan giao vien
    function deletetk_gv($connection,$magv){
        $sql = "delete from tk_gv where MaGV = ?";
        try{
            $connection -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $statement =  $connection->prepare($sql);
            $statement-> execute([$magv]);
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }




?>