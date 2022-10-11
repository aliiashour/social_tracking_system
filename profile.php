<?php
    session_start() ; 
    if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
        

                
        $page_title = $_SESSION['user_uname'] ; 
        include_once "init.php" ;
        
        $query = "SELECT * FROM users WHERE user_id = ?" ; 
        $stmt = $con->prepare($query) ; 
        $stmt -> execute(array($_SESSION['user_id'])) ; 
        $data = $stmt->fetch() ; 



?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Foolwing</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                            if(isset($_SESSION['user_uname']) && $_SESSION['user_uname'] != ''){
                                ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php  echo $_SESSION['user_uname'] ; ?>
                                        </a>
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
                                <?php
                            }else{
                                ?>
                                    <a class="nav-link" href="login.php" role="button">
                                        <?php  echo 'login' ?>
                                    </a>
                                <?php
                            }
                        
                        ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 register_form_container">
                <span id="response"></span>
                <form method="POST" id="user_edit_form" enctype="multipart/form-data">
                <input hidden type="text" class="form-control" name = "user_id" id="user_id" value="<?php echo $data['user_id']?>">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Name</label>
                        <input type="text" class="form-control" name = "user_name" id="user_name" value="<?php echo $data['user_name']?>">
                        <div id="user_name_help" class="form-text">Enter your full name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="user_uname" class="form-label">User Name</label>
                        <input type="text" class="form-control" name = "user_uname" id="user_uname" value="<?php echo $data['user_user_name']?>">
                        <div id="user_uname_help" class="form-text">Your user name should be unique one.</div>
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name = "user_email" id="user_email" aria-describedby="emailHelp" value="<?php echo $data['user_email']?>">
                        <div id="user_email_help" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="user_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="user_image" id="user_image" aria-describedby="imageHelp">
                        <div id="user_image_help" class="form-text">We recomend a jpg image.</div>
                    </div>

                    <div class="mb-3">
                        <label for="user_bio" class="form-label">Bio</label>
                        <input type="text" class="form-control" name = "user_bio" id="user_bio" aria-describedby="bioHelp" value="<?php echo $data['user_bio']?>">
                    </div>
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" class="form-control" name = "user_password" id="user_password">
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit_button">Edit</button>
                </form>
            </div>
        </div>
    </div>

        
<?php

    include_once "footer.php" ; 
?>
    <script>

        $("#user_edit_form").on("submit", function(event){
            event.preventDefault() ; 
            // now validation on user data
            var user_id = $("#user_id").val() ;
            var user_name = $("#user_name").val() ;
            var user_uname = $("#user_uname").val() ;
            var user_email = $("#user_email").val() ;
            var user_image = $("#user_image").val() ;
            console.log(user_image) ; 
            var user_bio = $("#user_bio").val() ;
            var user_password = $("#user_password").val() ;
            $.ajax({
                url:"profile_action.php",
                method:"post",
                data:  new FormData(this),
                contentType: false,
                        cache: false,
                processData:false,
                // data:{user_id:user_id, user_name:user_name, user_uname:user_uname, user_email:user_email,user_bio:user_bio, user_password:user_password},
                // data:new FormData(this),
                beforeSend:function(){
                    // zorar  value
                    // zorar disability
                    $("#submit_button").attr('disabled', 'disabled') ; 
                    $("#submit_button").html('Wait...') ; 

                },
                success:function(data){
                    // add in answer box
                    // zorar
                    // 
                    $("#submit_button").attr('disabled', false) ; 
                    $("#submit_button").html('Edit') ; 
                    
                    $("#response").html(data) ; 
                    setTimeout(function(){
                        $("#response").html('') ; 
                    }, 20000) ; 
                    
            
                }
                
            })

        })
    </script>
    <?php
    }else{
        echo "you should login first" ; 
    }
    ?>
</body>
</html>
