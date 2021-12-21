<?php
require_once("../modal/initialize.php");

if(isset($_POST['date'])){
    
    $date = $_POST['date'];
    $status= $_POST['status'];

    $userControllerObject= new UserController();

    $userControllerObject->getCustomeAttendanceSheet($_SESSION['id'], $date, $status);
 
    
 }

exit;
?>