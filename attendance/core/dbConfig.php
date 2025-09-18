<?php
    class Database {
        protected $pdo;

        public function __construct() {
            $host = "localhost";
            $db = "year4_prelim_attendance";
            $user = "root";
            $pass = "";
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            try {
                $this->pdo = new PDO($dsn, $user, $pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                date_default_timezone_set("Asia/Manila");
                $this->pdo->exec("SET time_zone = '+08:00'");
            } catch (PDOException $e) {
                die("DB CONNECTION FAILED: " . $e->getMessage());
            }
        }


        /* --- CRUD --- */
        public function create($table, $data) {
            $keys = array_keys($data);
            $fields = implode(', ', $keys);
            $placeholders = ':' . implode(', :', $keys);

            $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            if ($stmt->execute()) {
                return "Success";
            }
        }

        public function read($table, $where, $whereParams = []) {
            $sql = "SELECT * FROM $table WHERE $where";

            $stmt = $this->pdo->prepare($sql);

            foreach ($whereParams as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function readAll($table, $where = '', $whereParams = []) {
            $sql = "SELECT * FROM $table";

            if (!empty($where)) {
                $sql .= " WHERE $where";
            }

            $stmt = $this->pdo->prepare($sql);

            foreach ($whereParams as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function update($table, $data, $where, $whereParams = []) {
            $setClause = [];

            foreach ($data as $field => $value) {
                $setClause[] = "$field = :$field";
            }

            $setClause = implode(', ', $setClause);

            $sql = "UPDATE $table SET $setClause WHERE $where";
            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            foreach ($whereParams as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            return $stmt->execute();
        }

        public function delete($table, $where, $whereParams = []) {
            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $this->pdo->prepare($sql);

            foreach ($whereParams as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            $stmt->execute();
            return $stmt->rowCount();
        }


        /* --- INPUT SECURITY --- */
        public function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        public function validatePassword($password) {
            if (strlen($password) > 8) { // longer than 8 char
                $hasLower = false;
                $hasUpper = false;
                $hasNumber = false;

                for ($i = 0; $i < strlen($password); $i++) {
                    if (ctype_lower($password[$i])) { // has lower case
                        $hasLower = true; 
                    }
                    elseif (ctype_upper($password[$i])) { // has upper case
                        $hasUpper = true; 
                    }
                    elseif (ctype_digit($password[$i])) { // has numbers
                        $hasNumber = true;
                    }
                    
                    if ($hasLower && $hasUpper && $hasNumber) {
                        return true; 
                    }
                }
            } else {
                return false; 
            }
        }


        /* --- SESSION CONTROL --- */
        public function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
        
        public function logout() {
            $this->startSession();
            session_unset();
            session_destroy();
        }
    }
?>