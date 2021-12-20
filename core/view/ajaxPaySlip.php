<?php
require_once("../modal/initialize.php");

if(isset($_POST['paymentRefNo'])){

    $paymentRefNo= $_POST['paymentRefNo'];

    $stmt= $link->prepare("SELECT * FROM `payments` WHERE payment_reference_no= :payment_reference_no");
    $stmt->bindParam(":payment_reference_no", $paymentRefNo, PDO::PARAM_STR);
    $stmt->execute();

    while($row= $stmt->fetch()){
        $id= $row['id'];
        $payment_reference_no = $row['payment_reference_no'];
        $paid_to = $row['paid_to'];
        $paid_amount = $row['paid_amount'];
        $paid_allowances = $row['paid_allowances'];
        $paid_allowances_amount = $row['paid_allowances_amount'];
        $paid_deductions = $row['paid_deductions'];
        $paid_deductions_amount = $row['paid_deductions_amount'];
        $payment_timestamp = $row['payment_timestamp'];
    }

    $stmt2= $link->prepare("SELECT * FROM `employees` WHERE employeeID= :employeeID");
    $stmt2->bindParam(":employeeID", $paid_to, PDO::PARAM_STR);
    $stmt2->execute();
    while($row2 = $stmt2->fetch()){
        $id= $row2['id'];
        $username = $row2['username'];
        $full_name = $row2['full_name'];
        $employeeID = $row2['employeeID'];
        $department = $row2['department'];
        $designation = $row2['designation'];
        $pay_scale = $row2['pay_scale'];
    }

    $stmt3= $link->prepare("SELECT basic_salary FROM `designations` WHERE designation_name= :designation");
    $stmt3->bindParam(":designation", $designation, PDO::PARAM_STR);
    $stmt3->execute();
    while($row3 = $stmt3->fetch()){
        $basic_pay = $row3['basic_salary'];
    }

    //to be used to call methods
    $userObject= new EmployeeController();
    $userDetails= $userObject->getEmployeeDetails($username);

    $contact= $userDetails['contact_no'];
    $email= $userDetails['email'];
    $account_status = $userDetails['account_status'];


date_default_timezone_set("Asia/Karachi");
$current_date= date('F-Y');
$current_time= date('g:i A');

$basic_pay_name= "Basic Pay";
$basic_pay_amount= "148000.00";
$basic_pay_code= "0001";
$income_tax_name= "Income Tax @ 15%";
$income_tax_amount= "22200.00";
$income_tax_code= "3101";

$deductions= "Income Tax @ 15%";



$payee_name= $full_name;
$organization_name= "Employee Information System V1.0";

$arr= explode(',', $payment_timestamp, 2);
$forTheMonthOf= $arr[0];

$sumOfAllowances= ($basic_pay / 100) * $userObject->getSumOfAllowances($paid_allowances, $pay_scale);
$sumOfDeductions= ($basic_pay / 100) * $userObject->getSumOfDeductions($paid_deductions, $pay_scale);

$gross_pay= $basic_pay + $sumOfAllowances;
$deductions= $sumOfDeductions;
$net_pay= $paid_amount;

//leave Charges
$leave_charges= ($gross_pay - $net_pay) - $deductions;
$deductions= $deductions + $leave_charges;

//get the allowances and deductions of employee
$allowancesList= $userObject->getAllowances("forPaySlip", array("pay_scale"=>$pay_scale, 'forEmployee'=>$employeeID, 'username'=>$username, 'basic_pay'=>$basic_pay), $_SESSION['id']);
$deductionsList= $userObject->getDeductions("forPaySlip", array("pay_scale"=>$pay_scale, 'forEmployee'=>$employeeID, 'username'=>$username, 'basic_pay'=>$basic_pay), $_SESSION['id']);

echo "

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>PaySlip</title>
    <style>

        body{
            margin-right: 2%;
            margin-left: 2%;
        }

        .top-heading{
            font-size: 2em;
            text-align: center;
        }

        .top-sub-heading{
            font-size: 1.1em;
            text-align: center;
        }

        .content-headings{
            font-size: 1.1em;
        }

        .personal-info-table{
   
            width: 100%;
            margin-bottom: 3%;
        }

        .payment-details-table{
   
            width: 100%;
            margin-top: 5%;
            margin-bottom: 5%;
        }

        .pay-table{
            border: 1px solid black;
            width: 100%;
            margin-bottom: 3%;
            border-collapse: collapse;
        }

        table.pay-table th{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        table.pay-table td{
            border: 1px solid black;
            border-collapse: collapse;
            padding-left: 1%;
        }

    

    </style>
</head>
<body>

    <h1 class='top-heading'>$organization_name</h1>
    <h2 class='top-sub-heading'>Monthly Salary Statement ($forTheMonthOf) </h2><br>

    <h2 class='content-headings'>Personal Information of&nbsp  $full_name </h2><br>

    <table class='personal-info-table'>
        <tr>
            <td><b>Employee ID:</b>  $employeeID </td>
            <td><b>Department:</b>  $department </td>
            <td></td>
        </tr>
        <tr>
            <td><b>Designation:</b>  $designation </td>
            <td><b>Pay Scale:</b>  $pay_scale </td>
            <td><b>Status:</b>  $account_status </td>
        </tr>
        <tr>
            <td><b>Contact #:</b>  $contact </td>
            <td><b>Email:</b>  $email </td>
            <td></td>
        </tr>
    </table>

    <h2 class='content-headings'>Pay and Allowances:</h2><br>

    <table class='pay-table'>
        <tr>
            
            <th colspan='2'><b>Wage Type</b></th>
            <th><b>Amount</b></th>

            <th colspan='3'><b>Calculations</b></th>
        </tr>
        <tr>
            $allowancesList
        </tr>
    </table>

    <h2 class='content-headings'>Deductions:</h2><br>

    <table class='pay-table'>
        <tr>
            
            <th colspan='2'><b>Wage Type</b></th>
            <th><b>Amount</b></th>

            <th colspan='3'><b>Calculations</b></th>
        </tr>
        <tr>
        $deductionsList
        </tr>
        <tr>
        <td style='overflow: hidden; width: 60px;'> 0002 </td>
            <td style='overflow: hidden; width: 300px;'> Leave Charges </td>
            <td style='overflow: hidden; width: 100px;'> -$leave_charges.00 </td>
            <td> </td>
          </tr>
        </tr>
    </table>


    <table class='payment-details-table'>
        <tr>
            <td><b>Gross Pay (Rs.):</b>  $gross_pay.00 </td>
            <td><b>Deductions (Rs.):</b>  -$deductions.00 </td>
            <td><b>Net Pay (Rs.):</b>  $net_pay </td>
        </tr>
    </table>

    <div>
        <p><b>Payee Name: </b> $full_name </p>
        <p><b>Employee #: </b> $employeeID </p>
        <p><b>Payment Ref #: </b> $payment_reference_no </p>
        <p><b>Issue Date: </b> $payment_timestamp </p>
    </div>
    
</body>
</html>

";

    }
?>