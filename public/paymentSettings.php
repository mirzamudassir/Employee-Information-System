<?php 


define("PRIVATE", TRUE);
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/view/renderView.php');

if($_SESSION['accessLevel'] === 'ADMIN'){
renderView($_SESSION['id'], $_SESSION['accessLevel'], 'PaymentSettings');
}else{
    header('Location: http://localhost/project/public/error?error=PAGE_NOT_FOUND(404)'); 
}

?>