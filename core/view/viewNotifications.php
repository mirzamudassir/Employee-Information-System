<?php

function loggedInStatus(){
    if(isset($_GET['flag'])){
        $flag= $_GET['flag'];
        if($flag==true){
        echo "<div class='alert alert-success alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            Successfully Logged In.
                        </div>";
        }
    }
}
?>