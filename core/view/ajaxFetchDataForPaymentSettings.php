<?php
require_once("../modal/initialize.php");
$userControllerObject= new UserController();

if(isset($_POST['employeeIDForPaymentSettings'])){

   $employeeID = filter_var($_POST['employeeIDForPaymentSettings'], FILTER_SANITIZE_STRING);

   $stmt= $link->prepare("SELECT * FROM `employees` WHERE employeeID= :employeeID");
   $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
   $stmt->execute();

      if($stmt->rowCount() == 0){
         echo "No data found.";
      }else{
    
      while($row= $stmt->fetch()){
      
      $id= $row['id'];
      $username= $row['username'];
      $employeeID = $row['employeeID'];
      $full_name= $row['full_name'];
      $pay_scale = $row['pay_scale'];
      $allowances = $row['allowances'];
      $deductions= $row['deductions'];

      $allowancesList= $userControllerObject->getAllowances("getListForDropDown", array("pay_scale"=>$pay_scale, 'forEmployee'=>$employeeID, 'username'=>$username), $_SESSION['id']);
      $deductionsList= $userControllerObject->getDeductions("getListForDropDown", array("pay_scale"=>$pay_scale, 'forEmployee'=>$employeeID, 'username'=>$username), $_SESSION['id']);
     


      echo "

    <form action='#' method='POST'>
<table style='width:100%; font-size: 1em; display:inline-block; border-collpase:collapse'>
<tr style='line-height: 2em;'>
<td><b>Emp #</b> $employeeID &nbsp;</td>
<td><b> Name</b> $full_name</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Pay Scale:</b> $pay_scale &nbsp;</td>
<td><b>Total Leaves:</b> N/A</td>
</tr>

<tr style='line-height: 2em;'>
<td colspan='2'><b>Allowances:</b> $allowances &nbsp;</td>
</tr>

<tr style='line-height: 2em;'>
<td colspan='2'><b>Deductions:</b> $deductions &nbsp;</td>
</tr>


</table>

<div style='color: green; margin-top:3%; margin-bottom: 3%;'>Press Ctrl + click to select multiple.</div>

<div class='form-group to-left-70'>
      <label>Allowances</label>
      <select multiple class='form-control' name='allowances'>
          $allowancesList
      </select>
</div>

<div class='form-group to-left-70'>
      <label>Deductions</label>
      <select multiple class='form-control' name='deductions'>
          $deductionsList
      </select>
</div>




</div>


<div class='modal-footer'>
              <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
              <input type='submit' name='updatePaymentSettings' class='btn btn-success button-right-50' value='Update'>
                                            
</div>
</form>
    ";
    
      
      
      }
   }
}
?>