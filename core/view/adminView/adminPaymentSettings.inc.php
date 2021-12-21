<?php 
require_once 'adminHeader.inc.php';
$userObject= new UserController();
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
                    <h1 class="page-header">Payment Settings</h1>
                    <?php $userObject->getNotification(); ?>
                    <!--Basic Tabs   -->
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            
                            <div class="tab-content">
                                <div class="tab-pane fade in active">

                   <table class="payroll-table">
                    <tr class="payroll-table-tr">

                            <td class='payroll-table-td'>
                        <form action='' method='POST' id='searchPaymentSettings' name='searchPaymentSettings'>
                        <input type='varchar' name='employeeIDForPaymentSettings' id='employeeID' class='form-control to-left-50' autocomplete='off' required>
                        <input type='submit' name='employeeIDForPaymentSettings' class='btn btn-success button-right-50' data-id='' value='Search'>
                        </form>
                        </td>
                            
                    </tr>

                    <tr>
                        <td class="payroll-table-td">
                        <div id="paymentSettingsResult">Enter the Employee ID to change payment settings.</div>
                        </td>
                    </tr>

                   </table>

                   
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

    <?php require_once 'adminFooter.inc.php' ?>

<script>
    $(document).ready(function(){

$("#searchPaymentSettings").submit(function(event){
    event.preventDefault();
     $.ajax({
        url: '../core/view/ajaxFetchDataForPaymentSettings',
        type: 'post',
        data: $('form').serialize(),
        success: function(response){

            // Add response in Modal body
            $('#paymentSettingsResult').html(response);

        }
     });

});

});


//delete Allowances and Deductions
$(document).ready(function(){    
 $("body").on("click", ".deleteAllowance", function(event){ 

  
  var json = $(this).data('id');
  var data= [];
  for(var i in json)
    data.push([i, json[i]]);
 

 var employeeID= data[0];
 var allowance= data[1];
 var query= data[2]

 $.ajax({
        url: '../core/view/ajaxManagePaymentSettings',
        type: 'post',
        data: {employeeID: employeeID, allowance: allowance, query: query},
        success: function(response){

            //reload the current view
            $.ajax({
        url: '../core/view/ajaxFetchDataForPaymentSettings',
        type: 'post',
        data: $('form').serialize(),
        success: function(response){

            // Add response in Modal body
            $('#paymentSettingsResult').html(response);

        }
     });



        }
     });



});


});    

window.onload= function(){
    var employeeID= sessionStorage.getItem("employeeID");
    if(employeeID){
        document.getElementById("employeeID").value= employeeID;
        $(document).ready(function(){
                $("#searchPaymentSettings").submit();
            });
        sessionStorage.removeItem("employeeID");
    }else{
    document.getElementById("employeeID").value= "EIS-";
    }
}

function goBack() {
    window.history.back(-1);
}
                        
                        </script>
    
</body>

</html>
