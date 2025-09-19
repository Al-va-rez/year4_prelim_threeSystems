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

    public function getCategoryByID($id) {
        $sql = "SELECT category_title FROM categories WHERE category_id = ?";
        return $this->executeQuerySingle($sql, [$id]);
    }
}

?>