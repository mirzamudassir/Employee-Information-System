<?php 
require_once '../includes/global_info.inc.php'; 
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $app_title; ?></title>
    <!-- Core CSS - Include with every page -->
    <link href="../assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
   <link href="../assets/css/style.css" rel="stylesheet" />
      <link href="../assets/css/main-style.css" rel="stylesheet" />

</head>

<body class="body-Login-back">

    <div class="container">
       
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <h1><?php echo $app_heading; ?></h1>
              <h3 style="color:white;">(<?php echo $app_title; ?>)</h3>
                </div>
               
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">      
                <?php if(isset($_SESSION['error'])){
                           echo "<div class='alert alert-danger'>
                            Invalid Credentials.
                        </div>";
                        session_unset();
                        session_destroy();
                            } ?>
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Log In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="../core/modal/Auth/validate" method="POST" accept-charset="utf-8">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" required autofocus autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="pwd" type="password" required autocomplete="off">
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login" class="btn btn-lg btn-success btn-block" value="Login">
                            </fieldset>
                        </form>
                        
                    </div>
                </div>
                <footer>&copy; <?php echo date('Y'); echo $footer; ?></footer>
            </div>

        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
    <script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>

</body>

</html>
