<?php
require_once('../controller/UserController.php');

$userid = 0;
global $link;
if(isset($_POST['userid'])){
   $userid = filter_var($_POST['userid'], FILTER_SANITIZE_STRING);
}
$sql = $link->prepare("select * from `user_accounts` where id= :id");
$sql->bindParam(":id", $userid, PDO::PARAM_STR);
$sql->execute();
while( $row = $sql->fetch()){
 $id = $row['id'];
 $username = $row['username'];
 $full_name= $row['full_name'];
 $designation = $row['designation'];
 $contact_no = $row['contact_no'];

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
     <label>Password</label>
     <input class='form-control' type='password' minlength='8' maxlength='20' name='password'>
 </div>
     <div class='form-group to-left-50'>
 <label>Designation <span class='title-red'>*</span></label>
     <select class='form-control' name='designation' required>
         <option value='$designation'>$designation</option>
         <option value='Administrator'>Administrator</option>
         <option value='Employee'>Employee</option>
     </select>
    
 </div>
     
 <div class='form-group to-left-50'>
     <label>Contact # <span class='title-red'>*</span></label>
     <input class='form-control' type='varchar' value='$contact_no' name='contact' required>
    
 </div>

 <input type='hidden' value='$id' name='id'>

 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
<input type='submit' name='updateUser' class='btn btn-success button-right-50' value='Update'>
<input type='submit' name='deleteUser' class='btn btn-danger button-right-50' value='Delete'>
</div>

</form>

 ";
}

exit;
?>