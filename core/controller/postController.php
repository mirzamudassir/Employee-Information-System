<?php
require_once(APP_ROOT . "/modal/initialize.php");
$userObject= new UserController();

    function postUser($username, $full_name, $last_education, $department,
    $designation, $profile_picture, $password, $contact, $email, $access_level, $account_status){
        global $link;
        global $userObject;

        if(isUserAlreadyExist($username) === FALSE){
        
        //using default bcrypt hsahing technique
        $password_hash= password_hash($password, PASSWORD_DEFAULT);

        //generates the Employee ID
        $employeeID= $userObject->generateEmployeeID();

        //get the pay scale and net salary according to designation
        $data= $userObject->getEmployeeScaleAndSalary($designation);
        $pay_scale= $data["pay_scale"];
        $basic_salary= $data["basic_salary"];

        $profile_picture_link= substr($profile_picture, 3);
        
        //details of registering authority
        $registered_by= $_SESSION['full_name'];
        $registered_at= date("F j, Y, g:i a");


        //first insert the relevant data in user_accounts table that will manage login
        $query= $link->prepare("INSERT INTO `user_accounts` (username, password_hash, full_name, designation, contact_no, email, 
        access_level, account_status)
        VALUES (:username, :password_hash, :full_name, :designation, :contact_no, :email, :access_level, :account_status)");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam(":full_name", $full_name, PDO::PARAM_STR);
        $query->bindParam(":designation", $designation, PDO::PARAM_STR);
        $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":access_level", $access_level, PDO::PARAM_STR);
        $query->bindParam(":account_status", $account_status, PDO::PARAM_STR);

        //secondly insert the relevant data in employees table
        $stmt= $link->prepare("INSERT INTO `employees` (username, employeeID, full_name, education, department, designation, 
        pay_scale, basic_salary, profile_picture, registered_by, registered_at)
        VALUES (:username, :employeeID, :full_name, :education, :department, :designation, :pay_scale, :basic_salary, :profile_picture, 
        :registered_by, :registered_at)");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
        $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
        $stmt->bindParam(":education", $last_education, PDO::PARAM_STR);
        $stmt->bindParam(":department", $department, PDO::PARAM_STR);
        $stmt->bindParam(":designation", $designation, PDO::PARAM_STR);
        $stmt->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
        $stmt->bindParam(":basic_salary", $basic_salary, PDO::PARAM_STR);
        $stmt->bindParam(":profile_picture", $profile_picture_link, PDO::PARAM_STR);
        $stmt->bindParam(":registered_by", $registered_by, PDO::PARAM_STR);
        $stmt->bindParam(":registered_at", $registered_at, PDO::PARAM_STR);
    
   
        if($query->execute()){
            if($stmt->execute()){

                    $arr= array("User Registered", "Welcome Email has been sent with instructions.");
                    $_SESSION['notifStatus']= $arr;
                    redirect_to("../../public/settings");
                
               
            }else{
            $arr= array("Error", "Internal Server Error");
            $_SESSION['notifStatus']= $arr;
            redirect_to("../../public/settings");
            }
        }
        
        else{
            $arr= array("Error", "Internal Server Error");
            $_SESSION['notifStatus']= $arr;
            redirect_to("../../public/settings");
        }
    
    }else{
        $arr= array("Error", "Username already Exist.");
        $_SESSION['notifStatus']= $arr;
            redirect_to("../../public/settings");
    }
        //dispose the db connection
        $link= NULL;
        //dispose the userObject
        $userObject= NULL;
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
                    $arr= array("Error", "Error Updating User. Try again.");
            $_SESSION['notifStatus']= $arr;
                    redirect_to("../../public/settings");
                }
                
                }

                    }catch(PDOExeption $ex){
                            echo "ERROR";
                    }

                    //dispose the db connection
                    $link= NULL;
            }

            function deleteUser($usernameForUpdate){
                global $link;
            
                $query= $link->prepare("DELETE FROM `user_accounts` WHERE username= :username;
                                        DELETE FROM `employees` WHERE username= :username");
                $query->bindParam(':username', $usernameForUpdate, PDO::PARAM_STR);

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
                    $arr= array("Department Deleted", "Department is permanently deleted.");
                    $_SESSION['notifStatus']= $arr;
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



            function postDesignation($designation_name, $pay_scale, $basic_salary){
                global $link;
                
                $query= $link->prepare("INSERT INTO `designations` (designation_name, pay_scale, basic_salary) 
                VALUES (:designation_name, :pay_scale, :basic_salary)");
                $query->bindParam(":designation_name", $designation_name, PDO::PARAM_STR);
                $query->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
                $query->bindParam(":basic_salary", $basic_salary, PDO::PARAM_STR);
        
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
                        $arr= array("Department Added", "$department_name is successfully registered.");
                        $_SESSION['notifStatus']= $arr;
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