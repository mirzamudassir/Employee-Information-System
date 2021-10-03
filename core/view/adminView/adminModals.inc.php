<?php
require_once 'adminHeader.inc.php';
before_every_protected_page(); 
$userControllerObject= new UserController();
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
                                            $user= $userControllerObject->getUserData($_SESSION['username']);
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

                          <!-- Add User Modal Alert Start -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
                                <div class="modal-dialog" style="width:50%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add User</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                        <form action="../core/view/dataParser?f=postUser" method="POST" enctype="multipart/form-data">

                                        <div class="form-group to-left-50">
                                            <label>Username <span class="title-red">*</span></label>
                                            <input class="form-control" id="txt_username" name="username" type="text" minlength="4" maxlength="15" required>
                                            
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Full Name <span class="title-red">*</span></label>
                                            <input class="form-control" name="full_name" type="varchar" maxlength="30" required>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Last Education <span class="title-red">*</span></label>
                                            <input class="form-control" name="last_education" type="varchar" maxlength="30" required>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>Department <span class="title-red"> *</span></label>
                                            <select class="form-control" name="department" required>
                                            <option value="NULL"> -- Select -- </option>
                                            <?php $userControllerObject->getDepartmentsValues($_SESSION['id']); ?>
                                            </select>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>Designation <span class="title-red"> *</span></label>
                                            <select class="form-control" name="designation" required>
                                            <option value="NULL"> -- Select -- </option>
                                            <?php $userControllerObject->getDesignationValues($_SESSION['id']); ?>
                                            </select>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>Profile Picture <span class="title-red"> *</span></label>
                                        <input class="form-control" name="profile_picture" id="profile_picture" type="file" required>
                                           
                                        </div>

                                       
                                        <div class="form-group to-left-50">
                                        <label>Password <span class="title-red"> *</span></label>
                                        <input class="form-control" id="txt_password" name="password" type="password" minlength="6" maxlength="20" required>
                                           
                                        </div>
                                        

                                        <div class="form-group to-left-50">
                                            <label>Contact # <span class="title-red">*</span></label>
                                            <input class="form-control" name="contact" type="text" minlength="11" maxlength="15" required>
                                            
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Email <span class="title-red">*</span></label>
                                            <input class="form-control" name="email" type="email" required>
                                            
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>Access Level <span class="title-red"> *</span></label>
                                            <select class="form-control" name="access_level" required>
                                            <option value="NULL"> -- Select -- </option>
                                            <option value='ADMIN'>ADMIN</option>
                                            <option value='USER'>USER</option>
                                            </select>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                        <label>Account Status <span class="title-red"> *</span></label>
                                            <select class="form-control" name="account_status" required>
                                            <option value="NULL"> -- Select -- </option>
                                            <option value='ACTIVE'>ACTIVE</option>
                                            <option value='DISABLED'>DISABLED</option>
                                            <option value='DORMANT'>DORMANT</option>
                                            </select>
                                           
                                        </div>
                                        <div id="uname_response" ></div>
                         
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <input type="submit" name="add" class="btn btn-success button-right-50" value="Save">
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Add User Modal Alrt End -->


                         <!-- Manage Departments Modal Alert Start -->
<div class="modal fade" id="manageDepartments" tabindex="-1" role="dialog" aria-labelledby="manageDepartments" aria-hidden="true">
                                <div class="modal-dialog" style="width:60%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> Manage Departments</h4>
                                        </div>
                                        <div class="modal-body">
                                        <form action="../core/view/dataParser?f=postDepartment" method="POST">
                                        <div class="form-group to-left-20">
                                            <label>Dept. Code <span class="title-red">*</span></label>
                                            <input class="form-control" name="department_code" type="varchar" maxlength="30" required>
                                           
                                        </div>
                                        <div class="form-group to-left-20">
                                            <label>Dept. Name <span class="title-red">*</span></label>
                                            <input class="form-control" name="department_name" type="varchar" maxlength="30" required>
                                           
                                        </div>
                                        <div class="form-group to-left-20">
                                        <label>Visibility<span class="title-red"> *</span></label>
                                            <select class="form-control" name="visibility" required>
                                            <option> Visible </option>
                                            <option> Hidden </option>
                                                
                                            </select>
                                           
                                        </div>

                                       <input type="submit" name="add" class="btn btn-success button-right-50" value="Add">
                                        </form>

                                        <div class="table-responsive">
                                         <table class="table table-striped table-bordered table-hover" id="dataTabless-example">
                                        <thead>
                                        <th> Dept. Code </th>
                                        <th> Dept. Name </th>
                                        <th> Employees </th>
                                        <th> Visibility </th>
                                        <th> Action </th>
                                        </thead>
                                        <tbody>
                                        <?php $userControllerObject->getDepartments($_SESSION['id']); ?>
                                        </tbody>
                                        </table>
                                        </div>
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Manage Departments Modal Alrt End -->


                           <!-- Manage Designations Modal Alert Start -->
<div class="modal fade" id="manageDesignations" tabindex="-1" role="dialog" aria-labelledby="manageDesignations" aria-hidden="true">
                                <div class="modal-dialog" style="width:60%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> Manage Designations</h4>
                                        </div>
                                        <div class="modal-body">
                                        <form action="../core/view/dataParser?f=postDesignation" method="POST">
                                        <div class="form-group to-left-20">
                                            <label>Designation Name <span class="title-red">*</span></label>
                                            <input class="form-control" name="designation_name" type="varchar" maxlength="30" required>
                                           
                                        </div>
                                        <div class="form-group to-left-20">
                                        <label>Pay Scale<span class="title-red"> *</span></label>
                                            <select class="form-control" name="pay_scale" required>
                                            <option> --- SELECT --- </option>
                                            <option> BPS 10 </option>
                                            <option> BPS 09 </option>
                                            <option> BPS 08 </option>
                                            <option> BPS 07 </option>
                                            <option> BPS 06 </option>
                                            <option> BPS 05 </option>
                                            <option> BPS 04 </option>
                                            <option> BPS 03 </option>
                                            <option> BPS 02 </option>
                                            <option> BPS 01 </option>
                                            </select>
                                        </div>

                                        <div class="form-group to-left-20">
                                            <label>Basic Salary <span class="title-red">*</span></label>
                                            <input class="form-control" name="basic_salary" type="number" maxlength="20" placeholder="Format: 100000" required>
                                           
                                        </div>

                                       <input type="submit" name="add" class="btn btn-success button-right-50" value="Add">
                                        </form>

                                        <div class="table-responsive">
                                         <table class="table table-striped table-bordered table-hover" id="dataTabless-examplee">
                                        <thead>
                                        <th> Desig. Name </th>
                                        <th> Pay Scale </th>
                                        <th> Basic Salary </th>
                                        <th> Employees </th>
                                        <th> Action </th>
                                        </thead>
                                        <tbody>
                                        <?php $userControllerObject->getDesignations($_SESSION['id']); ?>
                                        </tbody>
                                        </table>
                                        </div>
                                        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Manage Designations Modal Alrt End -->





                        <?php require_once 'adminFooter.inc.php' ?>

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