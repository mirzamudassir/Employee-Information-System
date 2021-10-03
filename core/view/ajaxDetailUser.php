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
      $basic_salary= $detailsArray['basic_salary'];
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

<table style='width:100%'>
  
  <tr>
    <td>Username</td>
    <td><b>$username</b></td>
    <td>Employee ID</td>
    <td><b>$employeeID</b></td>
    <td>Education</td>
    <td><img src='$profile_picture' width='130px' height='150px'></td>
  </tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr></tr>
  <tr style='line-height: 50px'>
    <td>Employee ID</td>
    <td>$employeeID</td>
    <td>Designation</td>
    <td>$designation</td>
    <td>Full Name</td>
    <td>$full_name</td>
  </tr>
  <tr>
    <td>John</td>
    <td>Doe</td>
    <td>80</td>
  </tr>
</table>



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