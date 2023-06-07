<?php
// require './lib/funtionUserTeacher.php';

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu điểm danh từ biểu mẫu
    $attendanceData = json_decode($_POST['attendanceData'], true);

    // Hiển thị dữ liệu điểm danh
    echo "<h2>Dữ liệu điểm danh</h2>";
    echo "<table>";
    echo "<thead>";
    echo "<th>STT</th>";
    echo "<th>Mã học viên</th>";
    echo "<th>Tên học viên</th>";
    echo "<th>Điểm danh</th>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($attendanceData as $index => $student) {
        $stt = $index + 1;
        $maHS = $student['maHS'];
        $tenHS = $student['tenHS'];
        $diemDanh = $student['diemDanh'] ? "Có" : "Không";

        echo "<tr>";
        echo "<td>$stt</td>";
        echo "<td>$maHS</td>";
        echo "<td>$tenHS</td>";
        echo "<td>$diemDanh</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Điểm danh học sinh</title>
    <style>
        /* CSS để tạo giao diện */
        body {
            font-family: Arial, sans-serif;
        }

        #attendance {
            text-align: center;
        }

        #attendance th {
            padding: 30px;
            border-bottom-style: ridge;
        }

        /* #attendance tr {

        } */
        #attendance td {
            padding: 10px;
            border-bottom-style: ridge;

        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Điểm danh học sinh</h1>

        <table id="attendance">
            <thead>
                <th>STT</th>
                <th>Mã học viên</th>
                <th>Tên học viên</th>
                <th>Điểm danh</th>
            </thead>
            <tbody id='tbody-listStudtent'>

            </tbody>
        </table>
        <form action="" , method="post">
            <button class="btn" onclick="diemDanh()">Điểm danh</button>
        </form>
    </div>

    <script>
        var ds_hocsinh = [{
            "MaHS": 4,
            "TenHS": "\u0110\u1eb7ng V\u0103n D\u0169ng",

        }, {
            "MaHS": 5,
            "TenHS": "aaa",

        }, {
            "MaHS": 15,
            "TenHS": "long",

        }, {
            "MaHS": 17,
            "TenHS": "hhh1",

        }, {
            "MaHS": 18,
            "TenHS": "hhh14124",

        }, {
            "MaHS": 20,
            "TenHS": "hi\u1ebfu hi\u1ebfu",

        }, {
            "MaHS": 21,
            "TenHS": "124",

        }, {
            "MaHS": 22,
            "TenHS": "Nguyen Van Aaa",

        }, {
            "MaHS": 23,
            "TenHS": "Tran Thi B",

        }, {
            "MaHS": 24,
            "TenHS": "Le Van C",

        }, {
            "MaHS": 25,
            "TenHS": "Pham Thi D",

        }, {
            "MaHS": 26,
            "TenHS": "Tran Van E",

        }, {
            "MaHS": 27,
            "TenHS": "Ho Thi F",

        }, {
            "MaHS": 28,
            "TenHS": "Nguyen Van G",

        }, {
            "MaHS": 29,
            "TenHS": "Le Thi H",

        }, {
            "MaHS": 30,
            "TenHS": "Tran Van I",

        }, {
            "MaHS": 32,
            "TenHS": "Nguyen",

        }];
        var html = '';
        for (var i = 0; i < ds_hocsinh.length; i++) {

            html += '<tr>'
            html += '<td>' + (i + 1) + '</td>';
            html += '<td>' + ds_hocsinh[i].MaHS + '</td>';
            html += '<td>' + ds_hocsinh[i].TenHS + '</td>';
            html += '<td>  <input type="checkbox">  </td>';
            html += '</tr>';

        }
        document.getElementById('tbody-listStudtent').innerHTML = html;

        document.getElementById('sumit-bill-add').addEventListener('click', function (event) {
            //   var check = true;

             event.preventDefault();

            var checkboxes = document.querySelectorAll('#attendance tbody input[type="checkbox"]');
            var attendanceData = [];

            checkboxes.forEach(function(checkbox, index) {
                var maHS = ds_hocsinh[index].MaHS;
                var tenHS = ds_hocsinh[index].TenHS;
                var diemDanh = checkbox.checked;

                attendanceData.push({
                    maHS: maHS,
                    tenHS: tenHS,
                    diemDanh: diemDanh
                });
            });
            var form = document.getElementById('attendanceForm');
            var input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'attendanceData');
            input.setAttribute('value', JSON.stringify(attendanceData));
            form.appendChild(input);


            // form.submit();



    // if (!check)
    //     return;
    // document.getElementById('tb1').innerHTML = "Đã thêm lương giáo viên tháng " + month_bill + "/" + year_bill + " thành công!";

    // document.querySelector('.add-success').style.display = 'block';

    // setTimeout(function () {
    //     document.querySelector('.add-success').style.display = 'none';
    //     form1.submit();
    // }, 1500);
});



    </script>
</body>

</html>
