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






}

  ?>