<?php
require_once("../modal/initialize.php");

$userid = 0;
global $link;
if(isset($_POST['userid'])){
   $userid = filter_var($_POST['userid'], FILTER_SANITIZE_STRING);
   

$sql = $link->prepare("SELECT * FROM `user_accounts` WHERE id= :id");
$sql->bindParam(":id", $userid, PDO::PARAM_STR);
$sql->execute();
while( $row = $sql->fetch()){
 $id = $row['id'];
 $username = $row['username'];
 $full_name= $row['full_name'];
 $designation = $row['designation'];
 $contact_no = $row['contact_no'];
 $email = $row['email'];
 $access_level = $row['access_level'];
 $account_status = $row['account_status'];
 $remarks = $row['remarks'];

}

$stmt= $link->prepare("SELECT * FROM `employees` WHERE username= :username");
$stmt->bindParam(":username", $username, PDO::PARAM_STR);
$stmt->execute();
while($row1= $stmt->fetch()){
    $profilePicture= $row1["profile_picture"];
    $employeeID= $row1["employeeID"];
    $education= $row1["education"];
    $department= $row1["department"];
    $payScale= $row1["pay_scale"];
}

if($designation === 'Administrator'){

    echo "
 
 <form action='../core/view/dataParser?f=updateUser' method='POST'>

 <div class='form-group to-left-50'>
     <label>Username <span class='title-red'>*</span></label>
     <input class='form-control' value='$username' name='username' disabled>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Full Name <span class='title-red'>*</span></label>
     <input class='form-control' value='$full_name' name='full_name'>
    
 </div>

     <div class='form-group to-left-50'>
 <label>Designation <span class='title-red'>*</span></label>
     <select class='form-control' name='designation' disabled>
         <option value='$designation'>$designation</option>
     </select>
    
 </div>
     
 <div class='form-group to-left-50'>
     <label>Contact # <span class='title-red'>*</span></label>
     <input class='form-control' type='varchar' value='$contact_no' name='contact' required>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Email <span class='title-red'>*</span></label>
 <input class='form-control' type='varchar' value='$email' name='email' required>

</div>
<div class='form-group to-left-50'>
 <label>Access Level <span class='title-red'>*</span></label>
     <select class='form-control' name='access_level' disabled>
         <option value='$access_level'>$access_level</option>
     </select>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Account Status <span class='title-red'>*</span></label>
     <select class='form-control' name='account_status' disabled>
         <option value='$account_status'>$account_status</option>
     </select>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Password</label>
     <input class='form-control' type='password' minlength='8' maxlength='20' name='password'>
 </div>
 <div class='form-group to-left-50'>
 <label>Remarks</label>
 <input class='form-control' type='varchar' name='remarks' autocomplete='off'>

</div>

 <input type='hidden' value='$username' name='usernameForUpdate'>
 

 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' id='close' data-dismiss='modal'>Close</button>
<input type='submit' name='updateUser' class='btn btn-success button-right-50' value='Update'>
</div>

</form>

 ";

}else{

    echo "
 
 <form action='../core/view/dataParser?f=updateUser' method='POST' enctype='multipart/form-data'>

 <div class='form-group to-left-50'>
     <label>Username <span class='title-red'>*</span></label>
     <input class='form-control' value='$username' name='username' disabled>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Full Name <span class='title-red'>*</span></label>
     <input class='form-control' value='$full_name' name='full_name'>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Education <span class='title-red'>*</span></label>
     <input class='form-control' value='$education' name='education'>
    
 </div>
     <div class='form-group to-left-50'>
 <label>Department <span class='title-red'>*</span></label>
     <select class='form-control' name='department' disabled>
         <option value='$department'>$department</option>
         
     </select>
    
 </div>

     <div class='form-group to-left-50'>
 <label>Designation <span class='title-red'>*</span></label>
     <select class='form-control' name='designation' disabled>
         <option value='$designation'>$designation</option>
     </select>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Pay Scale <span class='title-red'>*</span></label>
     <select class='form-control' name='pay_scale' required>
         <option value='$payScale'>$payScale</option>
         <option> BPS 10 </option>
         <option> BPS 09 </option>
         <option> BPS 08 </option>
         <option> BPS 07 </option>
         <option> BPS 06 </option>
         <option> BPS 05 </option>
         <option> BPS 04 </option>
         <option> BPS 03 </option>
         <option> BPS 02 </option>
         <option> BPS 01 </option>
     </select>
    
 </div>
<div class='form-group to-left-50'>
<label>Profile Picture</label>
<input class='form-control' name='profile_picture' id='profile_picture' type='file'>

</div>
     
 <div class='form-group to-left-50'>
     <label>Contact # <span class='title-red'>*</span></label>
     <input class='form-control' type='varchar' value='$contact_no' name='contact' required>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Email</label>
 <input class='form-control' type='varchar' value='$email' name='email'>

</div>
<div class='form-group to-left-50'>
 <label>Access Level <span class='title-red'>*</span></label>
     <select class='form-control' name='access_level' required>
         <option value='$access_level'>$access_level</option>
         <option value='ADMIN'>ADMIN</option>
         <option value='USER'>USER</option>
     </select>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Account Status <span class='title-red'>*</span></label>
     <select class='form-control' name='account_status' required>
         <option value='$account_status'>$account_status</option>
         <option value='ACTIVE'>ACTIVE</option>
         <option value='DISABLED'>DISABLED</option>
         <option value='DORMANT'>DORMANT</option>
     </select>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Password</label>
     <input class='form-control' type='password' minlength='8' maxlength='20' name='password'>
 </div>
 <div class='form-group to-left-50'>
 <label>Remarks</label>
 <input class='form-control' type='varchar' name='remarks' autocomplete='off'>

</div>

 <input type='hidden' value='$username' name='usernameForUpdate'>
 

 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' id='close' data-dismiss='modal'>Close</button>
<input type='submit' name='updateUser' class='btn btn-success button-right-50' value='Update'>
<input type='submit' name='deleteUser' class='btn btn-danger button-right-50' value='Delete'>
</div>

</form>

 ";
}



}

exit;
?>