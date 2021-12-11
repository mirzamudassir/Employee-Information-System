<?php 


define("PRIVATE", TRUE);
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/view/renderView.php');

renderView($_SESSION['id'], $_SESSION['accessLevel'], 'LeaveManager');


?>