<?php  
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Categories.php';
require_once 'classes/Subcategories.php';
require_once 'classes/Offer.php';
require_once 'classes/Proposal.php';

$databaseObj= new Database();
$userObj = new User();
$categoryObj = new Categories();
$subcategoryObj = new Subcategories();
$offerObj = new Offer();
$proposalObj = new Proposal();

$userObj->startSession();
?>