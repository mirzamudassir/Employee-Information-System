<?php
require_once('../controller/UserController.php');

$userid = 0;
$link= database_conn();
if(isset($_POST['userid'])){
   $userid = mysqli_real_escape_string($link,$_POST['userid']);
}
$sql = "select * from `inventory` where id=$userid";
$result = mysqli_query($link,$sql);

while( $row = mysqli_fetch_array($result) ){
 $id = $row['id'];
 $barcode= $row['barcode'];
 $item_name = $row['item_name'];
 $description= $row['item_description'];
 $catagory = $row['catagory'];
 $sub_catagory = $row['sub_catagory'];
 $status = $row['item_status'];
 $posted_by = $row['posted_by'];

echo "
 
 <form action='../core/view/dataParser?f=updateItem' method='POST'>

 <div class='form-group to-left-50'>
     <label>Barcode <span class='title-red'>*</span></label>
     <input class='form-control' value='$barcode' name='barcode' required>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Item Name <span class='title-red'>*</span></label>
     <input class='form-control' value='$item_name' name='item_name' required>
    
 </div>
 <div class='form-group to-left-50'>
     <label>Description</label>
     <input class='form-control' value='$description' name='description'>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Catagory <span class='title-red'>*</span></label>
     <select class='form-control' name='catagory' required>
         <option value='$catagory'>$catagory</option>
         
         
     </select>
    
 </div>
 <div class='form-group to-left-50'>
 <label>Sub-Catagory</label>
     <select class='form-control' name='sub_catagory'>
         <option value='$sub_catagory'>$sub_catagory</option>
         <option>2</option>
         
     </select>
    
 </div>
 <input type='hidden' value='$id' name='id'>

 <div class='modal-footer'>
                                            
 <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
<input type='submit' name='updateItem' class='btn btn-success button-right-50' value='Update'>
<input type='submit' name='deleteItem' class='btn btn-danger button-right-50' value='Delete'>

</form>

 
 </div>


 ";
}

exit;
?>