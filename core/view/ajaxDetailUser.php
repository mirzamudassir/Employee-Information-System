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

echo "

<div style='width:30%; float:right;'>
<table style='width:100%'>
<tr>
<td><img src='$profile_picture' alt='User Image' width='150px' height='150px' style='float:right;'></td>
</tr>
</table>
</div>

<div style='width:65%; float:left;'>
<table style='width:100%'>
<tr>
<td>Emp# : $employeeID</td>
<td>Emp# : $employeeID</td>
</tr>

<tr>
<td>Emp# : $employeeID</td>
<td>Emp# : $employeeID</td>
</tr>
  
</table>
</div>



</div>


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