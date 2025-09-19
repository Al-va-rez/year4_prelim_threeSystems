<?php

require_once "../core/dbConfig.php";

class Enrollment extends Database {
    public $table = "enrollment";

    public function getEnrollment($username) {
        return $this->readAll($this->table, "student_username = :student_username", ["student_username" => $username]);
    }

    public function enrollToCourse($data) {
        return $this->create($this->table, $data);
    }
}

?>