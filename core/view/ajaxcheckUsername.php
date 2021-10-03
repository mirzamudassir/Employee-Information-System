<?php
require_once("../modal/initialize.php");
global $link;

if(isset($_POST['username'])){
    $username = $_POST['username'];
 
    // Check username
    $stmt = $link->prepare("SELECT * FROM `user_accounts` WHERE username='" . $_POST["username"] . "'");
    $stmt->execute();
 
    $response = "<span style='color: green;'>Username is Available.</span>";
    if($stmt->rowCount()>0){
       $response = "<span style='color: red;'>Username is Not Available.</span>";
    }
 
    echo $response;
    exit;
 }

 if(isset($_POST['password'])){
   $password = $_POST['password'];

   // Check password length
   if(strlen($password)<6){
      $response = "<span style='color: red;'>Password should be at least 6 characters long.</span>";
      echo $response;
   }

   
   exit;
}

$link=NULL;

?>