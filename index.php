<?php 
session_start();

if (isset($_SESSION['userEmail'])) {
    header('location:home.php');
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

    <title>User Management</title>
  </head>
  <body>
    <div class="conatiner">
        <!-- Login form start -->
        <div class="row justify-content-center" id="login-box">
            <div class="col-md-9" style="margin-top:100px;">
                <div class="card-group shadow">
                    <div class="card rounded-3">
                        <h1 class="card-title text-center font-weight-bold text-primary">SignIn To Account</h1><hr>
                        <div class="text-center" id="loginAlert"></div>
                        <form method="post" class="p-3" id="login-form"> 
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php if (isset($_COOKIE['email'])){
                                echo $_COOKIE['email'];
                                }else{
                                    echo '';
                                } ?>" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                                <input type="password" class="form-control" name="password" id="pass" placeholder="Password" value="<?php if (isset($_COOKIE['password'])){
                                    echo $_COOKIE['password'];
                                }else{
                                    echo '';
                                } ?>" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="rememberMe" <?php if (isset($_COOKIE['email'])) { ?>
                                    checked
                                <?php } ?>>
                                <label class="form-check-label">Remember me</label>

                                <a href="javascript:void(0)" class="text-decoration-none float-end" id="forgetPassLink">Forget Password?</a>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg signInBtn" id="loginBtn">Sign In</button>
                            </div>
            
                            <div class="card-heading mb-2">
                                <strong class="text-center text-danger loginErrorMsg"></strong>
                            </div>

                            <small class="text-primary"><a href="admin/index.php" style="text-decoration:none; opacity: 0.4;">Admin Login</a></small>
                        </form>
                    </div>
                    
                    <div class="card justify-content-center myColor">
                        <h1 class="text-center text-white">Hello Friends!</h1>
                        <hr class="bg-white">
                        <p class="text-center text-white lead">Enter Your Personal Details And Start Your Journey With Us!</p>

                        <div class="d-grid col-6 mx-auto">
                            <button class="btn btn-outline-light btn-lg mt-4 myButton" id="regLink">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login form end -->

        <!-- Register Form Start -->
        <div class="row justify-content-center" id="register-box" style="display:none">
            <div class="col-md-9" style="margin-top:80px;">
                <div class="card-group shadow">
                    <div class="card justify-content-center myColor p-4">
                        <h1 class="text-center text-light">Welcome Back!</h1>
                        <hr class="bg-light">
                        <p class="text-center text-light lead">To Keep Connected With Us Login With Your Info.!</p>

                        <div class="d-grid col-6 mx-auto">
                            <button class="btn btn-outline-light btn-lg mt-4 myButton" id="signInBtnLink">Sign In</button>
                        </div>
                    </div>
                    <div class="card p-3">
                    <h1 class="card-title text-center text-primary">Create Account</h1><hr>
                    <div class="text-center" id="regAlert"></div>
                    <form method="post" class="p-3" id="register-form"> 
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="form-control" name="name" id="username" placeholder="Username" required minlength="4">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="remail" placeholder="Email" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" name="password" id="rpass" placeholder="Password" required minlength="6">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" name="cpassword" id="cpass" placeholder="Confirm Password" required>
                        </div>

                        <div class="mb-3">
                            <div class="d-grid">
                                    <button class="btn btn-primary btn-lg signInBtn" id="registerBtn">Sign Up</button>
                            </div>
                            <strong class="text-center text-danger mt-3 errorMsg"></strong>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Form End -->

        <!-- Forget Password Form Start -->
        <div class="row justify-content-center" id="forgetPass-box" style="display:none">
            <div class="col-md-9" style="margin-top:80px">
                <div class="card-group shadow">
                    <div class="card justify-content-center myColor p-3">
                        <h1 class="text-center text-light">Reset Password</h1>
                        <hr class="bg-light">

                        <div class="d-grid col-6 mx-auto">
                            <button class="btn btn-outline-light btn-lg mt-4 myButton" id="bckBtn">Back</button>
                        </div>

                    </div>
                    <div class="card p-3">
                    <h1 class="card-title text-center text-primary">Forgot Your Password?</h1><hr>
                    <p class="text-center text-muted">To reset your password, Please enter your registered e-mail address and we will send you the instructions on your e-mail. </p>
                    <form method="post" class="p-3" id="reset-form"> 
                        <div class="text-center" id="forgetAlert"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="femail" placeholder="Email" required>
                        </div>

                        <div class="mb-3">
                            <div class="d-grid">
                                    <button class="btn btn-primary btn-lg signInBtn" id="resetBtn">Reset Password</button>
                            </div>
                            <strong class="text-center text-danger mt-3 errorMsg"></strong>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Forget Password Form End -->
    </div>

    
    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/fontawesome.js"></script>
    <script src="assets/js/custom.js"></script>
    

  </body>
</html>