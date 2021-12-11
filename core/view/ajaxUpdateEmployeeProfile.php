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
 $contact_no = $row['contact_no'];
 $email = $row['email'];

}

    echo "
 
 <form action='../core/view/dataParser?f=updateEmployeeProfile' method='POST' enctype='multipart/form-data'>

 
<div class='form-group to-left-50'>
<label>Profile Picture</label>
<input class='form-control' name='profile_picture' id='profile_picture' type='file'>

</div>
     
 <div class='form-group to-left-50'>
     <label>Contact # <span class='title-red'>*</span></label>
     <input class='form-control' type='tel' placeholder='0300-1234567' pattern='[0-9]{4}-[0-9]{7}' value='$contact_no' name='contact' required>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Email <span class='title-red'>*</span></label>
 <input class='form-control' type='varchar' value='$email' name='email' required>

</div>

 <div class='form-group to-left-50'>
     <label>Password</label>
     <input class='form-control' type='password' minlength='8' maxlength='20' name='password'>
 </div>


 <input type='hidden' value='$username' name='usernameForUpdate'>
 

 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' id='close' data-dismiss='modal'>Close</button>
<input type='submit' name='updateUser' class='btn btn-success button-right-50' value='Update'>
</div>

</form>

 ";




}

exit;
?>