<?php  
require_once 'classes/Article.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Edit_Request.php';
require_once 'classes/Categories.php';

$databaseObj= new Database();
$userObj = new User();
$articleObj = new Article();
$requestObj = new Edit_Request();
$categoryObj = new Categories();

$userObj->startSession();
?>