<?php
require_once(APP_ROOT . "/modal/initialize.php");

class Employee{
    
    protected function getEmployeesList(){
        global $link;
    
        $query= $link->prepare("SELECT * FROM `employees`");
        $query->execute();
      
        while($row= $query->fetch()){
        
        $id= $row['id'];
        $employeeID= $row['employeeID'];
        $full_name= $row['full_name'];
        $designation= $row['designation'];
        $department= $row['department'];

    
       echo "<tr class='odd gradeX'>
        <td>$employeeID</td>
        <td>$full_name</td>
        <td>$designation</td>
        <td>$department</td>
        <td><button data-id='$id' class='userinfo icon-color'><i class='fa fa-plus'></i></button>
        </td>
    </tr>";
    
      }
      //$result= array("barcode"=>"$barcode", "item_name"=>"$item_name", "description"=>"$description", "catagory"=>"$catagory", "unit_purchase_cost"=>"$unit_purchase_cost", "unit_selling_price"=>"$unit_selling_price", "tax_group"=>"$tax_group", "posted_by"=>"$posted_by", "status"=>"$status");
    
      //dispose the db connection.
      $link= NULL;
    }

    protected function getUserData($username){
        global $link;
    
        $query= $link->prepare("SELECT * FROM `user_accounts` WHERE username= :username");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->execute();
      
        while($row= $query->fetch()){
        
        $id= $row['id'];
        $user= $row['username'];
        $full_name= $row['full_name'];
        $designation= $row['designation'];
        $contact= $row['contact_no'];
      
      }
      $result= array("id"=>"$id", "username"=>"$user", "full_name"=>"$full_name","designation"=> "$designation", "contact"=>"$contact");
      return $result;
    
      //dispose the db connection
      $link= NULL;
    
      }


      protected function getUserDetails($userID){
        global $link;
    
        $query= $link->prepare("SELECT * FROM `user_accounts` WHERE id= :id");
        $query->bindParam(":id", $userID, PDO::PARAM_STR);
        $query->execute();
      
        while($row= $query->fetch()){
        
        $id= $row['id'];
        $username= $row['username'];
        $contact= $row['contact_no'];
        $email= $row['email'];
        $access_level= $row['access_level'];
        $account_status= $row['account_status'];
      
      }

      $stmt= $link->prepare("SELECT * FROM `employees` WHERE username= :username");
      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
      $stmt->execute();

      //check if employee record is available, if not then return the custom reply.
      if($stmt->rowCount() < 1){
        $result= "No record found";
      }else{

        while($row2= $stmt->fetch()){
          $employeeID= $row2['employeeID'];
          $full_name= $row2['full_name'];
          $education= $row2['education'];
          $department= $row2['department'];
          $designation= $row2['designation'];
          $pay_scale= $row2['pay_scale'];
          $basic_salary= $row2['basic_salary'];
          $allowances= $row2['allowances'];
          $profile_picture= $row2['profile_picture'];
          $registered_by= $row2['registered_by'];
          $registered_at= $row2['registered_at'];
          $last_edit_by= $row2['last_edit_by'];
          $last_edit_at= $row2['last_edit_at'];
        }

      $result= array("id"=>"$id", "username"=>"$username", "employeeID" => "$employeeID", "full_name"=>"$full_name", 
      "education" => "$education", "department" => "$department", "designation"=> "$designation", "pay_scale" => "$pay_scale", 
      "basic_salary" => "$basic_salary", "allowances" => "$allowances", "profile_picture" => "$profile_picture","registered_by" => "$registered_by" ,
      "registered_at" => "$registered_at", "last_edit_by" => "$last_edit_by", "last_edit_at" => "$last_edit_at","contact_no"=>"$contact",
      "email" => "$email", "access_level" => "$access_level", "account_status" => "$account_status");
      }
      return $result;
    
      //dispose the db connection
      $link= NULL;
    
      }
      
}
?>