<?php 
/**
* Validation
*
* @category   Login Script
* @package    EIS - CS619
* @version    1.0
* @since      Available since Release 1.0
*/


require_once '../initialize.php';
if(isset($_POST['login'])){

  //getting the instance of Database Connection
global $link;

    // retrieve the values submitted via the form
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $pwd = $_POST['pwd'];

      $query = $link->prepare("SELECT * FROM `user_accounts` WHERE username=:username");
      $query->bindParam(":username", $username, PDO::PARAM_STR);

      if($query->execute()){
        if($query->rowCount() == 1){
          if($row= $query->fetch()){

            $id= $row['id'];
            $username= $row['username'];
            $hashed_password= $row['password_hash'];
            $accessLevel= $row['access_level'];

            if(password_verify($pwd, $hashed_password)){

             // successful login
             after_successful_login($id, $username, $accessLevel);
             redirect_to($dashboardURL);

             }else{
               $_SESSION['error']= "Invalid Credentials";
              redirect_to($loginURL);
             }
           }
         }

          else{
            $_SESSION['error']= "Invalid Credentials";
            redirect_to($loginURL);
          }


        } 
    

    

    }
      

    
  
    

?>