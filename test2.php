<!DOCTYPE html>
<html>
<head>
    <title>Thông tin lớp học</title>
    <style>
        /* CSS để tạo giao diện */
        #class-on  {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .class {
            flex-basis: calc(33.33% - 20px);
            margin: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .class:hover {
            transform: scale(1.02);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .class h2, .class h3, .class p {
            margin: 10px 0;
        }

        .class table {
            width: 100%;
        }

        .class td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <div id="class-on">
        <div class="class">
            <?php
            // Dữ liệu lớp học
            $maLop = "L01";
            $tenLop = "Lớp A";
            $soHocSinh = 30;
            $soBuoiDaDay = 15;
            $thoiGian = "08:00 AM - 10:00 AM";
            $luong = "1.500.000 VND";
            ?>

            <h2>Mã lớp: <?php echo $maLop; ?></h2>
            <h3>Tên lớp: <?php echo $tenLop; ?></h3>
            <table>
                <tr>
                    <td><p>Số học sinh: </p></td>
                    <td><?php echo $soHocSinh; ?></td>
                </tr>
                <tr>
                    <td><p>Số buổi đã dạy: </p></td>
                    <td><?php echo $soBuoiDaDay; ?></td>
                </tr>
                <tr>
                    <td><p>Thời gian:</p></td>
                    <td><?php echo $thoiGian; ?></td>
                </tr>
                <tr>
                    <td><p>Lương:</p></td>
                    <td><?php echo $luong; ?></td>
                </tr>
            </table>
        </div>
        <div class="class">
            <?php
            // Dữ liệu lớp học
            $maLop = "L01";
            $tenLop = "Lớp A";
            $soHocSinh = 30;
            $soBuoiDaDay = 15;
            $thoiGian = "08:00 AM - 10:00 AM";
            $luong = "1.500.000 VND";
            ?>

            <h2>Mã lớp: <?php echo $maLop; ?></h2>
            <h3>Tên lớp: <?php echo $tenLop; ?></h3>
            <table>
                <tr>
                    <td><p>Số học sinh: </p></td>
                    <td><?php echo $soHocSinh; ?></td>
                </tr>
                <tr>
                    <td><p>Số buổi đã dạy: </p></td>
                    <td><?php echo $soBuoiDaDay; ?></td>
                </tr>
                <tr>
                    <td><p>Thời gian:</p></td>
                    <td><?php echo $thoiGian; ?></td>
                </tr>
                <tr>
                    <td><p>Lương:</p></td>
                    <td><?php echo $luong; ?></td>
                </tr>
            </table>
        </div>
        <div class="class">
            <?php
            // Dữ liệu lớp học
            $maLop = "L01";
            $tenLop = "Lớp A";
            $soHocSinh = 30;
            $soBuoiDaDay = 15;
            $thoiGian = "08:00 AM - 10:00 AM";
            $luong = "1.500.000 VND";
            ?>

            <h2>Mã lớp: <?php echo $maLop; ?></h2>
            <h3>Tên lớp: <?php echo $tenLop; ?></h3>
            <table>
                <tr>
                    <td><p>Số học sinh: </p></td>
                    <td><?php echo $soHocSinh; ?></td>
                </tr>
                <tr>
                    <td><p>Số buổi đã dạy: </p></td>
                    <td><?php echo $soBuoiDaDay; ?></td>
                </tr>
                <tr>
                    <td><p>Thời gian:</p></td>
                    <td><?php echo $thoiGian; ?></td>
                </tr>
                <tr>
                    <td><p>Lương:</p></td>
                    <td><?php echo $luong; ?></td>
                </tr>
            </table>
        </div>


        <div class="class">
            <?php
            // Dữ liệu lớp học
            $maLop = "L01";
            $tenLop = "Lớp A";
            $soHocSinh = 30;
            $soBuoiDaDay = 15;
            $thoiGian = "08:00 AM - 10:00 AM";
            $luong = "1.500.000 VND";
            ?>

            <h2>Mã lớp: <?php echo $maLop; ?></h2>
            <h3>Tên lớp: <?php echo $tenLop; ?></h3>
            <table>
                <tr>
                    <td><p>Số học sinh: </p></td>
                    <td><?php echo $soHocSinh; ?></td>
                </tr>
                <tr>
                    <td><p>Số buổi đã dạy: </p></td>
                    <td><?php echo $soBuoiDaDay; ?></td>
                </tr>
                <tr>
                    <td><p>Thời gian:</p></td>
                    <td><?php echo $thoiGian; ?></td>
                </tr>
                <tr>
                    <td><p>Lương:</p></td>
                    <td><?php echo $luong; ?></td>
                </tr>
            </table>
        </div>
        <div class="class">
            <?php
            // Dữ liệu lớp học
            $maLop = "L01";
            $tenLop = "Lớp A";
            $soHocSinh = 30;
            $soBuoiDaDay = 15;
            $thoiGian = "08:00 AM - 10:00 AM";
            $luong = "1.500.000 VND";
            ?>

            <h2>Mã lớp: <?php echo $maLop; ?></h2>
            <h3>Tên lớp: <?php echo $tenLop; ?></h3>
            <table>
                <tr>
                    <td><p>Số học sinh: </p></td>
                    <td><?php echo $soHocSinh; ?></td>
                </tr>
                <tr>
                    <td><p>Số buổi đã dạy: </p></td>
                    <td><?php echo $soBuoiDaDay; ?></td>
                </tr>
                <tr>
                    <td><p>Thời gian:</p></td>
                    <td><?php echo $thoiGian; ?></td>
                </tr>
                <tr>
                    <td><p>Lương:</p></td>
                    <td><?php echo $luong; ?></td>
                </tr>
            </table>
        </div>
        <div class="class">
            <?php
            // Dữ liệu lớp học
            $maLop = "L01";
            $tenLop = "Lớp A";
            $soHocSinh = 30;
            $soBuoiDaDay = 15;
            $thoiGian = "08:00 AM - 10:00 AM";
            $luong = "1.500.000 VND";
            ?>

            <h2>Mã lớp: <?php echo $maLop; ?></h2>
            <h3>Tên lớp: <?php echo $tenLop; ?></h3>
            <table>
                <tr>
                    <td><p>Số học sinh: </p></td>
                    <td><?php echo $soHocSinh; ?></td>
                </tr>
                <tr>
                    <td><p>Số buổi đã dạy: </p></td>
                    <td><?php echo $soBuoiDaDay; ?></td>
                </tr>
                <tr>
                    <td><p>Thời gian:</p></td>
                    <td><?php echo $thoiGian; ?></td>
                </tr>
                <tr>
                    <td><p>Lương:</p></td>
                    <td><?php echo $luong; ?></td>
                </tr>
            </table>
        </div>
  
</body>
</html>
