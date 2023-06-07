<!DOCTYPE html>
<html>
<head>
    <title>Thông tin học sinh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông tin học sinh</h1>
        <table>
            <thead>
                <tr>
                    <th>Họ và tên</th>
                    <th>Lớp</th>
                    <th>Giáo viên</th>
                    <th>Số buổi học</th>
                    <th>Số buổi nghỉ</th>
                    <th>Danh sách buổi nghỉ</th>
                </tr>
            </thead>
            <tbody id="student-table">
            </tbody>
        </table>
    </div>

    <script>
        // Dữ liệu mẫu
        var students = [
            { name: "Nguyễn Văn A", grade: "10A", teacher: "Nguyễn Thị B", attendance: [{ session: 1, present: true }, { session: 2, present: false }, { session: 3, present: true }] },
            { name: "Trần Thị C", grade: "11B", teacher: "Lê Văn D", attendance: [{ session: 1, present: true }, { session: 2, present: true }, { session: 3, present: true }] },
            { name: "Phạm Văn E", grade: "12C", teacher: "Trần Thị F", attendance: [{ session: 1, present: false }, { session: 2, present: false }, { session: 3, present: true }] }
        ];

        // Hiển thị thông tin học sinh
        function displayStudents() {
            var table = document.getElementById("student-table");

            for (var i = 0; i < students.length; i++) {
                var student = students[i];

                var row = document.createElement("tr");

                var nameCell = document.createElement("td");
                nameCell.innerHTML = student.name;
                row.appendChild(nameCell);

                var gradeCell = document.createElement("td");
                gradeCell.innerHTML = student.grade;
                row.appendChild(gradeCell);

                var teacherCell = document.createElement("td");
                teacherCell.innerHTML = student.teacher;
                row.appendChild(teacherCell);

                var totalSessions = student.attendance.length;
                var attendanceCell = document.createElement("td");
                attendanceCell.innerHTML = totalSessions;
                row.appendChild(attendanceCell);

                var absentCount = student.attendance.filter(function (session) {
                    return session.present === false;
                }).length;
                var absentCell = document.createElement("td");
                absentCell.innerHTML = absentCount;
                row.appendChild(absentCell);

                var absentSessionsCell = document.createElement("td");
                var absentSessions = student.attendance.filter(function (session) {
                    return session.present === false;
                }).map(function (session) {
                    return session.session;
                }).join(", ");
                absentSessionsCell.innerHTML = absentSessions;
                row.appendChild(absentSessionsCell);

                table.appendChild(row);
            }
        }

        displayStudents();
    </script>
</body>
</html>
