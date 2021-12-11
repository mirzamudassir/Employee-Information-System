<?php 
require_once 'employeeHeader.inc.php';
$userObject= new UserController();
?>
<style>
        table {
            width: 500px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard">
                    <h1> <?php echo $app_heading; ?> </h1>
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-3x"></i>
                    </a>
                   <!-- dropdown user--> 
                   <?php echo $dropDownMenu; ?>
                    <!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->
            
        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                            <img src="<?php echo $arr['profile_picture']; ?>" alt="Profile Picture" height='50px' width='60px'> 
                            </div>
                            <div class="user-info">
                                <div><h4><?php echo $arr['username']; ?></h4></div>
                                <div class="user-text-online">
                                    <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Online
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li class="sidebar-search">
                        <!-- search section-->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!--end search section-->
                    </li>
                   <?php echo $mainMenu; ?>                    
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Profile</h1>

                                        <!--Basic Tabs   -->
                                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Personal Information
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#profile" data-toggle="tab">Profile</a>
                                </li>
                                <li><a href="#settings" data-toggle="tab">Settings</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="profile">
                                 <?php $detail= $userObject->getUserData($_SESSION['username']); 
                                 $arr= $userObject->getUserDetails($detail['id']);
                                 ?>
                                 
    
                                 <table style='width:100%; padding-top: 10%; font-size: 1em; display:inline-block;'>
         <th style='line-height: 2em; padding-bottom: 3%;'>
         <u style='font-weight: bold; text-align: center;'>Personal Information</u>
         </th>
         
         <tr style='line-height: 2em;'>
         <td><b>Emp # :</b> <?php echo $arr['employeeID'] ?> </td>
         <td><b>Username:</b> <?php echo $arr['username'] ?></td>
         <td><b>Full Name :</b> <?php echo $arr['full_name'] ?> </td>
         </tr>

         <tr style='line-height: 2em;'>
         <td><b>Department :</b> <?php echo $arr['department'] ?> </td>
         <td><b>Username:</b> <?php echo $arr['designation'] ?></td>
         <td><b>Full Name :</b> <?php echo $arr['pay_scale'] ?> </td>
         </tr>

         <tr style='line-height: 2em;'>
         <td><b>Account Status :</b> <?php echo $arr['account_status'] ?> </td>
         <td><b>Contact #:</b> <?php echo $arr['contact_no'] ?></td>
         <td><b>Email :</b> <?php echo $arr['email'] ?> </td>
         </tr>
         
         </table>

                                
                               
                                    
                                </div>
                                <div class="tab-pane fade" id="settings">
                                        <!-- Update User Record Modal Alert Start -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> Update Profile</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                       
                                        
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        <!-- Update User Record Modal Alrt End -->
                                <button data-id='<?php echo $_SESSION['id'] ?>' class='userinfo icon-color' style='margin-top: 10%;'>Update Profile <i class='fa fa-edit'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Basic Tabs   -->
                </div>
                <!--End Page Header -->
            </div>        

           </div>  
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <?php require_once 'employeeFooter.inc.php' ?>



    <script>
   $(document).ready(function(){    
 $("body").on("click", ".userinfo", function(event){ 

  
  var userid = $(this).data('id');

  // AJAX request
  $.ajax({
   url: '../core/view/ajaxUpdateEmployeeProfile',
   type: 'post',
   data: {userid: userid},
   success: function(response){ 
     // Add response in Modal body
     $('.modal-body').html(response);

     // Display Modal
     $('#updateModal').modal('show');  
     
   }

});
$("body").on("click", "#close", function(event){ 

$('#updateModal').modal('hide');
location.reload();
});
});


});    

</script>


    
</body>

</html>
