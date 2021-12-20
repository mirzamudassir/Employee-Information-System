<?php
require_once 'employeeHeader.inc.php';
before_every_protected_page();
$employeeControllerObject= new UserController();
$arr= $employeeControllerObject->getUserData($_SESSION['username']); 

$userDetails= $employeeControllerObject->getUserDetails($_SESSION['id']);
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <!-- Core CSS - Include with every page -->
    <link href="../assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
      <link href="../assets/css/main-style.css" rel="stylesheet" />
      <script src="../assets/scripts/jquery-3.4.1.min.js" type="text/javascript"></script>

</head>

<body>


  <!-- Modal Alert Start -->
  <div class="modal fade" id="userProfile" tabindex="-1" role="dialog" aria-labelledby="userProfile" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Welcome <?php echo $_SESSION['username']; ?></h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                       <?php 
                                            $user= $employeeControllerObject->getUserData($_SESSION['username']);
                                            echo "Name: " . $user['full_name'] . "<br>";
                                            echo "Designation: " . $user['designation'] . "<br>";
                                            echo "Contact No: " . $user['contact'] . "<br>";
                                       ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Modal Alrt End -->

                         <!-- Mark Attendance Modal Alert Start -->
<div class="modal fade" id="markAttendance" tabindex="-1" role="dialog" aria-labelledby="markAttendance" aria-hidden="true">
                                <div class="modal-dialog" style="width:60%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> Mark Attendance</h4>
                                        </div>
                                        <div class="modal-body">
                                        <form action="../core/view/dataParser?f=markAttendance" method="POST">
                                        <div class="form-group to-left-20">
                                            <label>Emp. # <span class="title-red">*</span></label>
                                            <input class="form-control" name="employeeID" value='<?php echo $userDetails['employeeID']; ?>' type="varchar" disabled>
                                            <input type='hidden' value='<?php echo $userDetails['employeeID']; ?>' name='employeeID'>
                                        </div>
                                        <div class="form-group to-left-51">
                                            <label>Full Name <span class="title-red">*</span></label>
                                            <input class="form-control" name="full_name" value='<?php echo $userDetails['full_name']; ?>' type="varchar" disabled>
                                            
                                        </div>
                            
                                        <div class="form-group to-left-70">
                                            <label>Current Timestamp <span class="title-red">*</span></label>
                                            <input class="form-control" name="designation" value='<?php echo date("F j, Y, g:i a"); ?>' type="varchar" disabled>
                                            <input type='hidden' value='<?php echo date("F j, Y, g:i a"); ?>' name='punch_in_timestamp'>
                                        </div>

                                       <input type="submit" name="punchIn" class="btn btn-success button-right-50" value="Punch In">
                                        </form>
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Mark Attendance Modal Alrt End -->


                        <!-- Mark Attendance Out Modal Alert Start -->
<div class="modal fade" id="markAttendanceOut" tabindex="-1" role="dialog" aria-labelledby="markAttendanceOut" aria-hidden="true">
                                <div class="modal-dialog" style="width:60%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> Mark Attendance</h4>
                                        </div>
                                        <div class="modal-body">
                                        <?php
                                            $attendanceStatus= $employeeControllerObject->getAttendanceStatus('', $userDetails['employeeID'], date("F j, Y"));
                                            if($attendanceStatus === 'DENIED'){ ?>
                                                <label class='title-red'> You have already Punched Out.</label>

                                            <?php }else{ ?>

                                        <form action="../core/view/dataParser?f=markAttendanceOut" method="POST">
                                        <div class="form-group to-left-20">
                                            <label>Emp. # <span class="title-red">*</span></label>
                                            <input class="form-control" name="employeeID" value='<?php echo $userDetails['employeeID']; ?>' type="varchar" disabled>
                                            <input type='hidden' value='<?php echo $userDetails['employeeID']; ?>' name='employeeID'>
                                        </div>
                                        <div class="form-group to-left-51">
                                            <label>Full Name <span class="title-red">*</span></label>
                                            <input class="form-control" name="full_name" value='<?php echo $userDetails['full_name']; ?>' type="varchar" disabled>
                                            
                                        </div>

                                        <div class="form-group to-left-70">
                                            <label>Punch In Timestamp <span class="title-red">*</span></label>
                                            <input class="form-control" name="punch_in_timestamp" value='<?php echo $employeeControllerObject->getAttendanceStatus('details', $userDetails['employeeID'], date("F j, Y")) ?>' type="varchar" readonly>
                                        </div>
                            
                                        <div class="form-group to-left-70">
                                            <label>Current Punch Out Timestamp <span class="title-red">*</span></label>
                                            <input class="form-control" name="punch_out_timestamp" value='<?php echo date("F j, Y, g:i a"); ?>' type="varchar" disabled>
                                            <input type='hidden' value='<?php echo date("F j, Y, g:i a"); ?>' name='punch_out_timestamp'>
                                        </div>

                                       <input type="submit" name="punchOut" class="btn btn-success button-right-50" value="Punch Out">
                                        </form>

                                            <?php } ?>
                                        
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Mark Attendance Out Modal Alrt End -->

                         <!-- Make Leave Request Modal Alert Start -->
    <div class="modal fade" id="makeLeaveRequest" tabindex="-1" role="dialog" aria-labelledby="makeLeaveRequest" aria-hidden="true">
                                <div class="modal-dialog" style="width:50%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Make Leave Request</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                        <form action="../core/view/dataParser?f=postLeaveRequest" method="POST">

                                        <div class="form-group to-left-50">
                                            <label>Emp # <span class="title-red">*</span></label>
                                            <input class="form-control" value='<?php echo $userDetails['employeeID']; ?>' type="varchar" disabled>
                                            <input type='hidden' value='<?php echo $userDetails['employeeID']; ?>' name='employeeID'>
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>Leave Type <span class="title-red"> *</span></label>
                                            <select class="form-control" name="leave_type" required>
                                            <option value='Casual Leave'>Casual Leave</option>
                                            <option value='Emergency Leave'>Emergency Leave</option>
                                            <option value='Paid Leave'>Paid Leave</option>
                                            </select>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>No of Leaves <span class="title-red"> *</span></label>
                                        <input class="form-control" name="no_of_leaves" type="number" min="0" required>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Leave(s) From <span class="title-red">*</span></label>
                                            <input class="form-control" name="leaves_from" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime("+6 months"));?>" type="date" required>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Leave(s) To <span class="title-red">*</span></label>
                                            <input class="form-control" name="leaves_to" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime("+6 months"));?>" type="date" required>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Report Back Date<span class="title-red">*</span></label>
                                            <input class="form-control" name="report_back_date" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime("+6 months"));?>" type="date" required>
                                           
                                        </div>
                                        

                                       

                                        <div class="form-group to-left-90">
                                            <label>Reason <span class="title-red">*</span></label>
                                            <input class="form-control" name="reason" type="varchar" autocomplete="off" required>
                                            
                                        </div>
                                        
                                        <div style="color: green"> Allowed Leaves (Per Month): <?php echo $userDetails['allowed_leaves']; ?></div>
                                        <div style="color: red"> Paid Leave Charges (Per Leave): <?php echo $userDetails['paid_leave_charges'] . " PKR"; ?></div>
                         
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <input type="submit" name="submit" class="btn btn-success button-right-50" value="Submit">
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Make Leave Request Modal Alrt End -->







                        <?php require_once 'employeeFooter.inc.php' ?>

                        <script>

$(document).ready(function(){

$("#txt_username").keyup(function(){

    var username = $(this).val().trim();

  if(username != ''){

     $.ajax({
        url: '../core/view/ajaxcheckUsername',
        type: 'post',
        data: {username:username},
        success: function(response){

           // Show response
           $("#uname_response").html(response);

        }
     });
  }else{
     $("#uname_response").html("");
  }

});

});

$(document).ready(function(){

$("#txt_password").keyup(function(){

    var password = $(this).val().trim();

  if(password != ''){

     $.ajax({
        url: '../core/view/ajaxcheckUsername',
        type: 'post',
        data: {password:password},
        success: function(response){

           // Show response
           $("#uname_response").html(response);

        }
     });
  }else{
     $("#uname_response").html("");
  }

});

});
                        </script>
</body>
</html>