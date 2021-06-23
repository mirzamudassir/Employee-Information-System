<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/includes/global_info.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/modal/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/view/employeeView/employeeModals.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/view/employeeView/employeeNav.php');


before_every_protected_page();
$arr= getUserData($_SESSION['username']); 

error_reporting(E_ALL); // Error/Exception engine, always use E_ALL
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