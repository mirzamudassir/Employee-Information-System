<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/modal/initialize.php');

function renderView($userID, $accessLevel, $callBackURL){
    global $sessSalt;
    $rootAdrr= $_SERVER['DOCUMENT_ROOT'];
    
    switch($accessLevel){
        case 'ADMIN':

            if(isAdminValid($userID) === TRUE){
                
                $sessID= session_id() . $sessSalt;
                include "$rootAdrr/project/core/view/adminView/admin$callBackURL.inc.php";

            }else{
                header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
                exit();
                return false;
            }

            break;

        
        case 'USER':
            
            if(isEmployeeValid($userID) === TRUE){

                $sessID= session_id() . $sessSalt;
                include "$rootAdrr/project/core/view/employeeView/employee$callBackURL.php";
            }else{
                header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
                exit();
                return false;
            }

            break;
        
            default:
            header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
                exit();
            return false;
            
    }

}




?>