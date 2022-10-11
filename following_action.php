<?php
    session_start() ; 
    include_once "connect_data_base.php" ; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sender_id = $_REQUEST["sender_id"] ; 
        $receiver_id = $_REQUEST['receiver_id'] ; 
        $mood = $_REQUEST['mood'] ; 

        if($mood=="follow"){
            $stmt = $con->prepare("INSERT INTO followers(follower_sender_id, follower_recever_id) VALUES(?, ?)") ; 
            $stmt->execute(array($sender_id, $receiver_id)) ; 
        }else{
            $stmt = $con->prepare("DELETE FROM followers WHERE `followers`.`follower_sender_id` = ? AND `followers`.`follower_recever_id` =?") ; 
            $stmt->execute(array($sender_id, $receiver_id)) ; 
        }
        
        $stmt = $con->prepare("SELECT * FROM followers WHERE follower_recever_id= ?") ; 
        $stmt->execute(array($receiver_id)) ;
        $count = $stmt->rowCount() ; 
        echo $count ; 
    }else{
        echo "your don't allowed to be here" ; 
    }

?>