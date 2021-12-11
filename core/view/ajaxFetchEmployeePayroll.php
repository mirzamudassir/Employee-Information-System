<?php
require_once("../modal/initialize.php");

if(isset($_POST['employeeID'])){

   $employeeID = filter_var($_POST['employeeID'], FILTER_SANITIZE_STRING);

   $stmt= $link->prepare("SELECT * FROM `employees` WHERE employeeID= :employeeID");
   $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
   $stmt->execute();

      if($stmt->rowCount() == 0){
         echo "No data found.";
      }else{
    
      while($row= $stmt->fetch()){
      
      $id= $row['id'];
      $username = $row['username'];
      $employeeID = $row['employeeID'];
      $full_name= $row['full_name'];
      $department= $row['department'];
      $designation = $row['designation'];
      $pay_scale = $row['pay_scale'];
      $allowances = $row['allowances'];
      $deductions= $row['deductions'];
      $profile_picture= $row['profile_picture'];
      
      $stmt2= $link->prepare("SELECT * FROM `designations` WHERE designation_name= :designation");
      $stmt2->bindParam(":designation", $designation, PDO::PARAM_STR);
      $stmt2->execute();
      while($row2= $stmt2->fetch()){
         $basic_salary= $row2['basic_salary'];
         $paid_leave_charges = $row2['paid_leave_charges'];
      }

      $stmt3= $link->prepare("SELECT contact_no, email, account_status FROM `user_accounts` WHERE username= :username");
      $stmt3->bindParam(":username", $username, PDO::PARAM_STR);
      $stmt3->execute();
      while($row3 = $stmt3->fetch()){
         $contact_no= $row3['contact_no'];
         $email = $row3['email'];
         $account_status = $row3['account_status'];
      }

      function getSumOfAllowances($allowances, $pay_scale, $link){
         $sum= 0;
            for($i=0; $i< substr_count($allowances, ",")+2; $i++){
               $arr= explode(",", $allowances);
               
               $stmt4= $link->prepare("SELECT * FROM `allowances` WHERE allowance_code= :allowance_code AND pay_scale= :pay_scale");
               $stmt4->bindParam(":allowance_code", $arr[$i], PDO::PARAM_STR);
               $stmt4->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
               $stmt4->execute();
               $row4= $stmt4->fetch();
                  $allowance_percentage= $row4['allowance_percentage'];

                  $sum += $allowance_percentage;
               
               
            }
            return $sum;
      }

      function getSumOfDeductions($deductions, $pay_scale, $link){
         $sum= 0;
            for($i=0; $i< substr_count($deductions, ",")+2; $i++){
               $arr= explode(",", $deductions);
               
               $stmt4= $link->prepare("SELECT * FROM `deductions` WHERE deduction_code= :deduction_code AND pay_scale= :pay_scale");
               $stmt4->bindParam(":deduction_code", $arr[$i], PDO::PARAM_STR);
               $stmt4->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
               $stmt4->execute();
               $row4= $stmt4->fetch();
                  $deduction_percentage= $row4['deduction_percentage'];

                  $sum += $deduction_percentage;
               
               
            }
            return $sum;
      }

      $sumOfAllowances= ($basic_salary / 100) * getSumOfAllowances($allowances, $pay_scale, $link) . ".00";
      $gross_pay= $basic_salary + $sumOfAllowances . ".00";

      $sumOfDeductions= ($basic_salary / 100) * getSumOfDeductions($deductions, $pay_scale, $link) . ".00";
      $net_pay= $gross_pay - $sumOfDeductions . ".00";
      
   
         echo "

         
         <table style='width:75%; font-size: 1em; display:inline-block; box-shadow: 5px 10px #888888;'>
         <th style='line-height: 2em; padding-bottom: 3%;'>
         <u style='font-weight: bold; text-align: center;'>Employee Details</u>
         </th>
         <tr style='line-height: 2em;'>
         <td><b>Emp #</b> $employeeID &nbsp;</td>
         <td><b>Name:</b> $full_name</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Desig:</b> $designation &nbsp;</td>
         <td><b>Dept:</b> $department</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Contact # :</b> $contact_no</td>
         <td><b>Email :</b> $email</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Account Status :</b> $account_status &nbsp;</td>
         </tr>
         
         
         </table>


         <table style='float: right; width:20%; font-size: 1em; display:inline-block;'>
         <tr style='line-height: 2em;'>
         <td><img src='$profile_picture' alt='profile_picture' width='160px' height='170px'></td>
         </tr>

         </table>


         <table style='width:60%; padding-top: 10%; font-size: 1em; display:inline-block;'>
         <th style='line-height: 2em; padding-bottom: 3%;'>
         <u style='font-weight: bold; text-align: center;'>Accounts Information</u>
         </th>
         
         <tr style='line-height: 2em;'>
         <td><b>Pay Scale :</b> $pay_scale</td>
         <td><b>Basic Salary (Rs):</b> $basic_salary</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Allowances:</b> $allowances</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Deductions:</b> $deductions</td>
         </tr>
         
         </table>


         <table style='width:60%; padding-top: 10%; font-size: 1em; display:inline-block;'>
         <th style='line-height: 2em; padding-bottom: 3%;'>
         <u style='font-weight: bold; text-align: center;'>Allowances</u>
         </th>
         
         <tr style='line-height: 2em;'>
         <td><b>Pay Scale :</b> $pay_scale</td>
         <td><b>Basic Salary (Rs):</b> $basic_salary</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Allowances:</b> $allowances</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Deductions:</b> $deductions</td>
         </tr>
         
         </table>


         <table style='float: right; margin-top: 10%; width:35%; font-size: 1em; display:inline-block; box-shadow: 5px 10px #888888;'>
         <th style='line-height: 2em; padding-bottom: 3%;'>
         <u style='font-weight: bold; text-align: center;'>Payment Details</u>
         </th>
         
         <tr style='line-height: 2em;'>
         <td><b>Basic Pay :</b> $basic_salary</td>
         </tr>
         <tr style='line-height: 2em;'>
         <td><b>Allowances:</b> $sumOfAllowances</td>
         </tr>
         <tr style='line-height: 2em;'>
         <td><b>Gross Pay:</b> $gross_pay</td>
         </tr>
         <tr style='line-height: 2em;'>
         <td><b>Deductions:</b> -$sumOfDeductions</td>
         </tr>
         <tr style='line-height: 2em;'>
         <td><b>Net Pay:</b> $net_pay</td>
         </tr>

         <tr style='line-height: 5em; font-size: 0.7em'>
         <td style='color:red'>Note: All prices are in PKR</td>
         </tr>
         
         </table>



         <table style='width:60%; padding-top: 10%; font-size: 1em; display:inline-block;'>
         <th style='line-height: 2em; padding-bottom: 3%;'>
         <u style='font-weight: bold; text-align: center;'>Deductions</u>
         </th>
         
         <tr style='line-height: 2em;'>
         <td><b>Pay Scale :</b> $pay_scale</td>
         <td><b>Basic Salary (Rs):</b> $basic_salary</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Allowances:</b> $allowances</td>
         </tr>
         
         <tr style='line-height: 2em;'>
         <td><b>Deductions:</b> $deductions</td>
         </tr>
         
         </table>

         <form action='' method='POST'>
         <input type='submit' name='search' class='btn btn-success btn-right-50' style='margin-top: 4%; margin-left: 30%' data-id='' value='Pay Now'>
         </form>
         
         ";
      }
   }
}
?>