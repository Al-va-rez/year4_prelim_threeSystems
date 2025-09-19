<?php
require_once 'Database.php';
require_once 'User.php';
?>

<?php

class Subcategories extends Database {
    public function getSubcategories($main_category_id = null) {
        if ($main_category_id == "") {
            $sql = "SELECT *, subcategories.created_at AS sub_created_at
                    FROM subcategories
                    JOIN categories ON categories.category_id = subcategories.main_category_id";
            return $this->executeQuery($sql);
        } else {
            $sql = "SELECT *, subcategories.created_at AS sub_created_at
                    FROM subcategories
                    JOIN categories ON categories.category_id = subcategories.main_category_id
                    WHERE main_category_id = ?";
            return $this->executeQuery($sql, [$main_category_id]);
        }
    }
}

?>