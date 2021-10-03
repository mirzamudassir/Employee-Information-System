<?php
require_once 'employeeHeader.php';
before_every_protected_page();
$userObject= new UserController();
$arr= $userObject->getUserData($_SESSION['username']); 
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
                                            $user= $userObject->getUserData($_SESSION['username']);
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
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add User</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                        <form action="../core/view/dataParser?f=postUser" method="POST">

                                        <div class="form-group to-left-50">
                                            <label>Username <span class="title-red">*</span></label>
                                            <input class="form-control" id="txt_username" name="username" type="text" minlength="4" maxlength="15" required>
                                            
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Full Name <span class="title-red">*</span></label>
                                            <input class="form-control" name="full_name" type="varchar" maxlength="30" required>
                                           
                                        </div>
                                        
                                        <div class="form-group to-left-50">
                                        <label>Password <span class="title-red"> *</span></label>
                                        <input class="form-control" id="txt_password" name="password" type="password" minlength="6" maxlength="20" required>
                                           
                                        </div>
                                        
                                        <div class="form-group to-left-50">
                                        <label>Designation <span class="title-red"> *</span></label>
                                            <select class="form-control" name="designation" required>
                                            <option value="NULL"> -- Select -- </option>
                                            <option value="Administrator"> Administrator </option>
                                            <option value="Employee"> Employee </option>
                                            </select>
                                           
                                        </div>

                                        <div class="form-group to-left-50">
                                            <label>Contact # <span class="title-red">*</span></label>
                                            <input class="form-control" name="contact" type="text" minlength="11" maxlength="15" required>
                                            
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

                        <?php require_once 'employeeFooter.php' ?>

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