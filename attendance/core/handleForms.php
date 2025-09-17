<?php
    require_once 'classLoaders.php';

    
    /* --- USERS --- */
    // register
    if (isset($_POST['registerAdminReq'])) {

        $username = $obj_Admin->sanitizeInput($_POST['username']);
        $firstName = $obj_Admin->sanitizeInput($_POST['firstName']);
        $lastName = $obj_Admin->sanitizeInput($_POST['lastName']);
        $tempPassword = $obj_Admin->sanitizeInput($_POST['password']);
        $confirmPassword = $obj_Admin->sanitizeInput($_POST['confirmPassword']);


        if ($tempPassword == $confirmPassword) {

            if ($obj_Admin->validatePassword($tempPassword)) { // check password strength

                $password = password_hash($tempPassword, PASSWORD_DEFAULT); // encrypt password

                $data = [
                    "username" => $username,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "password" => $password
                ];

                $result = $obj_Admin->register($data);

                echo $result;

            } else {
                echo "Weak password";
            }
        } else {
            echo "Passwords not the same";
        }
        
    }

    if (isset($_POST['registerStudentReq'])) {

        $student_id = $obj_Student->sanitizeInput($_POST['student_id']);
        $year_level = $obj_Student->sanitizeInput($_POST['year_level']);
        $username = $obj_Student->sanitizeInput($_POST['username']);
        $firstName = $obj_Student->sanitizeInput($_POST['firstName']);
        $lastName = $obj_Student->sanitizeInput($_POST['lastName']);
        $tempPassword = $obj_Student->sanitizeInput($_POST['password']);
        $confirmPassword = $obj_Student->sanitizeInput($_POST['confirmPassword']);


        if ($tempPassword == $confirmPassword) {

            if ($obj_Student->validatePassword($tempPassword)) { // check password strength

                $password = password_hash($tempPassword, PASSWORD_DEFAULT); // encrypt password

                $data = [
                    "student_id" => $student_id,
                    "year_level" => $year_level,
                    "username" => $username,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "password" => $password
                ];

                $result = $obj_Student->register($data);

                echo $result;

            } else {
                echo "Weak password";
            }
        } else {
            echo "Passwords not the same";
        }
        
    }

    // login
    if (isset($_POST['loginStudentReq'])) {

        $username = $obj_Student->sanitizeInput($_POST['username']);
        $password = $obj_Student->sanitizeInput($_POST['password']);

        $userExists = $obj_Student->check_UserExists($username);

        if ($userExists['result']) {
            if ($obj_Student->login($username, $password)) {

                echo "Success";

            } else {
                echo "Incorrect Username/Password";
            }
        } else {
            echo "User not registered";
        }
        
    }

    if (isset($_POST['loginAdminReq'])) {

        $username = $obj_Admin->sanitizeInput($_POST['username']);
        $password = $obj_Admin->sanitizeInput($_POST['password']);

        $userExists = $obj_Admin->check_UserExists($username);

        if ($userExists['result']) {
            if ($obj_Admin->login($username, $password)) {

                echo "Success";

            } else {
                echo "Incorrect Username/Password";
            }
        } else {
            echo "User not registered";
        }
        
    }

    // logout
    if (isset($_GET['btn_Logout'])) {
        $obj_Student->logout();
        $obj_Admin->logout();
        header('Location: ../index.php');
    }


    if (isset($_POST['courseReq'])) {
        $code = $obj_Course->sanitizeInput($_POST['courseCode']);
        $title = $obj_Course->sanitizeInput($_POST['courseTitle']);
        $units = $obj_Course->sanitizeInput($_POST['courseUnits']);

        $data = [
            "code" => $code,
            "title" => $title,
            "units" => $units
        ];

        $result = $obj_Course->createCourse($data);

        if ($result) {
            echo "Success";
        } else {
            echo "Something went wrong";
        }
    }


    if (isset($_POST['enrollReq'])) {
        $student_username = $obj_Enrollment->sanitizeInput($_POST['student_username']);
        $course_title = $obj_Enrollment->sanitizeInput($_POST['course_title']);

        $data = [
            "student_username" => $student_username,
            "course_title" => $course_title
        ];

        $result = $obj_Enrollment->enrollToCourse($data);

        if ($result) {
            echo "Success";
        } else {
            echo "Something went wrong";
        }        
    }


    if (isset($_POST['attendanceReq'])) {
        $year_level = $obj_Enrollment->sanitizeInput($_POST['year_level']);
        $student_username = $obj_Enrollment->sanitizeInput($_POST['student_username']);
        $course_title = $obj_Enrollment->sanitizeInput($_POST['course_title']);
        $attendance_Status = $obj_Enrollment->sanitizeInput($_POST['attendance_Status']);
        $excuseLetter = $obj_Enrollment->sanitizeInput($_POST['excuseLetter']);
        

        $remarks = "";
        $currentTime = new DateTime("now");
        $cutoffTime  = new DateTime("today 08:00:00");
        if ($attendance_Status == "Present") {
            $remarks = ($currentTime <= $cutoffTime) ? "On Time" : "Late";
        }


        $attendanceData = [
            "year_level" => $year_level,
            "student_username" => $student_username,
            "course_title" => $course_title,
            "attendance_Status" => $attendance_Status,
            "remarks" => $remarks
        ];

        $result1 = $obj_Attendance->fileAttendance($attendanceData);


        if (!empty($excuseLetter)) {
            $letterData = [
                "student_username" => $student_username,
                "course_title" => $course_title,
                "letter" => $excuseLetter
            ];

            $result2 = $obj_ExcuseLetter->sendLetter($letterData);
        }


        $overall = $result1 || $result2;

        if ($overall) {
            echo "Success";
        } else {
            echo "handleForms issue";
        }        
    }


    if (isset($_POST['filterReq'])) {
        $course = $obj_Attendance->sanitizeInput($_POST['course']);
        $year_level = $obj_Attendance->sanitizeInput($_POST['year_level']);
        $attendance_Status = $obj_Attendance->sanitizeInput($_POST['attendance_Status']);

        $result = $obj_Attendance->filterAttendances($course, $year_level, $attendance_Status);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    if (isset($_POST['getLetterReq'])) {
        $student_username = $obj_ExcuseLetter->sanitizeInput($_POST['student_username']);
        $course_title = $obj_ExcuseLetter->sanitizeInput($_POST['course_title']);
        $date_submitted = $obj_ExcuseLetter->sanitizeInput($_POST['date_submitted']);

        $result = $obj_ExcuseLetter->getLetter($student_username, $course_title, $date_submitted);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

?>