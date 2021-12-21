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
        
        //details of registering authority
        $registered_by= $_SESSION['username'];
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
        pay_scale, profile_picture, registered_by, registered_at)
        VALUES (:username, :employeeID, :full_name, :education, :department, :designation, :pay_scale, :profile_picture, 
        :registered_by, :registered_at)");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
        $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
        $stmt->bindParam(":education", $last_education, PDO::PARAM_STR);
        $stmt->bindParam(":department", $department, PDO::PARAM_STR);
        $stmt->bindParam(":designation", $designation, PDO::PARAM_STR);
        $stmt->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
        $stmt->bindParam(":profile_picture", $profile_picture, PDO::PARAM_STR);
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
        
        
        }

            function updateUser($usernameForUpdate, $full_name, $education,
            $pay_scale, $profile_picture, $password, $contact, $email, $access_level, $account_status, $remarks){
                global $link;
                try{

                if(empty($password) === TRUE){
                    $query= $link->prepare("UPDATE `user_accounts` SET full_name= :full_name, contact_no= :contact_no,
                    email= :email, access_level= :access_level, account_status= :account_status, remarks= :remarks WHERE username=:usernameForUpdate");
                    $query->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                    $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
                    $query->bindParam(":email", $email, PDO::PARAM_STR);
                    $query->bindParam(":access_level", $access_level, PDO::PARAM_STR);
                    $query->bindParam(":account_status", $account_status, PDO::PARAM_STR);
                    $query->bindParam(":remarks", $remarks, PDO::PARAM_STR);
                    $query->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                    //update the employees table
                    $last_edit_by= $_SESSION['username'];
                    $last_edit_at= date("F j, Y, g:i a");

                    $stmt= $link->prepare("UPDATE `employees` SET full_name= :full_name, education= :education,
                    pay_scale= :pay_scale, profile_picture= :profile_picture, last_edit_by= :last_edit_by, last_edit_at= :last_edit_at
                    WHERE username=:usernameForUpdate");
                    $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                    $stmt->bindParam(":education", $education, PDO::PARAM_STR);
                    $stmt->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
                    $stmt->bindParam(":profile_picture", $profile_picture, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_by", $last_edit_by, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_at", $last_edit_at, PDO::PARAM_STR);
                    $stmt->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                if($query->execute() === TRUE AND $stmt->execute() === TRUE){
                    $_SESSION['notifStatus']= "User Updated";
                redirect_to("../../public/settings");
                }
                
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }
                }else{
                    //using default bcrypt hsahing technique
                    $password_hash= password_hash($password, PASSWORD_DEFAULT);
                
                    $query= $link->prepare("UPDATE `user_accounts` SET password_hash= :password_hash,full_name= :full_name, contact_no= :contact_no,
                    email= :email, access_level= :access_level, account_status= :account_status, remarks= :remarks WHERE username=:usernameForUpdate");
                    $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
                    $query->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                    $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
                    $query->bindParam(":email", $email, PDO::PARAM_STR);
                    $query->bindParam(":access_level", $access_level, PDO::PARAM_STR);
                    $query->bindParam(":account_status", $account_status, PDO::PARAM_STR);
                    $query->bindParam(":remarks", $remarks, PDO::PARAM_STR);
                    $query->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                    //update the employees table
                    $last_edit_by= $_SESSION['username'];
                    $last_edit_at= date("F j, Y, g:i a");

                    $stmt= $link->prepare("UPDATE `employees` SET full_name= :full_name, education= :education,
                    pay_scale= :pay_scale, profile_picture= :profile_picture, last_edit_by= :last_edit_by, last_edit_at= :last_edit_at
                    WHERE username=:usernameForUpdate");
                    $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
                    $stmt->bindParam(":education", $education, PDO::PARAM_STR);
                    $stmt->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
                    $stmt->bindParam(":profile_picture", $profile_picture, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_by", $last_edit_by, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_at", $last_edit_at, PDO::PARAM_STR);
                    $stmt->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                if($query->execute() === TRUE AND $stmt->execute() === TRUE){
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


            function updateEmployeeProfile($usernameForUpdate, $profile_picture, $password, $contact, $email){
                global $link;
                try{

                if(empty($password) === TRUE){
                    $query= $link->prepare("UPDATE `user_accounts` SET contact_no= :contact_no,
                    email= :email WHERE username=:usernameForUpdate");
                    $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
                    $query->bindParam(":email", $email, PDO::PARAM_STR);
                    $query->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                    //update the employees table
                    $last_edit_by= $_SESSION['username'];
                    $last_edit_at= date("F j, Y, g:i a");

                    $stmt= $link->prepare("UPDATE `employees` SET profile_picture= :profile_picture, last_edit_by= :last_edit_by, last_edit_at= :last_edit_at
                    WHERE username=:usernameForUpdate");
                    $stmt->bindParam(":profile_picture", $profile_picture, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_by", $last_edit_by, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_at", $last_edit_at, PDO::PARAM_STR);
                    $stmt->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                if($query->execute() === TRUE AND $stmt->execute() === TRUE){
                    $_SESSION['notifStatus']= "Profile Updated";
                redirect_to("../../public/settings");
                }
                
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/settings");
                }
                }else{
                    //using default bcrypt hsahing technique
                    $password_hash= password_hash($password, PASSWORD_DEFAULT);
                
                    $query= $link->prepare("UPDATE `user_accounts` SET password_hash= :password_hash, contact_no= :contact_no,
                    email= :email WHERE username=:usernameForUpdate");
                    $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
                    $query->bindParam(":contact_no", $contact, PDO::PARAM_STR);
                    $query->bindParam(":email", $email, PDO::PARAM_STR);
                    $query->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                    //update the employees table
                    $last_edit_by= $_SESSION['username'];
                    $last_edit_at= date("F j, Y, g:i a");

                    $stmt= $link->prepare("UPDATE `employees` SET profile_picture= :profile_picture, last_edit_by= :last_edit_by, last_edit_at= :last_edit_at
                    WHERE username=:usernameForUpdate");
                    $stmt->bindParam(":profile_picture", $profile_picture, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_by", $last_edit_by, PDO::PARAM_STR);
                    $stmt->bindParam(":last_edit_at", $last_edit_at, PDO::PARAM_STR);
                    $stmt->bindParam(":usernameForUpdate", $usernameForUpdate, PDO::PARAM_STR);

                if($query->execute() === TRUE AND $stmt->execute() === TRUE){
                    $_SESSION['notifStatus']= "Profile Updated";
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
                global $userObject;

                $arr1= $userObject->getUserData($usernameForUpdate);
                $userID= $arr1['id'];
                $arr= $userObject->getUserDetails($userID);
                $employeeID= $arr['employeeID'];
            
                $query= $link->prepare("DELETE FROM `user_accounts` WHERE username= :username;
                                        DELETE FROM `employees` WHERE username= :username;
                                        DELETE FROM `leaves_requests` WHERE employeeID= :employeeID;
                                        DELETE FROM `attendance_sheet` WHERE employeeID= :employeeID;
                                        DELETE FROM `payments` WHERE paid_to= :employeeID");
                $query->bindParam(':username', $usernameForUpdate, PDO::PARAM_STR);
                $query->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);

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


                    function markAttendance($employeeID, $punch_in_timestamp){
                        global $link;

                        $stmt= $link->prepare("INSERT INTO `attendance_sheet` (employeeID, punch_in_timestamp) 
                        VALUES (:employeeID, :punch_in_timestamp)");
                        $stmt->bindParam(":employeeID", $employeeID);
                        $stmt->bindParam(":punch_in_timestamp", $punch_in_timestamp);

                        if($stmt->execute()){
                            $_SESSION['notifStatus']= "Punched In";
                            redirect_to("../../public/attendanceManager");
                        }

                        //dispose the db connection
                        $link= NULL;
                    }


                    function markAttendanceOut($employeeID, $punch_out_timestamp, $punch_in_timestamp){
                        global $link;

                        $stmt= $link->prepare("UPDATE `attendance_sheet` SET punch_out_timestamp= :punch_out_timestamp
                         WHERE employeeID= :employeeID AND punch_in_timestamp LIKE '%$punch_in_timestamp%'");

                        $stmt->bindParam(":punch_out_timestamp", $punch_out_timestamp);
                        $stmt->bindParam(":employeeID", $employeeID);

                        if($stmt->execute()){
                            $_SESSION['notifStatus']= "Punched Out";
                            redirect_to("../../public/attendanceManager");
                        }

                        //dispose the db connection
                        $link= NULL;
                    }


                    function postLeaveSettings($designation, $allowed_leaves, $paid_leave_charges){
                        global $link;
                        
                        $query= $link->prepare("UPDATE `designations` SET allowed_leaves = :allowed_leaves, paid_leave_charges= :paid_leave_charges
                                                WHERE designation_name= :designation_name");
                        $query->bindParam(":allowed_leaves", $allowed_leaves, PDO::PARAM_INT);
                        $query->bindParam(":paid_leave_charges", $paid_leave_charges, PDO::PARAM_STR);
                        $query->bindParam(":designation_name", $designation, PDO::PARAM_STR);
                
                        if($query->execute()){
                            $_SESSION['notifStatus']= "Settings Saved";
                            redirect_to("../../public/leaveManager");
                        }
                        
                        else{
                            $_SESSION['notifStatus']= "Error";
                            redirect_to("../../public/leaveManager");
                        }
                        //dispose the db connection
                        $link= NULL;
                        }


                        function deleteLeaveSetting($designation){
                            global $link;
                        
                            $query= $link->prepare("UPDATE `designations` SET allowed_leaves= NULL, paid_leave_charges= ''
                                                    WHERE designation_name= :designation_name");
                            $query->bindParam(":designation_name", $designation, PDO::PARAM_STR);
            
                            if($query->execute() === TRUE){
                                $_SESSION['notifStatus']= "Settings Removed";
                                redirect_to("../../public/leaveManager");
                            }
                        
                            else{
                                $_SESSION['notifStatus']= "Error";
                                redirect_to("../../public/leaveManager");
                            }
            
                            //dispose the db connection
                            $link= NULL;
                        }



                        function postLeaveRequest($employeeID, $no_of_leaves, $leaves_from, $leaves_to, $leave_type, $report_back_date, $reason){
                            global $link;
                            global $userObject;

                            $leaveRequestID= $userObject->generateLeaveRequestID();
                            $leaves_from= $userObject->convertDateToEISFormat($leaves_from);
                            $leaves_to= $userObject->convertDateToEISFormat($leaves_to);
                            $report_back_date= $userObject->convertDateToEISFormat($report_back_date);
                        
                            $query= $link->prepare("INSERT INTO `leaves_requests` (request_id, employeeID, no_of_leaves, leaves_from, leaves_to, 
                            report_back_date, leave_type, reason) VALUES (:request_id, :employeeID, :no_of_leaves, :leaves_from, :leaves_to, 
                            :report_back_date, :leave_type, :reason)");
                            
                            $query->bindParam(":request_id", $leaveRequestID, PDO::PARAM_STR);
                            $query->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
                            $query->bindParam(":no_of_leaves", $no_of_leaves, PDO::PARAM_STR);
                            $query->bindParam(":leaves_from", $leaves_from, PDO::PARAM_STR);
                            $query->bindParam(":leaves_to", $leaves_to, PDO::PARAM_STR);
                            $query->bindParam(":report_back_date", $report_back_date, PDO::PARAM_STR);
                            $query->bindParam(":leave_type", $leave_type, PDO::PARAM_STR);
                            $query->bindParam(":reason", $reason, PDO::PARAM_STR);
            
                            if($query->execute() === TRUE){
                                $_SESSION['notifStatus']= "Request Submitted";
                                redirect_to("../../public/leaveManager");
                            }
                        
                            else{
                                $_SESSION['notifStatus']= "Error";
                                redirect_to("../../public/leaveManager");
                            }
            
                            //dispose the db connection
                            $link= NULL;
                        }



                          function rejectLeaveRequest($requestID, $remarks){

                            global $link;

                            //updates by
                            $supervision_by= $_SESSION['username'];
                            $supervision_timestamp= date("F j, Y, g:i a");
                            $request_status= 'Rejected';

                            $stmt= $link->prepare("UPDATE `leaves_requests` SET request_status= :request_status, remarks= :remarks, 
                            supervision_by= :supervision_by, supervision_timestamp= :supervision_timestamp WHERE request_id= :request_id");
                            $stmt->bindParam(":request_status", $request_status, PDO::PARAM_STR);
                            $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
                            $stmt->bindParam(":supervision_by", $supervision_by, PDO::PARAM_STR);
                            $stmt->bindParam(":supervision_timestamp", $supervision_timestamp, PDO::PARAM_STR);
                            $stmt->bindParam(":request_id", $requestID, PDO::PARAM_STR);

                            if($stmt->execute() === TRUE){
                                $_SESSION['notifStatus']= "Request Rejected";
                                redirect_to("../../public/leaveManager");
                            }else{
                                $_SESSION['notifStatus']= "Error";
                                redirect_to("../../public/leaveManager");
                            }
            
                            //dispose the db connection
                            $link= NULL;

                            
                        }



                        function approveLeaveRequest($requestID, $remarks){

                            global $link;

                            //updates by
                            $supervision_by= $_SESSION['username'];
                            $supervision_timestamp= date("F j, Y, g:i a");
                            $request_status= 'Approved';

                            $stmt= $link->prepare("UPDATE `leaves_requests` SET request_status= :request_status, remarks= :remarks, 
                            supervision_by= :supervision_by, supervision_timestamp= :supervision_timestamp WHERE request_id= :request_id");
                            $stmt->bindParam(":request_status", $request_status, PDO::PARAM_STR);
                            $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
                            $stmt->bindParam(":supervision_by", $supervision_by, PDO::PARAM_STR);
                            $stmt->bindParam(":supervision_timestamp", $supervision_timestamp, PDO::PARAM_STR);
                            $stmt->bindParam(":request_id", $requestID, PDO::PARAM_STR);

                            if($stmt->execute() === TRUE){
                                $_SESSION['notifStatus']= "Request Approved";
                                redirect_to("../../public/leaveManager");
                            }else{
                                $_SESSION['notifStatus']= "Error";
                                redirect_to("../../public/leaveManager");
                            }
            
                            //dispose the db connection
                            $link= NULL;

                            
                        }



                        
            function postAllowances($allowance_code, $pay_scale, $allowance_name, $allowance_amount){
                global $link;
                $posted_by= $_SESSION['username'];
                $posted_timestamp= date("F j, Y, g:i a");

                if($allowance_code == '0001' OR $allowance_code == '0002'){
                    $arr= array("Error", "Allowance Code is Reserved.");
                    $_SESSION['notifStatus']= $arr;
                    redirect_to("../../public/payroll");
                }else{
                
                $query= $link->prepare("INSERT INTO `allowances` (allowance_code, pay_scale, allowance_name, allowance_percentage, posted_by, posted_timestamp) 
                VALUES (:allowance_code, :pay_scale, :allowance_name, :allowance_percentage, :posted_by, :posted_timestamp)");
                $query->bindParam(":allowance_code", $allowance_code, PDO::PARAM_STR);
                $query->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
                $query->bindParam(":allowance_name", $allowance_name, PDO::PARAM_STR);
                $query->bindParam(":allowance_percentage", $allowance_amount, PDO::PARAM_STR);
                $query->bindParam(":posted_by", $posted_by, PDO::PARAM_STR);
                $query->bindParam(":posted_timestamp", $posted_timestamp, PDO::PARAM_STR);
        
                if($query->execute()){
                    $_SESSION['notifStatus']= "Allowance Added";
                    redirect_to("../../public/payroll");
                }
                
                else{
                    $_SESSION['notifStatus']= "Error";
                    redirect_to("../../public/payroll");
                }
                //dispose the db connection
                $link= NULL;
            }
                }



                function deleteAllowances($allowance_ID){
                    global $link;
                
                    $query= $link->prepare("DELETE FROM `allowances` WHERE id= :allowance_ID");
                    $query->bindParam(':allowance_ID', $allowance_ID, PDO::PARAM_INT);
    
                    if($query->execute() === TRUE){
                        $arr= array("Allowance Deleted");
                        $_SESSION['notifStatus']= $arr;
                        redirect_to("../../public/payroll");
                    }
                
                    else{
                        $_SESSION['notifStatus']= "Error";
                        redirect_to("../../public/payroll");
                    }
    
                    //dispose the db connection
                    $link= NULL;
                }




                function postDeductions($deduction_code, $deduction_name, $deduction_type, $deduction_amount, $pay_scale){
                    global $link;
                    $posted_by= $_SESSION['username'];
                    $posted_timestamp= date("F j, Y, g:i a");

                    if($deduction_code == '0001' OR $deduction_code == '0002'){
                        $arr= array("Error", "Deduction Code is Reserved.");
                        $_SESSION['notifStatus']= $arr;
                        redirect_to("../../public/payroll");
                    }else{
                    
                    $query= $link->prepare("INSERT INTO `deductions` (deduction_code, deduction_name, deduction_type, deduction_percentage, pay_scale, posted_by, posted_timestamp) 
                    VALUES (:deduction_code, :deduction_name, :deduction_type, :deduction_percentage, :pay_scale, :posted_by, :posted_timestamp)");
                    $query->bindParam(":deduction_code", $deduction_code, PDO::PARAM_STR);
                    $query->bindParam(":deduction_name", $deduction_name, PDO::PARAM_STR);
                    $query->bindParam(":deduction_type", $deduction_type, PDO::PARAM_STR);
                    $query->bindParam(":deduction_percentage", $deduction_amount, PDO::PARAM_STR);
                    $query->bindParam(":pay_scale", $pay_scale, PDO::PARAM_STR);
                    $query->bindParam(":posted_by", $posted_by, PDO::PARAM_STR);
                    $query->bindParam(":posted_timestamp", $posted_timestamp, PDO::PARAM_STR);
            
                    if($query->execute()){
                        $_SESSION['notifStatus']= "Deduction Added";
                        redirect_to("../../public/payroll");
                    }
                    
                    else{
                        $_SESSION['notifStatus']= "Error";
                        redirect_to("../../public/payroll");
                    }
                    //dispose the db connection
                    $link= NULL;
                }
                    }
    
    
    
                    function deleteDeductions($deduction_ID){
                        global $link;
                    
                        $query= $link->prepare("DELETE FROM `deductions` WHERE id= :deduction_ID");
                        $query->bindParam(':deduction_ID', $deduction_ID, PDO::PARAM_INT);
        
                        if($query->execute() === TRUE){
                            $arr= array("Deduction Deleted");
                            $_SESSION['notifStatus']= $arr;
                            redirect_to("../../public/payroll");
                        }
                    
                        else{
                            $_SESSION['notifStatus']= "Error";
                            redirect_to("../../public/payroll");
                        }
        
                        //dispose the db connection
                        $link= NULL;
                    }



                    function updatePaymentSettings($employeeID, $allowances, $deductions){
                        global $link;

                        $stmt= $link->prepare("SELECT allowances FROM `employees` WHERE employeeID= :employeeID");
                        $stmt->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
                        $stmt->execute();
                        while($row = $stmt->fetch()){
                            $issuedAllowances= $row['allowances'];
                        }

                        $stmt2= $link->prepare("SELECT deductions FROM `employees` WHERE employeeID= :employeeID");
                        $stmt2->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
                        $stmt2->execute();
                        while($row2 = $stmt2->fetch()){
                            $issuedDeductions= $row2['deductions'];
                        }

                            $query= $link->prepare("UPDATE `employees` SET allowances = 
                                                    CASE 
                                                    WHEN allowances IS NULL THEN '$allowances'
                                                    WHEN allowances IS NOT NULL THEN CONCAT(allowances, ',', '$allowances')
                                                    END 
                                                    WHERE employeeID= :employeeID");
                            $query->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
                    
                            
                            if($query->execute()){
                                $stmt3= $link->prepare("UPDATE `employees` SET deductions = 
                                                    CASE 
                                                    WHEN deductions IS NULL THEN '$deductions'
                                                    WHEN deductions IS NOT NULL THEN CONCAT(deductions, ',', '$deductions')
                                                    END 
                                                    WHERE employeeID= :employeeID");
                            $stmt3->bindParam(":employeeID", $employeeID, PDO::PARAM_STR);
                            if($stmt3->execute()){
                                    $arr= array("Settings Saved");
                                   $_SESSION['notifStatus']= $arr;
                                   redirect_to("../../public/payroll");

                            }

                            }
                        
                        //dispose the db connection
                        $link= NULL;
                        }



                        function makePayment($paid_to, $paid_amount, $paid_allowances, $paid_allowances_amount, $paid_deductions, $paid_deductions_amount){
                            global $link;
                            global $userObject;

                            $payment_made_by= $_SESSION['username'];
                            $payment_timestamp= date("F j, Y, g:i a");

                            //generate payment reference no
                            $payment_reference_no= $userObject->generatePaymentReferenceNo();
                            
                            $query= $link->prepare("INSERT INTO `payments` (payment_reference_no, paid_to, paid_amount, paid_allowances, 
                                                    paid_allowances_amount, paid_deductions, paid_deductions_amount, payment_made_by, payment_timestamp) 
                            VALUES (:payment_reference_no, :paid_to, :paid_amount, :paid_allowances, :paid_allowances_amount, :paid_deductions, 
                            :paid_deductions_amount, :payment_made_by, :payment_timestamp)");

                            $query->bindParam(":payment_reference_no", $payment_reference_no, PDO::PARAM_STR);
                            $query->bindParam(":paid_to", $paid_to, PDO::PARAM_STR);
                            $query->bindParam(":paid_amount", $paid_amount, PDO::PARAM_STR);
                            $query->bindParam(":paid_allowances", $paid_allowances, PDO::PARAM_STR);
                            $query->bindParam(":paid_allowances_amount", $paid_allowances_amount, PDO::PARAM_STR);
                            $query->bindParam(":paid_deductions", $paid_deductions, PDO::PARAM_STR);
                            $query->bindParam(":paid_deductions_amount", $paid_deductions_amount, PDO::PARAM_STR);
                            $query->bindParam(":payment_made_by", $payment_made_by, PDO::PARAM_STR);
                            $query->bindParam(":payment_timestamp", $payment_timestamp, PDO::PARAM_STR);
                    
                            if($query->execute()){
                                $arr= array("Payment Successful", "Ref #: $payment_reference_no");
                                $_SESSION['notifStatus']= $arr;
                                redirect_to("../../public/payroll");
                            }
                            
                            else{
                                $_SESSION['notifStatus']= "Payment Error";
                                redirect_to("../../public/payroll");
                            }
                            //dispose the db connection
                            $link= NULL;
                            }
                       









    
?>