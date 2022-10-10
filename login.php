<?php
    $page_title = "Login user" ; 
    include_once "init.php" ; 
    
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 register_form_container">
            <form>
                <div class="mb-3">
                    <label for="exampleInputUserName" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="exampleInputUserName">
                    <div id="user_name_help" class="form-text">Your user name should be unique one.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check text-center">
                    <span>don't have an account?<a href="./register.php">signUp</a></span>
                </div>
                <button type="submit" class="btn btn-primary">LogIN</button>
            </form>
        </div>
    </div>
</div>



<?php

    include_once "footer.php" ; 
?>
    <script>


        


    </script>
</body>
</html>
