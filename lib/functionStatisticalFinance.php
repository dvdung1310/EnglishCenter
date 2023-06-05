<?php


$path_dir = __DIR__ . '/../lib';

include $path_dir . '/database.php';


// // select so luong nguoi dung
function listCountThu($connection)
{
    $sql = 'SELECT month(ThoiGian) as "Thang" , year(ThoiGian) as "Nam" , SUM(SoTien) as "SoTien" FROM lsthp GROUP BY month(ThoiGian) , year(ThoiGian);';
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

// // select so luong hs lien ket/ tong hs
function listCountChi($connection)
{
    $sql = 'SELECT b1.Thang , b1.Nam , sum(b1.SoTien) as "SoTien" FROM (SELECT month(ThoiGianTT) as "Thang" , year(ThoiGianTT) as "Nam" , SUM(SoTien) as "SoTien" FROM luonggv WHERE TrangThai = "Đã thanh toán" GROUP BY month(ThoiGianTT) , year(ThoiGianTT) UNION SELECT month(ThoiGianTT) as "Thang" , year(ThoiGianTT) as "Nam" , SUM(SoTien) as "SoTien" FROM chiphikhac WHERE TrangThai = "Đã thanh toán" GROUP BY month(ThoiGianTT) , year(ThoiGianTT))b1 GROUP BY b1.Thang , b1.Nam;';
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

// // select doanh thu theo tung thang
function listDTTheoThang($connection)
{
    $sql = 'SELECT Thang, Nam, SUM(SoTien) AS SoTien FROM ( SELECT Thang, Nam, SUM(SoTien) AS SoTien FROM ( SELECT month(ThoiGian) AS Thang, year(ThoiGian) AS Nam, SUM(SoTien) AS SoTien FROM lsthp GROUP BY month(ThoiGian), year(ThoiGian) UNION ALL SELECT month(ThoiGianTT) AS Thang, year(ThoiGianTT) AS Nam, -SUM(SoTien) AS SoTien FROM ( SELECT ThoiGianTT, SoTien FROM luonggv WHERE TrangThai = "Đã thanh toán" UNION ALL SELECT ThoiGianTT, SoTien FROM chiphikhac WHERE TrangThai = "Đã thanh toán" ) AS b2 GROUP BY month(ThoiGianTT), year(ThoiGianTT) ) AS t GROUP BY Thang, Nam ) AS result GROUP BY Thang, Nam;';
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

// // select thu theo nam
function listThuTheoNam($connection)
{
    $sql = 'SELECT year(ThoiGian) as "Nam" , SUM(SoTien) as "SoTien" FROM lsthp GROUP BY year(ThoiGian);';
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

// // select chi theo nam
function listChiTheoNam($connection)
{
    $sql = 'SELECT  b1.Nam , sum(b1.SoTien) as "SoTien" FROM (SELECT month(ThoiGianTT) as "Thang" , year(ThoiGianTT) as "Nam" , SUM(SoTien) as "SoTien" FROM luonggv WHERE TrangThai = "Đã thanh toán" GROUP BY month(ThoiGianTT) , year(ThoiGianTT) UNION SELECT month(ThoiGianTT) as "Thang" , year(ThoiGianTT) as "Nam" , SUM(SoTien) as "SoTien" FROM chiphikhac WHERE TrangThai = "Đã thanh toán" GROUP BY month(ThoiGianTT) , year(ThoiGianTT))b1 GROUP BY  b1.Nam;';
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

