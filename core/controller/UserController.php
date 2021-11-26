<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/modal/initialize.php');
require_once 'classes/User.class.php';
require_once 'classes/employee.class.php';
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
public function getDepartmentsValues(){

  global $link;

  $stmt= $link->prepare("SELECT * FROM `departments` WHERE visibility= 'Visible'");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $department_name= $row['department_name'];
    $department_code= $row['department_code'];

    $department_name_detailed= $department_code . " " . $department_name;

    echo "
    <option value='$department_name' name='department_name'>$department_name_detailed</option>
    ";
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
    $employeeID= "EIS-001";
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

public function getAttendanceStatus($query, $employeeID){
  global $link;
  $punch_in_timestamp= '';

  $stmt= $link->prepare("SELECT * FROM `attendance_sheet` WHERE employeeID= :employeeID");
  $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
  $stmt->execute();
  
  while($row= $stmt->fetch()){
    $punch_in_timestamp= $row['punch_in_timestamp'];
    $punch_out_timestamp= $row['punch_out_timestamp'];
  }

    if($query == 'details'){
      return $punch_in_timestamp;

    }else{
      if(empty($punch_in_timestamp) === TRUE){

        //January 01
    $now= date("F j");
  
    $arr= explode(",", $punch_in_timestamp, 2);
    $punch_in_timestamp= $arr[0];
  
    if($now > $punch_in_timestamp){
      return TRUE;
    }else{
      return FALSE;
    }
  
    }else if(empty($punch_out_timestamp) === FALSE){
      $now= date("F j");
      $arr= explode(",", $punch_out_timestamp, 2);
      $punch_out_timestamp= $arr[0];

      if($now <= $punch_out_timestamp){
        return 'DENIED';
      }else{
        return TRUE;
      }
    }
    }

//dispose the db connection
//$link= NULL;

}


public function getTodayAttendanceSheet(){
  global $link;
  $now= date("F j, Y");

  $stmt= $link->prepare("SELECT * FROM `attendance_sheet` WHERE punch_in_timestamp LIKE '%$now%'");
        $stmt->execute();
      
        while($row= $stmt->fetch()){
        
        $id= $row['id'];
        $employeeID= $row['employeeID'];
        $punch_in_timestamp= $row['punch_in_timestamp'];
        $punch_out_timestamp= $row['punch_out_timestamp'];
        
        //12:00 am
        $arr= explode(",", $punch_in_timestamp);
        $punch_in= $arr[2];

        if(empty($punch_out_timestamp) === FALSE){
          $arr= explode(",", $punch_out_timestamp);
          $punch_out= $arr[2];
        }else{
          $punch_out= '';
        }

        $stmt2= $link->prepare("SELECT full_name, designation FROM `employees` WHERE employeeID= :employeeID");
        $stmt2->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
        $stmt2->execute();
        while($row2= $stmt2->fetch()){
          $full_name= $row2['full_name'];
          $designation= $row2['designation'];
        }

    
       echo "<tr class='odd gradeX'>
        <td>$employeeID</td>
        <td>$full_name</td>
        <td>$designation</td>
        <td>$punch_in</td>
        <td>$punch_out</td>
        </td>
    </tr>";
        }

}


//it will convert the date format from 00-00-0000 to January 01, 2021
public function convertDateToEISFormat($date){
  $months= array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June",
                "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
  
  $monthInDecimal= explode("-", $date);
  $monthInDecimal= $monthInDecimal[1];

  $monthInString= $months["$monthInDecimal"];

  $dayInDecimal= explode("-", $date);
  $dayInDecimal= $dayInDecimal[2];

  $yearInDecimal= explode("-", $date);
  $yearInDecimal= $yearInDecimal[0];

  $convertedDate= $monthInString . " " . $dayInDecimal . ", " . $yearInDecimal;

  //January, 01, 2021
  return $convertedDate;

}


//it will convert the time format from 16:00 to 04:00 PM
public function convertTimeToEISFormat($time){
  
  
  $hours= explode(":", $time);
  $hours= $hours[0];
  $minutes= explode(":", $time);
  $minutes= $minutes[1];
  
  if($hours > 11){
      $hoursFormats= array(13=>"01", 14=>"02", 15=>"03", 16=>"04", 17=>"05", 18=>"06", 19=>"07", 20=>"08", 
                          21=>"09", 22=>"10", 23=>"11", 00=>"12", 12=>"12");
      
      $convertedHours= $hoursFormats[$hours];
      $convertedTime= $convertedHours . ":" . $minutes . " pm";
      
  }else{
      if($hours== 00)
        $hours= 12;
        
      $convertedTime= $hours . ":" . $minutes . " am";
  }
  
  return $convertedTime;

}


//return the custome attendance sheet with defined dates and time
public function getCustomeAttendanceSheet($id, $date, $status){
  if(isAdminValid($id)){
  global $link;

  $dateWithOutTime= $this->convertDateToEISFormat($date);

  if($status === 'Present'){

  $stmt= $link->prepare("SELECT * FROM attendance_sheet AS presentEmp WHERE punch_in_timestamp LIKE '%$dateWithOutTime%' ORDER BY id DESC");

 
  $stmt->execute();

  while($row= $stmt->fetch()){
    $employeeID= $row['employeeID'];
    $punch_in_timestamp= $row['punch_in_timestamp'];
    $punch_out_timestamp= $row['punch_out_timestamp'];


    $stmt2= $link->prepare("SELECT full_name FROM `employees` WHERE employeeID= :employeeID");
    $stmt2->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
    $stmt2->execute();
    while($row2= $stmt2->fetch()){
      $full_name= $row2['full_name'];
    }

    echo "<tr>
    <td>$employeeID</td>
    <td>$full_name</td>
    <td>$punch_in_timestamp</td>
    <td>$punch_out_timestamp</td>
    </td>
    </tr>";
  }
  }elseif($status === 'Absent'){
    $stmt= $link->prepare("SELECT emp.employeeID, emp.full_name FROM employees emp LEFT JOIN attendance_sheet attend ON emp.employeeID <> attend.employeeID 
                           WHERE attend.punch_in_timestamp LIKE '%$dateWithOutTime%'");

 
  $stmt->execute();

  while($row= $stmt->fetch()){
    $employeeID= $row['employeeID'];
    $full_name= $row['full_name'];

    echo "<tr>
    <td>$employeeID</td>
    <td>$full_name</td>
    <td>N/A</td>
    <td>N/A</td>
    </td>
    </tr>";
  }
  }
  
}else{
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}

  
  
  /**$current_location= dirname(__FILE__);
  if($current_location== 'F:\xampp\htdocs\project\core\controller' OR $current_location== 'F:\xampp\htdocs\project\core\view'){
    
  }else{
    require_once('footer.php');
  }**/
}
?>