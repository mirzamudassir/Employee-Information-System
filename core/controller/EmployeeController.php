<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/modal/initialize.php');
require_once 'classes/Employee.class.php';
global $link;

class EmployeeController extends Employee{


  public function getUserData($username){
    return parent::getUserData($username);
  }
  
  public function getEmployeesList(){
      return parent::getEmployeesList();
  }


  public function getEmployeeDetails($username){
    return parent::getUserDetails($username);
  }

  //it will return attendance record of specific employee
  public function getAttendanceRecord($username){
    global $link;

    //get employee ID
    $arr= $this->getEmployeeDetails($username);
    $employeeID= $arr["employeeID"];

    $stmt= $link->prepare("SELECT * FROM `attendance_sheet` WHERE employeeID= :employeeID ORDER BY id DESC");
    $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
        $stmt->execute();
      
        while($row= $stmt->fetch()){
        
        $id= $row['id'];
        $employeeID= $row['employeeID'];
        $punch_in_timestamp= $row['punch_in_timestamp'];
        $punch_out_timestamp= $row['punch_out_timestamp'];


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
        <td>$punch_in_timestamp</td>
        <td>$punch_out_timestamp</td>
        </td>
    </tr>";


      }


  }



  //it will return leave request record of specific employee
  public function getLeavesRecordForEmployee($username){
    global $link;

    //get employee ID
    $arr= $this->getEmployeeDetails($username);
    $employeeID= $arr["employeeID"];
    $full_name= $arr['full_name'];

    $stmt= $link->prepare("SELECT * FROM `leaves_requests` WHERE employeeID= :employeeID ORDER BY id DESC");
    $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
        $stmt->execute();
      
        while($row= $stmt->fetch()){
        
        $id= $row['id'];
        $request_id= $row['request_id'];
        $leave_type= $row['leave_type'];
        $no_of_leaves= $row['no_of_leaves'];
        $report_back_date= $row['report_back_date'];
        $request_status= $row['request_status'];
        $remarks= $row['remarks'];
          

        echo "<tr class='odd gradeX'>
        <td>$request_id</td>
        <td>$leave_type</td>
        <td>$no_of_leaves</td>
        <td>$report_back_date</td>
        <td>$request_status</td>
        <td>$remarks</td>
        </td>
    </tr>";


      }


  }



    //it will return leave request record of specific employee
    public function getPaySlipsRecordForEmployee($username){
      global $link;
  
      //get employee ID
      $arr= $this->getEmployeeDetails($username);
      $employeeID= $arr["employeeID"];
      $full_name= $arr['full_name'];
  
      $stmt= $link->prepare("SELECT * FROM `payments` WHERE paid_to= :employeeID ORDER BY id DESC");
      $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
          $stmt->execute();
        
          while($row= $stmt->fetch()){
          
          $id= $row['id'];
          $payment_reference_no= $row['payment_reference_no'];
          $paid_to= $row['paid_to'];
          $paid_amount= $row['paid_amount'];
          $payment_timestamp= $row['payment_timestamp'];
            
  
          echo "<tr class='odd gradeX'>
          <td>$payment_reference_no</td>
          <td>$paid_to</td>
          <td>$full_name</td>
          <td>Rs. $paid_amount</td>
          <td>$payment_timestamp</td>
          <td>
          <button data-id='$payment_reference_no' class='paySlipDetails icon-color'><i class='fa fa-eye'></i></button>
      </td>
          </td>
      </tr>";
  
  
        }
  
  
    }



    function getAllowances($query, $args, $id){
      if(isEmployeeValid($id)){
        global $link;

        if($query === 'forPaySlip'){


        $pay_scale= $args['pay_scale'];
        $employeeID= $args['forEmployee'];
        $username= $args['username'];
        $basic_pay= $args['basic_pay'];

        $basic_pay_echo= "<tr>
        <td> 0001 </td>
        <td> Basic Pay</td>
        <td> $basic_pay </td>
        <td> </td>
        </tr>
        ";
        $result = $basic_pay_echo;
  
        //get the allowances that are already issued to the employee
        $arr= $this->getUserData($username);
        $userID= $arr['id'];
  
        $data= $this->getEmployeeDetails($username);
        $allowancesIssued= $data['allowances'];
        $allowancesIssuedArray= explode(",", $allowancesIssued);
  
        $allowancesSQL= join("','", $allowancesIssuedArray);
  
        $stmt= $link->prepare("SELECT * FROM `allowances` WHERE allowance_code IN ('$allowancesSQL') AND pay_scale= :pay_scale");
        $stmt->bindParam(":pay_scale", $pay_scale);
        $stmt->execute();
  
        if($stmt->rowCount() == 0){
          $result= "N/A";
        }else{
      
        while($row= $stmt->fetch()){
          $id= $row['id'];
          $allowance_name= $row['allowance_name'];
          $allowance_code= $row['allowance_code'];
          $pay_scale= $row['pay_scale'];
          $allowance_percentage= $row['allowance_percentage'];
          $posted_by= $row['posted_by'];

          $allowance_amount= ($basic_pay / 100) * $allowance_percentage;
          $count= $stmt->rowCount();

            $optionValues= "<tr>
          <td> $allowance_code </td>
          <td> $allowance_name @ $allowance_percentage% </td>
          <td> $allowance_amount.00 </td>
          <td> </td>
          </tr>
          ";

          

            
          $result .= $optionValues;
          

          
  
      }
    }
      return $result;
        }



      }else{
        return 0;
        exit;
      }
     
    }



    function getDeductions($query, $args, $id){
      if(isEmployeeValid($id)){
        global $link;

        if($query === 'forPaySlip'){


        $pay_scale= $args['pay_scale'];
        $employeeID= $args['forEmployee'];
        $username= $args['username'];
        $basic_pay= $args['basic_pay'];

        $result = NULL;
  
        //get the deductions that are already issued to the employee
        $arr= $this->getUserData($username);
        $userID= $arr['id'];
  
        $data= $this->getEmployeeDetails($username);
        $deductionsIssued= $data['deductions'];
        $deductionsIssuedArray= explode(",", $deductionsIssued);
  
        $deductionsSQL= join("','", $deductionsIssuedArray);
  
        $stmt= $link->prepare("SELECT * FROM `deductions` WHERE deduction_code IN ('$deductionsSQL') AND pay_scale= :pay_scale");
        $stmt->bindParam(":pay_scale", $pay_scale);
        $stmt->execute();
  
        if($stmt->rowCount() == 0){
          $result= "N/A";
        }else{
      
        while($row= $stmt->fetch()){
          $id= $row['id'];
          $deduction_name= $row['deduction_name'];
          $deduction_code= $row['deduction_code'];
          $pay_scale= $row['pay_scale'];
          $deduction_percentage= $row['deduction_percentage'];
          $posted_by= $row['posted_by'];

          $deduction_amount= ($basic_pay / 100) * $deduction_percentage;
          $count= $stmt->rowCount();
         
            $optionValues= "<tr>
            <td style='overflow: hidden; width: 60px;'> $deduction_code </td>
            <td style='overflow: hidden; width: 300px;'> $deduction_name @ $deduction_percentage% </td>
            <td style='overflow: hidden; width: 100px;'> -$deduction_amount.00 </td>
            <td> </td>
          </tr>
          ";

          

            
          $result .= $optionValues;
          

          
  
      }
    }
      return $result;
        }



      }else{
        return 0;
        exit;
      }
     
    }




    function getSumOfAllowances($allowances, $pay_scale){
      global $link;
      $sum= 0;
         for($i=0; $i< substr_count($allowances, ",")+2; $i++){
            $arr= explode(",", $allowances);
            
            $stmt4= $link->prepare("SELECT * FROM `allowances` WHERE allowance_code= :allowance_code AND pay_scale= :pay_scale");
            $stmt4->bindParam(":allowance_code", $arr[$i], PDO::PARAM_STR);
            $stmt4->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
            $stmt4->execute();
            $row4= $stmt4->fetch();
               $allowance_percentage= $row4['allowance_percentage'];

               $sum += $allowance_percentage;
            
            
         }
         return $sum;
   }




   function getSumOfDeductions($deductions, $pay_scale){
     global $link;
    $sum= 0;
       for($i=0; $i< substr_count($deductions, ",")+2; $i++){
          $arr= explode(",", $deductions);
          
          $stmt4= $link->prepare("SELECT * FROM `deductions` WHERE deduction_code= :deduction_code AND pay_scale= :pay_scale");
          $stmt4->bindParam(":deduction_code", $arr[$i], PDO::PARAM_STR);
          $stmt4->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
          $stmt4->execute();
          $row4= $stmt4->fetch();
             $deduction_percentage= $row4['deduction_percentage'];

             $sum += $deduction_percentage;
          
          
       }
       return $sum;
 }






}

  ?>