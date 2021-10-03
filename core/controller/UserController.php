<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/modal/initialize.php');
require_once 'classes/User.class.php';
global $link;
class UserController extends User{


  public function getUserData($username){
    return parent::getUserData($username);
  }

  public function getUsersList(){
    return parent::getUsersList();
  }

  public function getUserDetails($userID){
    return parent::getUserDetails($userID);
  }

//return the registered departments data
public function getDepartments($id){
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
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}


}


//return the registered designations and pay scale data
public function getDesignations($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations`");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $desigID= $row['id'];
    $designation_name= $row['designation_name'];
    $pay_scale= $row['pay_scale'];
    $basic_salary= $row['basic_salary'];
    $enrolled_employees= $row['enrolled_employees'];

    echo "<tr>
   <form action='../core/view/dataParser?f=deleteDesignation' method='POST'>
    <td>$designation_name</td>
    <td>$pay_scale</td>
    <td>$basic_salary</td>
    <td>$enrolled_employees</td>
    <input type='hidden' value='$desigID' name='id'>
    <td><input type='submit' name='deleteDepartment' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
    </form>
    </tr>";
  }
}else{
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}


//return the department values for dropdown list
public function getDepartmentsValues($id){
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
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}


//return the designation values for dropdown list
public function getDesignationValues($id){
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
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}


//return the Pay Scale values for dropdown list
public function getPayScaleValues($id){
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
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}



public function getErrorNotification(){
    if(isset($_SESSION['notifStatus']) && $_SESSION['notifStatus'] != ''){
      $flag= $_SESSION['notifStatus'];
      
                            ?>
                          <script>  
                          var flag= <?php echo json_encode($flag); ?>
                          
                          swal({
                           
                            icon: 'error',
                            title: eval(JSON.stringify(flag[0])),
                            text: eval(JSON.stringify(flag[1])),
                            timer: 3000 //3 seconds
                          });
                      </script>
<?php

unset($_SESSION['notifStatus']);

  }
  }

  
  public function getNotification(){
    if(isset($_SESSION['notifStatus']) && $_SESSION['notifStatus'] != ''){
      $flag= $_SESSION['notifStatus'];

      if($flag[0]=="Error"){
        $this->getErrorNotification();
      }else{
      
                            ?>
                          <script>  
                          var flag= <?php echo json_encode($flag); ?>
                          
                   swal({
                   title: JSON.stringify(flag),
                   icon: "success",
                   button: "Ok",
                   });
                      </script>
<?php

unset($_SESSION['notifStatus']);

  }
  }
}



//this function generates the Employee ID for new User
public function generateEmployeeID(){
  global $link;

  $stmt= $link->prepare("SELECT employeeID FROM `employees` ORDER BY employeeID DESC LIMIT 1");
  $stmt->execute();

  if($stmt->rowCount() == 0){
    $employeeID= "EMP-001";
    return $employeeID;
  }else{
    $row= $stmt->fetch();
    $lastEmployeeID= $row['employeeID'];

    //increments the numeric part of Employee ID by 1
    
function increment($matches)
{
    if(isset($matches[1]))
    {
        $length = strlen($matches[1]);
        return sprintf("%0".$length."d", ++$matches[1]);
    }    
}

$employeeID =  preg_replace_callback( "|(\d+)|", "increment", $lastEmployeeID);
    return $employeeID;


  }
}



//this function will get the employee pay scale and salary according to designation
public function getEmployeeScaleAndSalary($designation){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations` WHERE designation_name= :designation_name");
  $stmt->bindParam(":designation_name", $designation, PDO::PARAM_STR);
  $stmt->execute();
  
  $row= $stmt->fetch();
  $payScale= $row['pay_scale'];
  $basic_salary= $row['basic_salary'];

  $array= [
    "pay_scale" => $payScale,
    "basic_salary" => $basic_salary,
  ];

  return $array;
}


public function updateDesignationEMPCount(){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations` WHERE designation_name= :designation_name");
  $stmt->bindParam(":designation_name", $designation, PDO::PARAM_STR);
  $stmt->execute();
  
  $row= $stmt->fetch();
  $payScale= $row['pay_scale'];
  $basic_salary= $row['basic_salary'];

  $array= [
    "pay_scale" => $payScale,
    "basic_salary" => $basic_salary,
  ];

  return $array;
}

  
  
  /**$current_location= dirname(__FILE__);
  if($current_location== 'F:\xampp\htdocs\project\core\controller' OR $current_location== 'F:\xampp\htdocs\project\core\view'){
    
  }else{
    require_once('footer.php');
  }**/
}
?>