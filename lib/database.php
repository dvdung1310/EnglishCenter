<?php
define("DATABASE_SEVER","localhost");
define("DATABASE_USER","root");
define("DATABASE_PASSWORD","");
define("DATABASE_NAME","englishCenter");
$connection = null ;
    try{
        $connection = new PDO(
            "mysql:host=".DATABASE_SEVER.";dbname=".DATABASE_NAME,DATABASE_USER,DATABASE_PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "";
    }catch(PDOException $e){
      echo "failed" . $e->getMessage();
      $connection = null ;
    }

   
?>