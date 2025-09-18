<?php
require_once 'Database.php';
require_once 'User.php';
?>

<?php

class Subcategories extends Database {
    public function getSubcategories($category_title) {
        $sql = "SELECT *, subcategories.created_at AS sub_created_at
                FROM subcategories
                JOIN categories ON categories.category_id = subcategories.main_category_id
                WHERE category_title = ?";
        return $this->executeQuery($sql, [$category_title]);
    }
}

?>