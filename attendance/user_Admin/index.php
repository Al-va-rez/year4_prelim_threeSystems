<?php

require_once "../core/classLoaders.php";

echo "hello admin";

$courses = $obj_Course->getAll();
$attendances = $obj_Attendance->getAll();
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

    <h1 class="font-bold text-2xl">Create Course</h1>
    <form id="createCourseForm">

        <label for="courseCode">Code</label>
        <input type="text" id="formCourseCode" name="courseCode" class="inputBox" required>
        
        <label for="courseTitle">Title</label>
        <input type="text" id="formCourseTitle" class="inputBox" name="courseTitle" required>
        
        <label for="courseUnits">Units</label>
        <input type="number" id="formCourseUnits" class="inputBox" name="courseUnits" required>

        <button class="px-6 py-2 bg-blue-500 rounded-full text-lg text-white font-semibold hover:bg-blue-700">Create</button>
    </form>

    <!-- COURSE LIST -->
    <h2 class="text-2xl font-bold mb-4">COURSES</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Code</th>
                <th class="border p-2">Title</th>
                <th class="border p-2">Units</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($courses as $course): ?>
                <tr class="text-center">
                    <td class="border p-2"><?= $course['id'] ?></td>
                    <td class="border p-2"><?= $course['code'] ?></td>
                    <td class="border p-2"><?= $course['title'] ?></td>
                    <td class="border p-2"><?= $course['units'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>



    <!-- ATTENDANCE FORM -->
    <h1 class="font-bold text-2xl">Attendance Records</h1>
    <form id="filterAttendanceForm">

        <select id="formEnrolledCourseTitle" class="border border-black px-3 py-2 w-1/5">
            <option value="" disabled selected hidden>Course</option>
            <?php foreach($courses as $course): ?>
                <option value="<?= $course['title'] ?>"><?= $course['title'] ?></option>
            <?php endforeach ?>
        </select>

        <select id="formYearLevel" class="border border-black px-3 py-2 w-1/5" name="attendanceStatus">
            <option value="" disabled selected hidden>Year Level</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        
        <select id="formAttendanceStatus" class="border border-black px-3 py-2 w-1/5" name="attendanceStatus">
            <option value="" disabled selected hidden>Status</option>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select>

        <button class="px-6 py-2 bg-blue-500 rounded-full text-lg text-white font-semibold hover:bg-blue-700">
            Filter
        </button>
        <button type="button" id="clearFilters" class="px-6 py-2 bg-gray-500 rounded-full text-lg text-white font-semibold hover:bg-gray-700">
            Clear
        </button>
    </form>


    <!-- all attendances -->
    <table id="attendanceTable" class="w-full mb-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Year Level</th>
                <th class="border p-2">Student Username</th>
                <th class="border p-2">Course Title</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Date Filed</th>
                <th class="border p-2">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($attendances as $a): ?>
                <tr class="text-center">
                    <td class="border p-2"><?= $a['id'] ?></td>
                    <td class="border p-2"><?= $a['year_level'] ?></td>
                    <td class="border p-2"><?= $a['student_username'] ?></td>
                    <td class="border p-2"><?= $a['course_title'] ?></td>
                    <td class="border p-2"><?= $a['attendance_Status'] ?></td>
                    <td class="border p-2"><?= $a['date_filed'] ?></td>
                    <td class="border p-2"><?= $a['remarks'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <script src="scripts_Admin.js"></script>
</body>
</html>