<?php

    require "../lib/functionTeacher.php";
    $stt = $_GET['stt'];
    $teacher = teacherByMaGV($connection,$stt);

    echo json_encode($teacher);

?>