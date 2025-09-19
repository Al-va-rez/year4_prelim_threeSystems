<?php

    require_once "../core/dbConfig.php";
    
    class Student extends Database {
        
        protected $table = "students";

        public function register($data) {
            return $this->create($this->table, $data);
        }

        public function check_UserExists($username) {
            $response = array();

            $userInfo = $this->read($this->table, "username = :username", ["username" => $username]);

            if (!empty($userInfo)) {
                $response = array(
                    "result" => true,
                    "status" => "200",
                    "userInfo" => $userInfo
                );
            } else {
                $response = array(
                    "result" => false,
                    "status" => "400",
                    "message" => "User not found in database"
                );
            }

            return $response;
        }

        public function login($username, $password) {
            $savedData = $this->check_UserExists($username);

            if ($savedData && password_verify($password, $savedData['userInfo']['password'])) {
                $this->startSession();
                $_SESSION['user_id'] = $savedData['userInfo']['id'];
                $_SESSION['username'] = $savedData['userInfo']['username'];
                $_SESSION['year_level'] = $savedData['userInfo']['year_level'];
                return true;
            } else {
                return false;
            }
        }

        public function logout(){
            $this->startSession();
            session_unset();
            session_destroy();
        }
    }
?>