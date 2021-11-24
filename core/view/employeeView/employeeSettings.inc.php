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
                                 <?php $arr= $userObject->getUserData($_SESSION['username']); ?>
                                 <div class="row show-grid">
                                
                                <div class="col-md-4 col-md-offset-4">
                                <table>
        <thead>
            <tr>
                <th>Full Name : </th>
                <th><?php echo $arr['full_name']; ?></b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td> Username : </td>
            <td><?php echo $arr['username']; ?></b></td>
            </tr>
            <tr>
                <td>Designation : </td>
                <td><?php echo $arr['designation']; ?></b></td>
            </tr>
            <tr>
                <td>Contact No : </td>
                <td><?php echo $arr['contact']; ?></b></td>
            </tr>
        </tbody>
        
    </table>
                                
                                <br>
                                <br>
                                </div>
                            </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="settings">
                                    <h4>Access Denied!</h4>
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
    
</body>

</html>
