<?php
require_once("../modal/initialize.php");

if(isset($_POST['requestID'])){

   $requestID = filter_var($_POST['requestID'], FILTER_SANITIZE_STRING);

   $stmt= $link->prepare("SELECT * FROM `leaves_requests` WHERE request_id= :request_id LIMIT 1");
   $stmt->bindParam(":request_id", $requestID, PDO::PARAM_STR);
      $stmt->execute();
    
      while($row= $stmt->fetch()){
      
      $id= $row['id'];
      $request_id= $row['request_id'];
      $employeeID= $row['employeeID'];
      $no_of_leaves= $row['no_of_leaves'];
      $leaves_from= $row['leaves_from'];
      $leaves_to= $row['leaves_to'];
      $leave_type= $row['leave_type'];
      $report_back_date= $row['report_back_date'];
      $reason= $row['reason'];
      $request_status= $row['request_status'];
      $remarks= $row['remarks'];

      $stmt2= $link->prepare("SELECT full_name, designation FROM `employees` WHERE employeeID= :employeeID");
      $stmt2->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
      $stmt2->execute();
      while($row2= $stmt2->fetch()){
        $full_name= $row2['full_name'];
        $designation= $row2['designation'];
      }

      //getting neccessary details of employee
      $stmt2= $link->prepare("SELECT allowed_leaves, paid_leave_charges FROM `designations` WHERE designation_name= :designation");
      $stmt2->bindParam(":designation", $designation, PDO::PARAM_STR);
      $stmt2->execute();
      while($row2= $stmt2->fetch()){
         $allowed_leaves= $row2['allowed_leaves'];
         $paid_leave_charges = $row2['paid_leave_charges'];
      }

      $userObject= new UserController();
      $leaves_this_month= $userObject->getLeavesOfMonth($employeeID, date("F d, Y"));
      if($allowed_leaves - $leaves_this_month < 0){
         $remaining_leaves = 0;
      }else{
         $remaining_leaves= $allowed_leaves - $leaves_this_month;
      }

echo "
<form action='../core/view/dataParser?f=updateLeaveRequest' method='POST'>
<table style='width:75%; font-size: 1em; display:inline-block;'>
<tr style='line-height: 2em;'>
<td><b>Request #</b> $request_id &nbsp;</td>
<td><b>Employee #</b> $employeeID</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Name:</b> $full_name &nbsp;</td>
<td><b>Total Leaves:</b> $no_of_leaves</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Leaves From:</b> $leaves_from &nbsp;</td>
<td><b>Leaves To:</b> $leaves_to</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Leave Type:</b> $leave_type &nbsp;</td>
<td><b>Report Back Date:</b> $report_back_date</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Reason:</b> $reason &nbsp;</td>
</tr>

</table>

<div style='color: green; margin-top:3%;'>Allowed Leaves (Per Month): $allowed_leaves</div>
<div style='color: green;'>Remaining Leaves (Per Month): $remaining_leaves</div>
<div style='color: red;'>Leaves in Current month: $leaves_this_month</div>
<div style='color: red; margin-top:3%;'>Paid Leave Charges (Per Leave): $paid_leave_charges PKR

<input type='text' class='form-control to-right-50' name='remarks' placeholder='Remarks' autocomplete='off' required>
<input type='hidden' name='requestID' value='$request_id'>
</div>

 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' id='close' data-dismiss='modal'>Close</button>
 <input type='submit' name='approveLeave' class='btn btn-success button-right-50' value='Approve'>
 <input type='submit' name='rejectLeave' class='btn btn-danger button-right-50' value='Reject'>
 

</div>

</form>
 ";
   }

}
?>