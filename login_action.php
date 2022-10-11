<?php
    session_start() ; 
    include_once "connect_data_base.php" ; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $output = '' ; 
        $user_uname = $_REQUEST["user_uname"] ; 
        $user_password = $_REQUEST['user_password'] ; 
        if(!isset($user_uname) || empty($user_uname)){
            $output = '<div class="alert alert-danger">Enter your <strong>username</strong></div>' ; 
        }elseif(!isset($user_password) && empty($user_password) || strlen($user_password) < 7){
            $output = '<div class="alert alert-danger">Enter your <strong>password > 7</strong> characters</div>' ; 
        }else{
            //no error
            $hashed_password = sha1($user_password) ; 
            $stmt = $con->prepare("SELECT * FROM users WHERE user_user_name = '$user_uname' && user_password = '$hashed_password'") ; 
            $stmt->execute() ; 
            $data = $stmt->fetch()  ;
            if(!$stmt->rowCount()){
                //no sign up user
                $output = '<div class="alert alert-danger">Wrong <strong>Username/Password</strong></div>' ; 
            }
        }
        if(isset($output) && $output != ''){
            echo $output ; 
        }else{
            $_SESSION['user_id'] = $data['user_id'] ; 
            $_SESSION['user_uname'] = $data['user_user_name'] ; 
        }
    }else{
        echo "your don't allowed to be here" ; 
    }

?>