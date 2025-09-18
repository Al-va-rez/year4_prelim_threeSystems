<?php  
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Categories.php';
require_once 'classes/Subcategories.php';

$databaseObj= new Database();
$userObj = new User();
$categoryObj = new Categories();
$subcategoryObj = new Subcategories();

$userObj->startSession();
?>