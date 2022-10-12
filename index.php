<?php
    session_start() ; 
    $page_title= 'Twitter' ; 
    include_once "init.php" ; 
    $user_in_session = false ; 
    if(isset($_SESSION['user_uname']) && $_SESSION['user_uname'] != ''){
        $user_in_session= true ; 
    }
?>

        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Twitter</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item dropdown">
                        <?php
                            if($user_in_session){
                                ?>
                                    <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $_SESSION['user_uname'] ; ?>
                                    </a>
                                <?php
                            }else{
                                ?>
                                    <a class="nav-link" href="login.php" role="button">
                                        <?php  echo 'login' ?>
                                    </a>
                                <?php
                            }
                                    
                            ?>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="./profile.php">Profile</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="logout.php">Logout</a>
                                </li>
                            </ul>

                    </li>
                </ul>
                </div>
            </div>
        </nav>

   
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 mt-5 mb-5">
                    <?php
                        if($user_in_session){
                            ?>
                                <div class="mb-5">
                                    <span id="response"></span>
                                    <form method="post" id="create_post_form">
                                        <div class="form-floating mb-3">
                                            <input type="text" value="<?php echo $_SESSION['user_id']?>" hidden id="user_id">
                                            <textarea class="form-control" placeholder="Create New Post Now" id="user_post" name="user_post" style="height: 100px"></textarea>
                                            <label for="user_post">New Post</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="post_button">Post</button>
                                    </form>
                                </div>
                            <?php
                        }
                    
                    ?>
                    
                    <div class="">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Trending</div>
                            <div class="panel-body" id="users_posts">
                                <?php
                                    $query = "SELECT * FROM posts INNER JOIN users ON user_id = post_user_id ORDER BY post_date DESC"; 
                                    $stmt = $con->prepare($query) ; 
                                    $stmt->execute() ;
                                    $data = $stmt -> fetchAll() ; 
                                    foreach ($data as $row) { 
                                        echo '<div class="row post">
                                                        <div class="col-4">
                                                            <img src="./assets/uploads/' .$row['user_profile_image'].'" class="img-fluid" alt="notfound">
                                                        </div>
                                                        <div class="col-8">
                                                            <h5>@'.$row['user_user_name'].'</h5>
                                                            <p>'.$row['post_content'].'</p>
                                                        </div>
                                                    </div><hr>' ; 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-5">
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">all users</div>
                        <div class="panel-body">
                            <div class="row user">
                                <?php
                                    if($user_in_session){
                                        $query = "SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'"; 
                                    }else{
                                        $query = "SELECT * FROM users"; 
                                        
                                    }
                                    $stmt = $con->prepare($query) ; 
                                    $stmt->execute() ;
                                    $data = $stmt -> fetchAll() ; 
                                    foreach ($data as $row) { 
                                        echo '<div class="row user mb-2">
                                                    <div class="col-4">
                                                        <img src="./assets/uploads/' .$row['user_profile_image'].'" class="img-fluid" alt="notfound">
                                                    </div>
                                                    <div class="col-8">
                                                        <h5>@'.$row['user_user_name'].'</h5>';
                                                            if($user_in_session){
                                                                $stmt = $con->prepare("SELECT * FROM followers WHERE follower_sender_id = ? AND follower_recever_id= ?") ; 
                                                                $stmt->execute(array($_SESSION['user_id'], $row['user_id'])) ; 
                                                                if($stmt->fetch()){
                                                                    ?>
                                                                        <button class="btn btn-lg btn-primary following_button changecolor" value="<?php echo $row['user_id'] ; ?>">
                                                                            Followed
                                                                        </button>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                        <button class="btn btn-lg btn-primary following_button " value="<?php echo $row['user_id'] ; ?>">
                                                                            <i class="fa-regular fa-plus"></i>
                                                                            Following
                                                                    </button>
                                                                    <?php
                                                                }
                                                            }
                                                            $stmt = $con->prepare("SELECT * FROM followers WHERE follower_recever_id= ?") ; 
                                                            $stmt->execute(array($row['user_id'])) ;
                                                            echo '<span id="followers_count'.$row['user_id'].'">'.$stmt->rowCount().' followers</span>' ; 
                                                    echo '</div>' ; 
                                                echo '</div><hr>' ; 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php

    include_once "footer.php" ; 

?>
    <script>
        $("#create_post_form").on('submit', function(event){
            event.preventDefault() ; 
            var user_post = $("#user_post").val() ; 
            $.ajax({
                url:"upload_post.php",
                method:"POST",
                data:{user_post:user_post},
                beforeSend:function(){
                    $("#post_button").attr('disabled','disabled') ; 
                    $("#post_button").html('Wait...') ; 
                },
                success:function(data){
                    $("#post_button").attr('disabled',false) ; 
                    $("#post_button").html('post') ; 
                    if(data =="error"){
                        $("#response").html('<div class="alert alert-danger">You should enter the <strong>post</strong> content</div>') ; 
                        setTimeout(function(){
                            $("#response").html('') ; 
                        }, 2500) ; 
                    }else{
                        $("#user_post").val('')  ; 
                        $("#users_posts").prepend(data) ; 
                    }
                }
            })
        }) ;

        $(".following_button").click(function(){
            var sender_id = $("#user_id").val() ; 
            var receiver_id = $(this).val() ; 
            var ele = $(this) ;
            if(ele.hasClass('changecolor')){
                $.ajax({
                    url:"following_action.php",
                    method:"POST",
                    data:{mood:"unfollow", sender_id:sender_id, receiver_id:receiver_id},
                    beforeSend:function(){
                        ele.attr('disabled','disabled') ; 
                        ele.html('Wait...') ; 
                    },
                    success:function(data){
                        ele.attr('disabled',false) ; 
                        ele.html('<i class="fa-regular fa-plus"></i> Following') ;
                        ele.toggleClass('changecolor') ;
                        $("#followers_count"+receiver_id).html(data+" followers");
                    }
                });
            }else{
                $.ajax({
                    url:"following_action.php",
                    method:"POST",
                    data:{mood:"follow", sender_id:sender_id, receiver_id:receiver_id},
                    beforeSend:function(){
                        ele.attr('disabled','disabled') ; 
                        ele.html('Wait...') ; 
                    },
                    success:function(data){
                        ele.attr('disabled',false) ; 
                        ele.html('Followed') ;
                        ele.toggleClass('changecolor') ;
                        $("#followers_count"+receiver_id).html(data+" followers");
                    }
                });
            }
        });

    </script>
    </body>
</html>