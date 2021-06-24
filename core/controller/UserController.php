<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/modal/initialize.php');

  function getUserData($username){
    global $link;

    $query= $link->prepare("SELECT * FROM `user_accounts` WHERE username= :username");
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->execute();
  
    while($row= $query->fetch()){
    
    $id= $row['id'];
    $user= $row['username'];
    $full_name= $row['full_name'];
    $designation= $row['designation'];
    $contact= $row['contact_no'];
  
  }
  $result= array("id"=>"$id", "username"=>"$user", "full_name"=>"$full_name","designation"=> "$designation", "contact"=>"$contact");
  return $result;

  //dispose the db connection
  $link= NULL;

  }
  
  function getUsersList(){
    global $link;

    $query= $link->prepare("SELECT * FROM `user_accounts`");
    $query->execute();
  
    while($row= $query->fetch()){
    
    $id= $row['id'];
    $username= $row['username'];
    $full_name= $row['full_name'];
    $access_level= $row['access_level'];
    $account_status= $row['account_status'];

   echo "<tr class='odd gradeX'>
    <td>$username</td>
    <td>$full_name</td>
    <td>$access_level</td>
    <td>$account_status</td>
    <td><button data-id='$id' class='userinfo btn btn-success'>Update</button></td>
</tr>";

  }
  //$result= array("barcode"=>"$barcode", "item_name"=>"$item_name", "description"=>"$description", "catagory"=>"$catagory", "unit_purchase_cost"=>"$unit_purchase_cost", "unit_selling_price"=>"$unit_selling_price", "tax_group"=>"$tax_group", "posted_by"=>"$posted_by", "status"=>"$status");

  //dispose the db connection
  $link= NULL;
}


//return the registered departments data
function getDepartments($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `departments`");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $deptID= $row['id'];
    $department_code= $row['department_code'];
    $department_name= $row['department_name'];
    $enrolled_employees= $row['enrolled_employees'];
    $visibility= $row['visibility'];

    echo "<tr>
   <form action='../core/view/dataParser?f=deleteDepartment' method='POST'>
    <td>$department_code</td>
    <td>$department_name</td>
    <td>$enrolled_employees</td>
    <td>$visibility</td>
    <input type='hidden' value='$deptID' name='id'>
    <td><input type='submit' name='deleteDepartment' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
    </form>
    </tr>";
  }
}else{
  header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}


}


//return the registered designations and pay scale data
function getDesignations($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations`");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $desigID= $row['id'];
    $designation_name= $row['designation_name'];
    $pay_scale= $row['pay_scale'];
    $enrolled_employees= $row['enrolled_employees'];

    echo "<tr>
   <form action='../core/view/dataParser?f=deleteDesignation' method='POST'>
    <td>$designation_name</td>
    <td>$pay_scale</td>
    <td>$enrolled_employees</td>
    <input type='hidden' value='$desigID' name='id'>
    <td><input type='submit' name='deleteDepartment' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
    </form>
    </tr>";
  }
}else{
  header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}


//return the department values for dropdown list
function getDepartmentsValues($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `departments` WHERE visibility= 'Visible'");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $department_name= $row['department_name'];

    echo "
    <option value='$department_name' name='department_name'>$department_name</option>
    ";
  }
}else{
  header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}


//return the designation values for dropdown list
function getDesignationValues($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations`");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $designation_name= $row['designation_name'];

    echo "
    <option value='$designation_name' name='designation_name'>$designation_name</option>
    ";
  }
}else{
  header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}


//return the Pay Scale values for dropdown list
function getPayScaleValues($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations`");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $pay_scale= $row['pay_scale'];

    echo "
    <option value='$pay_scale' name='pay_scale'>$pay_scale</option>
    ";
  }
}else{
  header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}



  function getErrorNotification(){
    if(isset($_SESSION['notifStatus']) && $_SESSION['notifStatus'] != ''){
      $flag= $_SESSION['notifStatus'];
      
                            ?>
                          <script>  
                          var flag= <?php echo json_encode($flag); ?>
                          
                   swal({
                   title: eval(JSON.stringify(flag)),
                   icon: "error",
                   button: "Ok",
                   });
                      </script>
<?php

unset($_SESSION['notifStatus']);

  }
  }

  
  function getNotification(){
    if(isset($_SESSION['notifStatus']) && $_SESSION['notifStatus'] != ''){
      $flag= $_SESSION['notifStatus'];

      if($flag=="Error"){
        getErrorNotification();
      }else{
      
                            ?>
                          <script>  
                          var flag= <?php echo json_encode($flag); ?>
                          
                   swal({
                   title: eval(JSON.stringify(flag)),
                   icon: "success",
                   button: "Ok",
                   });
                      </script>
<?php

unset($_SESSION['notifStatus']);

  }
  }
}
  
  
  $current_location= dirname(__FILE__);
  if($current_location== 'F:\xampp\htdocs\project\core\controller' OR $current_location== 'F:\xampp\htdocs\project\core\view'){
    
  }else{
    require_once('footer.php');
  }

?>