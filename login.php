<?php
    $page_title = "Login user" ; 
    include_once "init.php" ; 
    
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 register_form_container">
            <div id="response"></div>
            <form method="POST" id="user_login_form">
                <div class="mb-3">
                    <label for="user_uname" class="form-label">User Name</label>
                    <input type="text" class="form-control" name="user_uname" id="user_uname">
                    <div id="user_name_help" class="form-text">Your user name should be unique one.</div>
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="user_password" id="user_password">
                </div>
                <div class="mb-3 form-check text-center">
                    <span>don't have an account?<a href="./register.php">signUp</a></span>
                </div>
                <button type="submit" class="btn btn-primary" id="login_button">LogIN</button>
            </form>
        </div>
    </div>
</div>



<?php

    include_once "footer.php" ; 
?>
    <script>

        $("#user_login_form").on('submit', function(event){
            event.preventDefault() ; 
            var user_uname = $("#user_uname").val() ; 
            var user_password = $("#user_password").val() ; 
            $.ajax({
                url:"login_action.php",
                method:"post",
                data:{user_uname:user_uname, user_password:user_password},
                beforeSend:function(){
                    $("#login_button").attr('disabled', 'disabled') ; 
                    $("#login_button").html('wait..');
                },
                success:function(data){
                    $("#login_button").html('LogIn');
                    $("#login_button").attr('disabled', false) ; 

                    if (data!='') {
                        $("#response").html(data) ;
                        setTimeout(function(){
                        $("#response").html('') ;
                        }, 2500) ; 
                    }else{
                        window.location.href = "index.php" ; 
                    }

                }
            });
        })
        


    </script>
</body>
</html>
