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


//this function generates the Leave Rewquest ID / Ticket ID for new User
public function generateLeaveRequestID(){
  global $link;

  $stmt= $link->prepare("SELECT request_id FROM `leaves_requests` ORDER BY request_id DESC LIMIT 1");
  $stmt->execute();

  if($stmt->rowCount() == 0){
    $leaveRequestID= "LR001";
    return $leaveRequestID;
  }else{
    $row= $stmt->fetch();
    $lastleaveRequestID= $row['request_id'];

    //increments the numeric part of Employee ID by 1
    
function increment($matches)
{
    if(isset($matches[1]))
    {
        $length = strlen($matches[1]);
        return sprintf("%0".$length."d", ++$matches[1]);
    }    
}

$leaveRequestID =  preg_replace_callback( "|(\d+)|", "increment", $lastleaveRequestID);
    return $leaveRequestID;


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

public function getAttendanceStatus($query, $employeeID, $dateInEISFormat){
  global $link;
  $punch_in_timestamp= '';

  $stmt= $link->prepare("SELECT * FROM `attendance_sheet` WHERE employeeID= :employeeID AND punch_in_timestamp LIKE '%$dateInEISFormat%'");
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


//it will convert the date format from January 01, 2021 to yyyy-mm-dd
public function convertDateToDefaultFormat($date){
  $months= array("January"=>"01", "February"=>"02", "March"=>"03", "April"=>"04", "May"=>"05", "June"=>"06",
                "July"=>"07", "August"=>"08", "September"=>"09", "October"=>"10", "November"=>"11", "December"=>"12");
  
  $monthInString= explode(" ", $date);
  $monthInString= $monthInString[0];

  $monthInDecimal= $months["$monthInString"];

  $dayInDecimal= explode(" ", $date);
  $dayInDecimal= str_replace(",", "", $dayInDecimal[1]);

  $yearInDecimal= explode(" ", $date);
  $yearInDecimal= $yearInDecimal[2];

  $convertedDate= $yearInDecimal . "-" . $monthInDecimal . "-" . $dayInDecimal;

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



//return the leaves that are allowed according to the scale and designation and other information.
public function getLeavesSettings($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `designations` WHERE allowed_leaves !='' AND paid_leave_charges != ''");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $designationID= $row['id'];
    $designation_name= $row['designation_name'];
    $pay_scale= $row['pay_scale'];
    $allowed_leaves= $row['allowed_leaves'];
    $paid_leaves_charges= $row['paid_leave_charges'];

    echo "<tr>
   <form action='../core/view/dataParser?f=deleteLeaveSetting' method='POST'>
    <td>$designation_name</td>
    <td>$pay_scale</td>
    <td>$allowed_leaves</td>
    <td>$paid_leaves_charges</td>
    <input type='hidden' value='$designation_name' name='designation'>
    <td><input type='submit' name='deleteLeaveSetting' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
    </form>
    </tr>";
  }
}else{
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}


}




//it will return leave request record of specific employee
public function getLeavesRecordForAdmin(){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `leaves_requests` WHERE request_status='' ORDER BY id DESC");

      $stmt->execute();
    
      while($row= $stmt->fetch()){
      
      $id= $row['id'];
      $request_id= $row['request_id'];
      $employeeID= $row['employeeID'];
      $no_of_leaves= $row['no_of_leaves'];
      $leaves_from= $row['leaves_from'];
      $leaves_to= $row['leaves_to'];
      $leave_type= $row['leave_type'];
      $report_back_date= $row['report_back_date'];
      $reason= $row['reason'];
      $request_status= $row['request_status'];
      $remarks= $row['remarks'];

      $stmt2= $link->prepare("SELECT full_name FROM `employees` WHERE employeeID= :employeeID");
      $stmt2->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
      $stmt2->execute();
      while($row2= $stmt2->fetch()){
        $full_name= $row2['full_name'];
      }
        

      echo "<tr class='odd gradeX'>
      <td>$employeeID</td>
      <td>$full_name</td>
      <td>$no_of_leaves</td>
      <td>$leaves_from</td>
      <td>$leaves_to</td>
      <td>$leave_type</td>
      <td>
          <button data-id='$request_id' class='leaveRequestDetails icon-color'><i class='fa fa-eye'></i></button>
      </td>
  </tr>";


    }


}

public function getLeavesOfMonth($employeeID, $dateInEISFormat){
  global $link;
  $month= explode(" ", $dateInEISFormat);
  $month= $month[0];

  $stmt= $link->prepare("SELECT COUNT(punch_out_timestamp) AS present_days FROM `attendance_sheet` WHERE employeeID= :employeeID
                         AND punch_out_timestamp LIKE '$month%'");
  $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
  $stmt->execute();
  while($row= $stmt->fetch()){
    $present_days= $row['present_days'];
  }

  //total days in given month
  $dateInDefault= $this->convertDateToDefaultFormat($dateInEISFormat);
  $yearDF= explode("-", $dateInDefault);
  $yearDF= $yearDF[0];

  $monthDF= explode("-", $dateInDefault);
  $monthDF= $monthDF[1];

  $dayDF= explode("-", $dateInDefault);
  $dayDF= $dayDF[2];

  $totalDaysInGivenMonth= cal_days_in_month(CAL_GREGORIAN, $monthDF, $yearDF);
  
  if($dayDF <= $totalDaysInGivenMonth){
    $remainingDays= $totalDaysInGivenMonth - $dayDF;

    $leaves= ($totalDaysInGivenMonth - $remainingDays) - $present_days;
  }elseif($dayDF === $totalDaysInGivenMonth){
    $leaves= $totalDaysInGivenMonth - $present_days;
  }

  return $leaves;
}



//return the allowances data
public function getAllowances($query, $args, $id){
  if(isAdminValid($id)){
  global $link;

    if($query=="getListForTable"){
      $stmt= $link->prepare("SELECT * FROM `allowances`");
      $stmt->execute();
    
      while($row= $stmt->fetch()){
        $id= $row['id'];
        $allowance_name= $row['allowance_name'];
        $allowance_code= $row['allowance_code'];
        $pay_scale= $row['pay_scale'];
        $allowance_percentage= $row['allowance_percentage'];
        $posted_by= $row['posted_by'];
    
        echo "<tr>
       <form action='../core/view/dataParser?f=deleteAllowances' method='POST'>
        <td>$allowance_code</td>
        <td>$allowance_name</td>
        <td>$allowance_percentage%</td>
        <td>$pay_scale</td>
        <td>$posted_by</td>
        <input type='hidden' value='$id' name='id'>
        <td><input type='submit' name='deleteAllowance' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
        </form>
        </tr>";
      }
    }elseif($query=="getListForDropDown"){
      $result= NULL;
      $pay_scale= $args['pay_scale'];
      $employeeID= $args['forEmployee'];
      $username= $args['username'];

      //get the allowances that are already issued to the employee
      $arr= $this->getUserData($username);
      $userID= $arr['id'];

      $data= $this->getUserDetails($userID);
      $allowancesIssued= $data['allowances'];
      $allowancesIssuedArray= explode(",", $allowancesIssued);

      $allowancesSQL= join("','", $allowancesIssuedArray);

      $stmt= $link->prepare("SELECT * FROM `allowances` WHERE allowance_code NOT IN ('$allowancesSQL') AND pay_scale= :pay_scale");
      $stmt->bindParam(":pay_scale", $pay_scale);
      $stmt->execute();
    
      while($row= $stmt->fetch()){
        $id= $row['id'];
        $allowance_name= $row['allowance_name'];
        $allowance_code= $row['allowance_code'];
        $pay_scale= $row['pay_scale'];
        $allowance_percentage= $row['allowance_percentage'];
        $posted_by= $row['posted_by'];

        
        $optionValues= "<option>$allowance_code $allowance_name @ $allowance_percentage%</option>";
        $result .= $optionValues;
        

    }
    return $result;

}else{
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

  }
}


//return the deductions data
public function getDeductions($query, $args, $id){
  if(isAdminValid($id)){
  global $link;

    if($query=="getListForTable"){
      $stmt= $link->prepare("SELECT * FROM `deductions`");
      $stmt->execute();
    
      while($row= $stmt->fetch()){
        $id= $row['id'];
        $deduction_code= $row['deduction_code'];
        $deduction_name= $row['deduction_name'];
        $deduction_type= $row['deduction_type'];
        $pay_scale= $row['pay_scale'];
        $deduction_percentage= $row['deduction_percentage'];
        $posted_by= $row['posted_by'];
    
        echo "<tr>
       <form action='../core/view/dataParser?f=deleteDeductions' method='POST'>
        <td>$deduction_code</td>
        <td>$deduction_name</td>
        <td>$deduction_type</td>
        <td>$pay_scale</td>
        <td>$deduction_percentage%</td>
        <input type='hidden' value='$id' name='id'>
        <td><input type='submit' name='deleteDeduction' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
        </form>
        </tr>";
      }
    }elseif($query=="getListForDropDown"){
      $result= NULL;
      $pay_scale= $args['pay_scale'];
      $employeeID= $args['forEmployee'];
      $username= $args['username'];

      //get the deductions that are already issued to the employee
      $arr= $this->getUserData($username);
      $userID= $arr['id'];

      $data= $this->getUserDetails($userID);
      $deductionsIssued= $data['deductions'];
      $deductionsIssuedArray= explode(",", $deductionsIssued);

      $deductionsSQL= join("','", $deductionsIssuedArray);

      $stmt= $link->prepare("SELECT * FROM `deductions` WHERE deduction_code NOT IN ('$deductionsSQL') AND pay_scale= :pay_scale");
      $stmt->bindParam(":pay_scale", $pay_scale);
      $stmt->execute();
    
      while($row= $stmt->fetch()){
        $id= $row['id'];
        $deduction_name= $row['deduction_name'];
        $deduction_code= $row['deduction_code'];
        $deduction_type= $row['deduction_type'];
        $pay_scale= $row['pay_scale'];
        $deduction_percentage= $row['deduction_percentage'];
        $posted_by= $row['posted_by'];

        
        $optionValues= "<option>$deduction_code $deduction_name @ $deduction_percentage%</option>";
        $result .= $optionValues;
        

    }
    return $result;

    }  

}else{
  header("Location: http://localhost/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
}

}




//return the deductions data
public function getEmployeesForPaymentSettings($id){
  if(isAdminValid($id)){
  global $link;

  $stmt= $link->prepare("SELECT * FROM `employees`");
  $stmt->execute();

  while($row= $stmt->fetch()){
    $id= $row['id'];
    $employeeID= $row['employeeID'];
    $full_name= $row['full_name'];
    $pay_scale= $row['pay_scale'];
    $allowances= $row['allowances'];
    $deductions= $row['deductions'];
    $posted_by= $row['posted_by'];

    echo "<tr>
   <form action='../core/view/dataParser?f=deleteDeductions' method='POST'>
    <td>$deduction_code</td>
    <td>$deduction_name</td>
    <td>$deduction_type</td>
    <td>$pay_scale</td>
    <td>$deduction_percentage%</td>
    <input type='hidden' value='$id' name='id'>
    <td><input type='submit' name='deleteDeduction' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Are you sure?' value='Delete'></td>
    </form>
    </tr>";
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