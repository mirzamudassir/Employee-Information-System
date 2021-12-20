<?php
require_once("../modal/initialize.php");

if(isset($_POST['employeeID'])){

   $employeeID = $_POST['employeeID'];
   $allowance = $_POST['allowance'];
   $query = $_POST['query'];

   //array to string conversion
   $employeeID= $employeeID['1'];
   $allowance= $allowance['1'];
   $query= $query['1'];

   if($query === 'allowance'){

   //remove the allowance
   $stmt= $link->prepare("UPDATE `employees` SET allowances= 
                          CASE 
                          WHEN allowances LIKE '$allowance' THEN ''
                          WHEN allowances LIKE '$allowance%' THEN REPLACE(allowances, '$allowance,', '')
                          WHEN allowances LIKE '$allowance,' THEN REPLACE(allowances, '$allowance,', '')
                          WHEN allowances LIKE '%,%' THEN REPLACE(allowances, ',$allowance', '')
                          END
   WHERE employeeID= :employeeID");
   $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
   $stmt->execute();
   
   }elseif($query === 'deduction'){
      
   //remove the deduction
   $stmt= $link->prepare("UPDATE `employees` SET deductions= 
                           CASE 
                           WHEN deductions LIKE '$allowance' THEN ''
                           WHEN deductions LIKE '$allowance%' THEN REPLACE(deductions, '$allowance,', '')
                           WHEN deductions LIKE '$allowance,' THEN REPLACE(deductions, '$allowance,', '')
                           WHEN deductions LIKE '%,%' THEN REPLACE(deductions, ',$allowance', '')
                           END
   WHERE employeeID= :employeeID");
   $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
   $stmt->execute();
   
   
      }
      
      

}
?>