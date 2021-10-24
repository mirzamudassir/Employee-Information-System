<?php 
require_once 'adminHeader.inc.php';
$userObject= new UserController();
$employeeObject= new EmployeeController();
?>

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
                   <ul class="dropdown-menu dropdown-user">
                        <li><a href="javascript:void(0)" data-toggle="modal" data-target="#userProfile"><i class="fa fa-user fa-fw"></i>Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i>Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="javascript:void(0)" onclick="location.href='../core/modal/Auth/logout'"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul>
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
                                <img src="../assets/img/user.jpg" alt="">
                            </div>
                            <div class="user-info">
                                <div><h4><?php $arr= $userObject->getUserData($_SESSION['username']); 
                                echo $arr['full_name']; ?></h4></div>
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
                    <h1 class="page-header">Attendance Manager</h1>
                    <?php $userObject->getNotification(); ?>
                    <button type="button" class="btn btn-primary button-left-50" data-toggle="modal" data-target="#addUser">Mark Attendance</button>
                    <button type="button" class="btn btn-primary button-left-50" data-toggle="modal" data-target="#manageDepartments">View Attendance Sheet</button>
                                    <!-- Advanced Tables -->
                                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Attendance Sheet as of <?php echo date('F j, Y'); ?>
                        </div>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Full Name</th>
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $employeeObject->getEmployeesList(); ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->

<!-- Update User Record Modal Alert Start -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> Update User Record</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                       
                                        
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        <!-- Update User Record Modal Alrt End -->
    
<!-- View User Record Modal Alert Start -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
                                <div class="modal-dialog" style="width:60%">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> View User Record</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                       
                                        
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        <!-- View User Record Modal Alrt End -->
                       
                </div>
                <!--End Page Header -->
            </div>        

           </div>  
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <?php require_once 'adminFooter.inc.php' ?>
    
    <script>
   $(document).ready(function(){    
 $("body").on("click", ".userinfo", function(event){ 

  
  var userid = $(this).data('id');

  // AJAX request
  $.ajax({
   url: '../core/view/ajaxUpdateUser',
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

<script>
   $(document).ready(function(){    
 $("body").on("click", ".userdetail", function(event){ 

  
  var userid = $(this).data('id');

  // AJAX request
  $.ajax({
   url: '../core/view/ajaxDetailUser',
   type: 'post',
   data: {userid: userid},
   success: function(response){ 
     // Add response in Modal body
     $('.modal-body').html(response);

     // Display Modal
     $('#detailModal').modal('show');  
     
   }

});
$("body").on("click", "#close", function(event){ 

$('#detailModal').modal('hide');
location.reload();
});
});


});    

</script>

</body>

</html>
