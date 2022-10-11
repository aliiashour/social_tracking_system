<?php
    ini_set('display_errors', 'On') ;
    error_reporting(E_ALL) ; 
    include_once "connect_data_base.php" ; 

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_name = $_REQUEST['user_name'] ;
        $user_uname = $_REQUEST['user_uname'] ;
        $user_email = $_REQUEST['user_email'] ;
        $user_password = $_REQUEST['user_password'] ; 
        
        // check if user name was found already
        $output = '' ; 
        if(strlen($user_name) == 0 ){
            $output = '<div class="alert alert-danger">You should enter your <strong>name</strong></div>' ; 
        }elseif(strlen($user_uname) == 0 ){
            $output = '<div class="alert alert-danger">You should enter your <strong>username</strong></div>' ; 
        }elseif(strlen($user_email) == 0 || !filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            $output= '<div class="alert alert-danger">You should enter <strong>valid email</strong></div>' ; 
        }elseif(strlen($user_password) <= 7 ){
            $output = '<div class="alert alert-danger">You password should be <strong>>7</strong> characters</div>';
        }else{
            $stmt = $con->prepare("SELECT * FROM users WHERE user_user_name = '$user_uname'") ; 
            $stmt->execute() ;
            $count = $stmt->rowCount() ; 
            if($count > 1 ){
                $output = '<div class="alert alert-danger">This <strong>username</strong> is already Exist</div>' ; 
            }
        }
        


        if(isset($output) && $output != ''){
            echo $output ; 
        }else{
            //add in database
            $user_hashed_password = sha1($user_password) ; 
            $query = "INSERT INTO `users` (`user_user_name`, `user_name`, `user_email`, `user_password`) VALUES
                    ('".$user_uname."', '".$user_name."', '".$user_email."', '".$user_hashed_password."')" ;
            $stmt = $con->prepare($query) ;
            $stmt ->execute() ; 
            echo $output ; 
        }
        
    }else{
        echo "don't allowed being here" ; 
    }
?>
