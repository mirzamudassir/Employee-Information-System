<?php
require_once("../modal/initialize.php");
global $link;

if(isset($_GET['f'])){
$func= $_GET['f'];
switch($func){
        case 'postUser':

            $username= trim($_POST['username']);
            $full_name= trim($_POST['full_name']);
            $password= trim($_POST['password']);
            $designation= trim($_POST['designation']);
            $contact= trim($_POST['contact']);
    
            postUser($username, $password, $full_name, $designation, $contact);
            break;
        case 'updateUser':

            $id= trim($_POST['id']);
            $full_name= trim($_POST['full_name']);
            $password= trim($_POST['password']);
            $designation= trim($_POST['designation']);
            $contact= trim($_POST['contact']);

            if(isset($_POST['deleteUser'])){
                deleteUser($id);
            }else{
    
            UpdateUser($id, $password, $full_name, $designation, $contact);
            }
            break;

        case 'postDepartment':

            $department_code= trim($_POST['department_code']);
            $department_name= trim($_POST['department_name']);
            $visibility= trim($_POST['visibility']);
    
            postDepartment($department_code, $department_name, $visibility);
            break;

        case 'deleteDepartment':

            $deptID= trim($_POST['id']);
    
            deleteDepartment($deptID);
            break;

        case 'postDesignation':

            $designation_name= trim($_POST['designation_name']);
            $pay_scale= trim($_POST['pay_scale']);
    
            postDesignation($designation_name, $pay_scale);
            break;

        case 'deleteDesignation':

            $desgID= trim($_POST['id']);
    
            deleteDesignation($desgID);
            break;

    default:

    echo "ERROR: ERR_DATAPARSER";


}
}
?>