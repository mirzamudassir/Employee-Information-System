<?php 


define("PRIVATE", TRUE);
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/view/renderView.php');

if($_SESSION['accessLevel'] === 'ADMIN'){
renderView($_SESSION['id'], $_SESSION['accessLevel'], 'Payroll');
}else{
    header('Location: http://localhost:8080/project/public/error?error=PAGE_NOT_FOUND(404)'); 
}

?>