<?php
require_once "../core/classLoaders.php";

echo "hello student of Year " . $_SESSION['year_level'];

$courses = $obj_Course->getAll();
$enrollment = $obj_Enrollment->getEnrollment($_SESSION['username']);
$attendance = $obj_Attendance->getAttendance($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    <button type="button" onclick="location.href='../core/handleForms.php?btn_Logout=1'" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
        Logout
    </button>


    <!-- ENROLLMENT FORM -->
    <h1 class="font-bold text-2xl">Enroll to Course</h1>
    <form id="createEnrollmentForm">

        <input type="hidden" id="formStudentUsername" value="<?= $_SESSION['username'] ?>">

        <label for="courseTitle">Title</label>
        <select id="formCourseTitle" class="border border-black px-3 py-2 w-full" name="courseTitle" required>
            <option value="" disabled selected hidden>Select a course</option>
            <?php foreach($courses as $course): ?>
                <option value="<?= $course['title'] ?>"><?= $course['title'] ?></option>
            <?php endforeach ?>
        </select>

        <button class="px-6 py-2 bg-blue-500 rounded-full text-lg text-white font-semibold hover:bg-blue-700">Enroll</button>
    </form>

    
    <!-- COURSE LIST -->
    <table class="w-full mb-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Course Title</th>
                <th class="border p-2">Date Enrolled</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($enrollment as $e): ?>
                <tr class="text-center">
                    <td class="border p-2"><?= $e['course_title'] ?></td>
                    <td class="border p-2"><?= $e['date_enrolled'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>


    <!-- ATTENDANCE FORM -->
    <h1 class="font-bold text-2xl">File Attendance</h1>
    <form id="createAttendanceForm" class="flex flex-col w-1/2 gap-4 items-center my-4">

        <input type="hidden" id="formStudentUsername" value="<?= $_SESSION['username'] ?>">
        <input type="hidden" id="formYearLevel" value="<?= $_SESSION['year_level'] ?>">

        <div class="flex w-full justify-evenly">
            <select id="formEnrolledCourseTitle" class="border border-black px-3 py-2 w-[42%]" name="courseTitle" required>
                <option value="" disabled selected hidden>Select a course</option>
                <?php foreach($enrollment as $e): ?>
                    <option value="<?= $e['course_title'] ?>"><?= $e['course_title'] ?></option>
                <?php endforeach ?>
            </select>
            
            <select id="formAttendanceStatus" class="border border-black px-3 py-2 w-[42%]" name="attendanceStatus" required>
                <option value="" disabled selected hidden>Please select an option...</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
            </select>
        </div>

        <textarea name="excuseLetter" id="formExcuseLetter" class="w-[90%] border border-black hidden p-2" placeholder="Type valid reson for absence. . ."></textarea>

        <button class="w-1/6 px-4 py-2 bg-blue-500 rounded-full text-lg text-white font-semibold hover:bg-blue-700">Submit</button>
    </form>


    <!-- ATTENDANCE RECORDS -->
    <table class="w-full mb-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Course Title</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Date Filed</th>
                <th class="border p-2">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($attendance as $a): ?>
                <tr class="text-center">
                    <td class="border p-2"><?= $a['id'] ?></td>
                    <td class="border p-2"><?= $a['course_title'] ?></td>
                    <td class="border p-2"><?= $a['attendance_Status'] ?></td>
                    <td class="border p-2"><?= $a['date_filed'] ?></td>
                    <td class="border p-2">
                        <?php if (empty($a['remarks'])): ?>
                            <!-- remove button if excuse letter denied -->
                            <form class="viewExcuseLetter">
                                <input type="hidden" class="letter_StudentName" value="<?= $_SESSION['username'] ?>">
                                <input type="hidden" class="letter_CourseTitle" value="<?= $a['course_title'] ?>">
                                <input type="hidden" class="letter_DateSubmitted" value="<?= $a['date_filed'] ?>">
                                <button class="px-6 py-2 bg-yellow-500 rounded-full text-lg text-white font-semibold hover:bg-yellow-600">View Excuse Letter</button>
                            </form>
                            <?php else: echo $a['remarks'] ?>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>


    <div id="windowExcuseLetter" class="hidden fixed inset-0 bg-gray-200 bg-opacity-100 flex flex-col items-center justify-center z-50 p-8">

        <!-- window -->
        <div class="bg-white border rounded-lg shadow-lg p-6 w-[40%] max-h-[80vh]">

            <!-- header -->
            <div class="flex justify-between w-full">
                <div></div>
                <h2 class="text-3xl font-bold text-center">Excuse Letter</h2>
                <button id="closeExcuseLetter">X</button>
            </div>

            <div id="letterBody"></div>
            
        </div>

    </div>

    <script src="scripts_Student.js"></script>
</html>