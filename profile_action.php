<?php
    ini_set('display_errors', 'On') ;
    error_reporting(E_ALL) ; 
    include_once "connect_data_base.php" ; 

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_REQUEST['user_id'] ;
        $user_name = $_REQUEST['user_name'] ;
        $user_uname = $_REQUEST['user_uname'] ;
        $user_email = $_REQUEST['user_email'] ;
        $user_image = $_FILES['user_image']['name'] ;
        $user_bio = $_REQUEST['user_bio'] ;
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
        }
        $image_name = pathinfo($_FILES['user_image']['name'], PATHINFO_BASENAME) ; 

        if(isset($image_name) && $image_name != ''){

            $valid_image_extensions = ["jpg", "png", "jpeg"] ; 
            $image_extension = strtolower(pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION)) ; 
            $image_to_upload = uniqid().$image_name ; 
            if(in_array($image_extension, $valid_image_extensions)){
                $dest = "assets/uploads/" . $image_to_upload ; 
                move_uploaded_file($_FILES['user_image']['tmp_name'], $dest) ; 
            }else{
                $output = '<div class="alert alert-danger">Enetr valid <strong>Image(jpg, jpeg, png)</strong></div>';
            }
    
        }









        if(isset($output) && $output != ''){
            echo $output ; 
        }else{
            
            $query = "UPDATE `users` SET `user_user_name` = ?, `user_name` = ?, `user_email` = ?, user_profile_image=?, `user_password` = 
            ?, `user_bio` = ? WHERE `users`.`user_id` = ?" ; 
            $user_hashed_password = sha1($user_password) ; 
            $stmt = $con->prepare($query) ; 
            $stmt->execute(array($user_uname, $user_name, $user_email, $image_to_upload, $user_hashed_password, $user_bio, $user_id)) ;
            if($stmt->rowCount()){
                $output = '<div class="alert alert-success">Data <strong>Successfully</strong> Edited</div>' ; 
            }
            echo $output ; 
        }
        
    }else{
        echo "don't allowed being here" ; 
    }
?>
