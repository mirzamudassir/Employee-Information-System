<?php 
/**
 * @
 */
ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/project/core/modal/initialize.php');

function isAdminValid($userID){

    if(isset($_SESSION['username']) AND $_SESSION['username']){

    global $link;

    $stmt= $link->prepare("SELECT id, username, access_level, account_status FROM `user_accounts` WHERE id= :id");
    $stmt->bindParam(":id", $userID, PDO::PARAM_STR);
    $stmt->execute();

    if($row= $stmt->fetch()){
        $id= $row['id'];
        $username= $row['username'];
        $access_level= $row['access_level'];
        $account_status= $row['account_status'];

        if($access_level==='ADMIN' AND $account_status=== 'ACTIVE'){

        return true;
        }else{
            header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
            return false;
        }

    }else{
        header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
        return false;
    }
    
}

else{
    header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
    return false;
}

//dispose the database connection
$link= NULL;
}



function isEmployeeValid($userID){

    if(isset($_SESSION['username']) AND $_SESSION['username']){

    global $link;

    $stmt= $link->prepare("SELECT id, username, access_level, account_status FROM `user_accounts` WHERE id= :id");
    $stmt->bindParam(":id", $userID, PDO::PARAM_STR);
    $stmt->execute();

    if($row= $stmt->fetch()){
        $id= $row['id'];
        $username= $row['username'];
        $access_level= $row['access_level'];
        $account_status= $row['account_status'];

        if($access_level==='USER' AND $account_status=== 'ACTIVE'){

        return true;
        }else{
            header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED($account_status)");
            exit();
            return false;
        }

    }else{
        header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
        return false;
    }
    
}

else{
    header("Location: http://localhost:8080/project/public/error?error=ERR_ACCESS_DENIED");
            exit();
    return false;
}

//dispose the database connection
$link= NULL;
}


function isUserAlreadyExist($username){
    global $link;

    $stmt= $link->prepare("SELECT username FROM `user_accounts` WHERE username= :username");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }

    //dispose the db connection
    $link= NULL;
}

?>