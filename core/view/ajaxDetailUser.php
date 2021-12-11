<?php
require_once("../modal/initialize.php");

if(isset($_POST['userid'])){
   $userID = filter_var($_POST['userid'], FILTER_SANITIZE_STRING);

   $userObject= new UserController();
   $detailsArray= $userObject->getUserDetails($userID);

   if(is_array($detailsArray)){
       
      $username= $detailsArray['username'];
      $employeeID= $detailsArray['employeeID'];
      $full_name= $detailsArray['full_name'];
      $education= $detailsArray['education'];
      $department= $detailsArray['department'];
      $department_code= $detailsArray['department_code'];
      $designation= $detailsArray['designation'];
      $pay_scale= $detailsArray['pay_scale'];
      $allowances= $detailsArray['allowances'];
      $profile_picture= $detailsArray['profile_picture'];
      $registered_by= $detailsArray['registered_by'];
      $registered_at= $detailsArray['registered_at'];
      $last_edit_by= $detailsArray['last_edit_by'];
      $last_edit_at= $detailsArray['last_edit_at'];
      $contact= $detailsArray['contact_no'];
      $email= $detailsArray['email'];
      $access_level= $detailsArray['access_level'];
      $account_status= $detailsArray['account_status'];
      $remarks= $detailsArray['remarks'];

echo "

<table style='width:75%; font-size: 1em; display:inline-block; border-collapse:collapse'>
<tr style='line-height: 2em;'>
<td><b>Emp #</b> $employeeID &nbsp;</td>
<td><b>Name:</b> $full_name</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Education:</b> $education &nbsp;</td>
<td><b>Dept:</b> $department_code $department</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Designation:</b> $designation &nbsp;</td>
<td><b>Pay Scale:</b> $pay_scale</td>
</tr>

<tr style='line-height: 2em;'>
<td colspan='2'><b>Allowances:</b> $allowances &nbsp;</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Access Level:</b> $access_level &nbsp;</td>
<td><b>Account Status:</b> $account_status</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Contact:</b> $contact &nbsp;</td>
<td><b>Email:</b> $email</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Reg. By:</b> $registered_by &nbsp;</td>
<td><b>Reg. Date:</b> $registered_at</td>
</tr>

<tr style='line-height: 2em;'>
<td><b>Updated By:</b> $last_edit_by &nbsp;</td>
<td><b>Update Date:</b> $last_edit_at</td>
</tr>

<tr style='line-height: 2em;'>
<td colspan='2'><b>Remarks:</b> $remarks &nbsp;</td>
</tr>
</table>

<table style='display:flex; float:right'>
<tr>
<td><img id='profilePicture' src='$profile_picture' alt='profile_picture' width='200px' height='200px'></td>
</tr>
</table>






 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' id='close' data-dismiss='modal'>Close</button>

</div>


 ";
   }else{
       
echo "

$detailsArray


 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' id='close' data-dismiss='modal'>Close</button>

</div>


 ";
   }

exit;
}
?>