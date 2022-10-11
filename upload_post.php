<?php
    session_start() ; 
    ini_set('display_errors', 'On') ;
    error_reporting(E_ALL) ; 
    include_once "connect_data_base.php" ; 

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_SESSION['user_id'] ; 
        $user_post = $_REQUEST['user_post'] ;
        
        // check if user name was found already
        $output = '' ; 
        if(strlen($user_post) == 0 ){
            $output = 'error' ; 
        }
        


        if(isset($output) && $output != ''){
            echo $output ; 
        }else{
            
            $query = "INSERT INTO posts(post_user_id, post_content) VALUES(?, ?)" ; 
            $stmt = $con->prepare($query) ; 
            $stmt->execute(array($user_id, $user_post)) ;
            //fetch all
            $query = "SELECT * FROM posts INNER JOIN users ON user_id = post_user_id ORDER BY post_date DESC LIMIT 1"; 
            $stmt = $con->prepare($query) ; 
            $stmt->execute() ;
            $data = $stmt -> fetchAll() ; 
            foreach ($data as $row) {
                $output .= '<div class="row post">
                                <div class="col-4">
                                    <img src="assets/uploads/'.$row['user_profile_image'].'" class="img-fluid" alt="notfound">
                                </div>
                                <div class="col-8">
                                    <h5>@'.$row['user_user_name'].'</h5>
                                    <p>'.$row['post_content'].'</p>
                                </div>
                            </div><hr>' ; 
            }
            
            // $output = '<div class="alert alert-success">Post <strong>Successfully</strong> Created</div>' ; 
            
            echo $output ; 
        }
        
    }else{
        echo "don't allowed being here" ; 
    }
?>
