<?php 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if (isset($_SESSION['admin_name'])) {
        header('location:admin_dashboard.php');
        exit();
    }

    include_once '../config/config.php';

    $db = new Database();

    $sql = "UPDATE `website_hits` SET `visitor_hits`= visitor_hits+1 WHERE id=0";
    $stmt= $db->conn->prepare($sql);
    $stmt->execute();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../admin/admin_assets/css/bootstrap.css">
    <link rel="stylesheet" href="../admin/admin_assets/css/fontawesome.css">
    <link rel="stylesheet" href="../admin/admin_assets/css/datatable.css">
    <link rel="stylesheet" href="../admin/admin_assets/css/admin_style.css">

    <title><?= ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>
    
  </head>
  <body class="bg-dark">
        <div class="container">
            <div class="row align-items-center justify-content-center" id="adminRow">
                <div class="col-md-6">
                    <div class="card border-dark shadow-lg">
                        <div class="card-header bg-danger bg-gradient text-light fw-bold text-center">
                            <h3><i class="fa fa-user-cog"></i>Admin Login</h3>
                        </div>
                        <div class="card-body">
                            <strong class="text-center text-danger" id="login_error"></strong>

                            <form method="post" class="p-3" id="admin_form">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Username</label>
                                    <input type="text" class="form-control" name="username" id="user" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Password</label>
                                    <input type="password" class="form-control" name="password" id="pass" placeholder="Password" required minlength="4">
                                </div>

                                <div class="form-group mb-3">
                                    <div class="d-grid">
                                        <button class="btn btn-danger btn-lg fw-bold bg-gradient" id="admin_loginBtn">Login</button>
                                    </div>                        
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../admin/admin_assets/js/jQuery.js"></script>
        <script src="../admin/admin_assets/js/bootstrap.js"></script>
        <script src="../admin/admin_assets/js/fontawesome.js"></script>
        <script src="../admin/admin_assets/js/datatable.js"></script>
        <script src="../admin/admin_assets/js/admin_script.js"></script>
    
        
    </body>
</html>
