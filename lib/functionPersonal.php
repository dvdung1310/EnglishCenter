<?php

    
    $path_dir = __DIR__.'/../lib';

    include $path_dir.'/database.php';


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

    function selectAcountTeacher($connection,$ma){
        $sql = "select * from tk_gv where MaGV = ?";
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

    // update mat khau tk gv
    function updatePassGV($connection,$username,$pass){

        $sql = "update tk_gv set Password = ? where  UserName= ?";
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


    // select tt hoc vien

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

    function selectAcountStudent($connection,$ma){
        $sql = "select * from tk_hs where MaHS = ?";
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

    // update mat khau tk hs 
    function updatePassHS($connection,$username,$pass){

        $sql = "update tk_hs set Password = ? where  UserName = ?";
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

///////////////////////////////
    // select tt phu huynh

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

    function selectAcountParent($connection,$ma){
        $sql = "select * from tk_ph where MaPH = ?";
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

     // update phu huynh

     function updateParentbyID($connection,$MaPH,$ten,$gt,$ns,$tuoi,$dc,$sdt,$email){

        $sql = "update phuhuynh set TenPH = ? , GioiTinh = ? , NgaySinh = ?, Tuoi= ?, DiaChi = ?, SDT = ? ,  Email = ?  where MaPH = ?";
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
            $statement->bindParam(8, $MaPH);
          
            $statement-> execute();
           
            $connection = null;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    // update mat khau tk hoc vien
    function updatePassPH($connection,$username,$pass){

        $sql = "update tk_ph set Password = ? where  UserName = ?";
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