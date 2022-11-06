<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

    session_start();

    // $admin_name = $_SESSION['admin_name'];

    require_once './php_action/admin_auth.php';

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
    
    
    <?php 
    $title = basename($_SERVER['PHP_SELF'], '.php');

    $title = explode('_',$title);
    
    ?>
    <title><?= ucfirst($title[0]); ?></title>

  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div class="admin-sidenav p-1">
                <h4 class="text-light text-center p-2 fw-bold"><i class="fa-solid fa-gauge-high"></i>Admin Dashboard</h4><hr>
                <div class="list-group list-group-flush">

                    <a href="admin_dashboard.php" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-chart-pie"></i>&nbsp;Dashboard</a>

                    <a href="admin_users.php" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'admin_users.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-user-friends"></i>&nbsp;Users</a>

                    <a href="admin_notes.php" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'admin_notes.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-sticky-note"></i>&nbsp;Notes</a>

                    <a href="admin_feedback.php" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'admin_feedback.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-comments"></i>&nbsp;Feedback</a>

                    <a href="admin_notification.php" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'admin_notification.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-bell"></i>&nbsp;Notification <span id="adminNotification"></span> </a>

                    <a href="deleted_user.php" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'deleted_user.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-user-slash"></i>&nbsp;Deleted Users</a>

                    <a href="php_action/admin_action.php?export=excel" class="list-group-item admin_link <?= (basename($_SERVER['PHP_SELF']) == 'export_users.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-file-export"></i>&nbsp;Export Users</a>

                    <!-- <a href="admin_setting.php" class="list-group-item admin_link <//?= (basename($_SERVER['PHP_SELF']) == 'admin_setting.php') ? 'nav-active' : ''; ?>"><i class="fa-solid fa-gears"></i>&nbsp;Setting</a> -->

                </div>
            </div>

            <div class="col">
                <div class="row">
                    <div class="col-md-12 bg-primary bg-gradient p-3 justify-content-between d-flex">
                        <a href="javascript:void(0)" class="text-light" id="toggleNav"><h3><i class="fa-solid fa-bars"></i></h3></a>
                        <h4 class="text-light" id="hambergBar"><?= ucfirst($title[0]); ?></h4>
                        <p><a class="text-light fw-bold text-decoration-none me-4" href="php_action/admin_logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></p>
                    </div>
                </div>




        <script src="../admin/admin_assets/js/jQuery.js"></script>
        <script src="../admin/admin_assets/js/bootstrap.js"></script>
        <script src="../admin/admin_assets/js/fontawesome.js"></script>
        <script src="../admin/admin_assets/js/datatable.js"></script>
        <script src="../admin/admin_assets/js/admin_script.js"></script>