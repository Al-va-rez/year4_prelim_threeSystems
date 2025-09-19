<?php
require_once 'Database.php';
require_once 'User.php';
?>

<?php

class Categories extends Database {
    public function getCategories() {
        $sql = "SELECT * FROM categories";
        return $this->executeQuery($sql);
    }
}

?>