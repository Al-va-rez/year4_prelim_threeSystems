<?php require_once "../core/dbConfig.php"; ?>

<?php

class ExcuseLetter extends Database {

    protected $table = "excuse_letters";

    public function sendLetter($data) {
        return $this->create($this->table, $data);
    }

    public function getLetter($student_username, $course_title, $date_submitted) {
        $conditions = [];
        $params = [];

        if (!empty($student_username)) {
            $conditions[] = "student_username = :student_username";
            $params["student_username"] = $student_username;
        }

        if (!empty($course_title)) {
            $conditions[] = "course_title = :course_title";
            $params["course_title"] = $course_title;
        }

        if (!empty($date_submitted)) {
            $conditions[] = "date_submitted = :date_submitted";
            $params["date_submitted"] = $date_submitted;
        }

        $where = implode(" AND ", $conditions);

        return $this->read($this->table, $where, $params);
    }
}

?>