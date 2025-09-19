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

        $conditions[] = "student_username = :student_username";
        $params["student_username"] = $student_username;

        $conditions[] = "course_title = :course_title";
        $params["course_title"] = $course_title;

        $conditions[] = "date_submitted = :date_submitted";
        $params["date_submitted"] = $date_submitted;

        $where = implode(" AND ", $conditions);

        return $this->read($this->table, $where, $params);
    }

    public function updateLetterStatus($id, $newStatus) {
        $data = [
            "status" => $newStatus
        ];
        return $this->update($this->table, $data, "id = :id", ["id" => $id]);
    }
}

?>