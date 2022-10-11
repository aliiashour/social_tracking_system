<?php
    $page_title = "register user" ; 
    include_once "init.php" ; 
    
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 register_form_container">
            <span id="response"></span>
            <form method="POST" id="user_register_form">
                <div class="mb-3">
                    <label for="user_name" class="form-label">Name</label>
                    <input type="text" class="form-control" name = "user_name" id="user_name">
                    <div id="user_name_help" class="form-text">Enter your full name.</div>
                </div>
                <div class="mb-3">
                    <label for="user_uname" class="form-label">User Name</label>
                    <input type="text" class="form-control" name = "user_uname" id="user_uname">
                    <div id="user_uname_help" class="form-text">Your user name should be unique one.</div>
                </div>
                <div class="mb-3">
                    <label for="user_email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name = "user_email" id="user_email" aria-describedby="emailHelp">
                    <div id="user_email_help" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" class="form-control" name = "user_password" id="user_password">
                </div>
                <div class="mb-3 form-check text-center">
                    <span>you already have an account?<a href="./login.php">signIN</a></span>
                </div>
                <button type="submit" class="btn btn-primary" id="submit_button">SignUp</button>
            </form>
        </div>
    </div>
</div>



<?php

    include_once "footer.php" ; 
?>
    <script>

    $("#user_register_form").on("submit", function(event){
        event.preventDefault() ; 
        // now validation on user data
        var user_name = $("#user_name").val() ;
        var user_uname = $("#user_uname").val() ;
        var user_email = $("#user_email").val() ;
        var user_password = $("#user_password").val() ;
        $.ajax({
            url:"register_action.php",
            method:"post",
            data:{user_name:user_name, user_uname:user_uname, user_password:user_password, user_email:user_email},
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
                $("#submit_button").html('signUp') ; 
                if(data != ''){
                    $("#response").html(data) ; 
                    setTimeout(function(){
                        $("#response").html('') ; 
                    }, 2500) ; 
                    
                }else{
                    window.location.href = "login.php" ; 
                }
            }
            
        })

        


    })


    </script>
</body>
</html>
