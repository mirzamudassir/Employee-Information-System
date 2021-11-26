<?php
require_once("../modal/initialize.php");

$userControllerObject= new UserController();

if(isset($_POST['date'])){
    $date = $_POST['date'];
    $status= $_POST['status'];

 
    $userControllerObject->getCustomeAttendanceSheet($_SESSION['id'], $date, $status);
 
    
 }

exit;
?>