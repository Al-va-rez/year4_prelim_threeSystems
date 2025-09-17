<?php

require_once "../core/dbConfig.php";

class Attendance extends Database {
    public $table = "attendances";

    public function getAttendance($student_username) {
        return $this->readAll($this->table, "student_username = :student_username", ["student_username" => $student_username]);
    }

    public function fileAttendance($data) {
        return $this->create($this->table, $data);
    }

    public function getAll() {
        return $this->readAll($this->table);
    }

    public function filterAttendances($course_title = null, $year_level = null, $attendance_Status = null) {
        $conditions = [];
        $params = [];

        if (!empty($course_title)) {
            $conditions[] = "course_title = :course_title";
            $params["course_title"] = $course_title;
        }

        if (!empty($year_level)) {
            $conditions[] = "year_level = :year_level";
            $params["year_level"] = $year_level;
        }

        if (!empty($attendance_Status)) {
            $conditions[] = "attendance_Status = :attendance_Status";
            $params["attendance_Status"] = $attendance_Status;
        }

        $where = implode(" AND ", $conditions);

        return $this->readAll($this->table, $where, $params);
    }
}

?>