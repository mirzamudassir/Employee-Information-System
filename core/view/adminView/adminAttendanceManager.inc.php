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
                            <img src="<?php echo $arr['profile_picture']; ?>" alt="Profile Picture" height='50px' width='60px'>
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
                    <?php $userObject->getNotification(); 
                    //check for which modal content to show for attendance
                    $arr= $userObject->getUserDetails($_SESSION['id']);
                    $employeeID= $arr['employeeID'];
                    if($userObject->getAttendanceStatus('', $employeeID) === TRUE){
                        echo "<button type='button' class='btn btn-primary button-left-50' data-toggle='modal' data-target='#markAttendance'>Mark Attendance <i class='fa fa-plus fa-fw'></i></button>";
                    }else{
                        echo "<button type='button' class='btn btn-primary button-left-50' data-toggle='modal' data-target='#markAttendanceOut'>Mark Attendance <i class='fa fa-plus fa-fw'></i></button>";
                    }
                    ?>
                    <button type='button' class='btn btn-primary button-left-50' data-toggle='modal' data-target='#attendanceRecord'>Attendance Record <i class="fa fa-history fa-fw"></i></button>
                    <button class="btn btn-primary button-left-50" id="printAttendanceTable" onclick='printData()'>Print <i class="fa fa-print fa-fw"></i></button>
                                    <!-- Advanced Tables -->
                                    <div class="panel panel-default"  id="printTable">
                        <div class="panel-heading">
                             Attendance Sheet as of <?php echo date('F j, Y'); ?>
                        </div>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Emp #</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Punch In</th>
                                            <th>Punch Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $userObject->getTodayAttendanceSheet(); ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                       
                </div>
                <!--End Page Header -->
            </div>        

           </div>  
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <?php require_once 'adminFooter.inc.php' ?>


</body>

</html>
