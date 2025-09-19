<?php
require_once 'Database.php';
require_once 'User.php';
?>

<?php

class Categories extends Database {
    public function createCategory($category_title) {
        $sql = "INSERT INTO categories (category_title) VALUES (?)";
        return $this->executeNonQuery($sql, [$category_title]);
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories";
        return $this->executeQuery($sql);
    }
}

?>