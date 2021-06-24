<?php
require_once(APP_ROOT . "/modal/initialize.php");

    function postUser($username, $full_name, $last_education, $department,
    $designation, $profile_picture, $password, $contact, $email){
        global $link;
        
        //using default bcrypt hsahing technique
        $password_hash= password_hash($password, PASSWORD_DEFAULT);
        $query= $link->prepare("INSERT INTO `user_accounts` (username, password_hash, full_name, designation, contact_no)
        VALUES (:username, :password_hash, :full_name, :designation, :contact_no)");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam(":full_name", $full_name, PDO::PARAM_STR);
        $query->bindParam(":designation", $designation, PDO::PARAM_STR);
        $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);

        if($query->execute()){
            $_SESSION['notifStatus']= "User Saved";
            redirect_to("../../public/settings");
        }
        
        else{
            $_SESSION['notifStatus']= "Error";
            redirect_to("../../public/settings");
        }
        //dispose the db connection
        $link= NULL;
        }

            function updateUser($id, $password, $full_name, $designation, $contact){
                global $link;
                try{

                if($password==''){
                    $query= $link->prepare("UPDATE `user_accounts` SET full_name= :full_name, designation= :designation, contact_no= :contact_no WHERE id=:id");
                    $query->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                    $query->bindParam(":designation", $designation, PDO::PARAM_STR);
                    $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
                    $query->bindParam(":id", $id, PDO::PARAM_INT);

                if($query->execute() === TRUE){
                    $_SESSION['notifStatus']= "User Updated";
                redirect_to("../../public/settings");
                }
                
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }
                }else{
                
                $password_hash= password_hash($password, PASSWORD_DEFAULT);
                $query= $link->prepare("UPDATE `user_accounts` SET password_hash= :password_hash, full_name= :full_name, designation= :designation, contact_no= :contact_no WHERE id=:id");
                $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
                $query->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                $query->bindParam(":designation", $designation, PDO::PARAM_STR);
                $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
                $query->bindParam(":id", $id, PDO::PARAM_INT);

                if($query->execute() === TRUE){
                    $_SESSION['notifStatus']= "User Updated";
                redirect_to("../../public/settings");
                }
                
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }
                
                }

                    }catch(PDOExeption $ex){
                            echo "ERROR";
                    }

                    //dispose the db connection
                    $link= NULL;
            }

            function deleteUser($id){
                global $link;
            
                $query= $link->prepare("DELETE FROM `user_accounts` WHERE id= :id");
                $query->bindParam(':id', $id, PDO::PARAM_STR);

                if($query->execute() === TRUE){
                    $_SESSION['notifStatus']= "User Deleted";
                    redirect_to("../../public/settings");
                }
            
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }

                //dispose the db connection
                $link= NULL;
            }

            function deleteDepartment($deptID){
                global $link;
            
                $query= $link->prepare("DELETE FROM `departments` WHERE id= :id");
                $query->bindParam(':id', $deptID, PDO::PARAM_INT);

                if($query->execute() === TRUE){
                    $_SESSION['notifStatus']= "Department Deleted";
                    redirect_to("../../public/settings");
                }
            
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }

                //dispose the db connection
                $link= NULL;
            }


            function deleteDesignation($desigID){
                global $link;
            
                $query= $link->prepare("DELETE FROM `designations` WHERE id= :id");
                $query->bindParam(':id', $desigID, PDO::PARAM_INT);

                if($query->execute() === TRUE){
                    $_SESSION['notifStatus']= "Designation Deleted";
                    redirect_to("../../public/settings");
                }
            
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }

                //dispose the db connection
                $link= NULL;
            }



            function postDesignation($designation_name, $pay_scale){
                global $link;
                
                $query= $link->prepare("INSERT INTO `designations` (designation_name, pay_scale) VALUES (:designation_name, :pay_scale)");
                $query->bindParam(":designation_name", $designation_name, PDO::PARAM_STR);
                $query->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
        
                if($query->execute()){
                    $_SESSION['notifStatus']= "Designation Added";
                    redirect_to("../../public/settings");
                }
                
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }
                //dispose the db connection
                $link= NULL;
                }

            
                function postDepartment($department_code, $department_name, $visibility){
                    global $link;
                    
                    $query= $link->prepare("INSERT INTO `departments` (department_code, department_name, visibility) VALUES (:department_code, :department_name, :visibility)");
                    $query->bindParam(":department_code", $department_code, PDO::PARAM_STR);
                    $query->bindParam(":department_name", $department_name, PDO::PARAM_STR);
                    $query->bindParam(":visibility", $visibility, PDO::PARAM_STR);
            
                    if($query->execute()){
                        $_SESSION['notifStatus']= "Department Added";
                        redirect_to("../../public/settings");
                    }
                    
                    else{
                        $_SESSION['notifStatus']= "Error";
                        redirect_to("../../public/settings");
                    }
                    //dispose the db connection
                    $link= NULL;
                    }
    
?>