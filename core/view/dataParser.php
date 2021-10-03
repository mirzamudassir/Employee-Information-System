<?php
require_once("../modal/initialize.php");
global $link;

if(isset($_GET['f'])){
$func= $_GET['f'];

switch($func){

        case 'postUser':
            $folderToUploadPicture= "../../assets/img/profilePictures/";

            $username= trim($_POST['username']);
            $full_name= trim($_POST['full_name']);
            $last_education= trim($_POST['last_education']);
            $department= trim($_POST['department']);
            $designation= trim($_POST['designation']);
            $profile_picture= $folderToUploadPicture . basename($_FILES['profile_picture']['name']);
            $picture_tmpName= $_FILES['profile_picture']['tmp_name'];
            $password= trim($_POST['password']);
            $contact= trim($_POST['contact']);
            $email= trim($_POST['email']);
            $access_level= trim($_POST['access_level']);
            $account_status= trim($_POST['account_status']);

            $imageFileType = strtolower(pathinfo($profile_picture,PATHINFO_EXTENSION));

             // Allow certain file formats
             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {

                $arr= array("Error", "Only JPG, PNG file types are allowed.");
                        $_SESSION['notifStatus']= $arr;
                        redirect_to("../../public/settings");
                }else{

                    // Check file size, max upload size is 1MB
                    if ($_FILES["profile_picture"]["size"] < 1000000) {
                    

                            if(move_uploaded_file($picture_tmpName, $profile_picture)){
            
                                postUser($username, $full_name, $last_education, $department,
                                $designation, $profile_picture, $password, $contact, $email, $access_level, $account_status);
                            }else{
                                    $arr= array("Error", "There is an error in uploading Image.");
                                    $_SESSION['notifStatus']= $arr;
                                    redirect_to("../../public/settings");
                                }
                    

                            
                    }else{
                        $arr= array("Error", "Image file size should be less than 1 MB");
                        $_SESSION['notifStatus']= $arr;
                        redirect_to("../../public/settings");
                    }
                }
            break;



        case 'updateUser':

            $usernameForUpdate= trim($_POST['usernameForUpdate']);
            $full_name= trim($_POST['full_name']);
            $password= trim($_POST['password']);
            $designation= trim($_POST['designation']);
            $contact= trim($_POST['contact']);

            if(isset($_POST['deleteUser'])){
                deleteUser($usernameForUpdate);
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
            $salary= trim($_POST['basic_salary']);
            $basic_salary= $salary . ".00";
    
            postDesignation($designation_name, $pay_scale, $basic_salary);
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