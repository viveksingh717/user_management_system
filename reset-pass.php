<?php 

require_once './config/auth.php';

$user = new Auth();
$msg = '';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $user->input_validator($_GET['email']);
    $token = $user->input_validator($_GET['token']);

    $auth_user = $user->reset_pass($email, $token);

    if (!empty($auth_user)) {
        if (isset($_POST['submit'])) {
            $password = $user->input_validator($_POST['password']);
            $cpassword = $user->input_validator($_POST['cpassword']);

            if ($password == $cpassword) {
                $user->update_password($email,$password);
                $msg = 'Password has been changes successfully! </br> <a href="index.php">Click Login Here!</a>';       
            }else{
                $msg = 'Password did not match.';
            }
        }
    }else{
        header('location:index.php');
        exit();
    }
}else{
    header('location:index.php');
    exit();
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta author="Vivek Singh" description="user management">

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/customStyle.css">

    <title>Reset Password</title>
  </head>
  <body>
    <div class="conatiner">
        <div class="row justify-content-center" id="reset-pass">
            <div class="col-md-9" style="margin-top:90px">
                <div class="card-group">
                    <div class="card justify-content-center myColor p-3">
                        <h1 class="text-center fw-bold text-light">Reset Your Password Here!</h1>
                        <hr class="bg-light">
                        <div class="d-grid">
                            <a href="index.php" class="btn btn-outline-light btn-lg fw-bold mt-4 myButton">Sign In</a>
                        </div>
                    </div>
                    <div class="card rounded-left p-4" style="flex-grow:2;">
                    <h1 class="card-title text-center fw-bold text-primary">Reset Password</h1><hr>

                    <div class="text-center mb-2">
                        <strong><?= $msg ?></strong>
                    </div>
                    <form method="post" class="p-3" id="setNewPass-form">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Set New Password" required minlength="6">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" name="cpassword" placeholder="Set Confirm Password" required>
                        </div>

                        <div class="mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg signInBtn" type="button">Reset</button>
                                <strong class="text-center text-danger errorMsg"></strong>
                            </div>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/fontawesome.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(function(){
            // Register ajax//

            // $("#registerBtn").click(function(e){
            //     e.preventDefault();
            //     if ($("#register-form") == '') {
            //         $(".errorMsg").text("Invalid input please check and try again");
            //         $("#registerBtn").val('Sign Up');
            //     }

            //     $("#registerBtn").val('Please Wait..');

            //     if ($("#rpass").val() != $("#cpass").val()) {
            //         $(".errorMsg").text("* Passwprd did not match, try again");
            //         $("#registerBtn").val('Sign Up');
            //     }else{
            //         $(".errorMsg").text("");
            //         $.ajax({
            //             url:'php/action.php',
            //             method:'post',
            //             data: $("#register-form").serialize()+"&action=register",
            //             success: function(res){
            //                 $("#registerBtn").val('Sign Up');
            //                 if (res == 'success') {
            //                     window.location = 'home.php';
            //                 }else{
            //                     $("#regAlert").html(res); 
            //                  }
            //             }
            //         });
            //     }
            // });
        });
    </script>

  </body>
</html>