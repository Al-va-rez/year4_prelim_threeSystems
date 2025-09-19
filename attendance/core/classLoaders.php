<?php
    require_once "dbConfig.php";
    require_once "../classes/admins.php";
    require_once "../classes/students.php";
    require_once "../classes/attendances.php";
    require_once "../classes/courses.php";
    require_once "../classes/enrollment.php";
    require_once "../classes/excuseLetter.php";

    $obj_Database = new Database();
    $obj_Admin = new Admin();
    $obj_Student = new Student();
    $obj_Attendance = new Attendance();
    $obj_Course = new Course();
    $obj_Enrollment = new Enrollment();
    $obj_ExcuseLetter = new ExcuseLetter();

    
    $obj_Admin->startSession();
    $obj_Student->startSession();
?>