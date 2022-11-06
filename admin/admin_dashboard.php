<?php 

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

require_once 'admin_common/admin_header.php';
require_once 'php_action/admin_auth.php';

$adminAuth = new Admin_Auth();

?>


<div class="row mt-2">
    <div class="col-md-3">
        <div class="card bg-primary bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
                Total Users
            </div>
            <div class="card-body">
                <h1 class="display-4">
                    <?= $adminAuth->getusersCount('users'); ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
                Verified Users
            </div>
            <div class="card-body">
                <h1 class="display-4">
                <?= $adminAuth->getverifieduserCount(1); ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="col-md-3 text-center fw-bold">
        <div class="card bg-success bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
            Non-Verified Users
            </div>
            <div class="card-body">
                <h1 class="display-4">
                <?= $adminAuth->getverifieduserCount(0); ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="col-md-3 text-center fw-bold">
        <div class="card bg-danger bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
            Website Hits
            </div>
            <div class="card-body">
                <h1 class="display-4">
                    <?php $hits = $adminAuth->website_hits(); echo $hits['visitor_hits']; ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-4">
        <div class="card bg-danger bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
                Total Posts
            </div>
            <div class="card-body">
                <h1 class="display-4">
                <?= $adminAuth->getCount('posts'); ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
                Total Feedback
            </div>
            <div class="card-body">
                <h1 class="display-4">
                <?= $adminAuth->getCount('feedback'); ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning bg-gradient text-center fw-bold text-light shadow">
            <div class="card-header">
                Total Notification
            </div>
            <div class="card-body">
                <h1 class="display-4">
                <?= $adminAuth->getCount('notification'); ?>
                </h1>
            </div>
        </div>
    </div>            
</div>

<div class="row mt-3">
    <div class="col-md-6 text-center fw-bold">
        <div class="card mb-3 shadow">
            <div class="card-header bg-primary bg-gradient text-light text-center">
                Male/Female User`s Graph
            </div>
            <div id="chart_div1" style="width:99%; height:400px;">
                
            </div>
        </div>
    </div>

    <div class="col-md-6 text-center fw-bold">
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary bg-gradient text-light text-center">
                Verified/Non-Verified User`s Graph
            </div>
            <div id="chart_div2" style="width:99%; height:400px;">
                
            </div>
        </div>
    </div>
</div>


<?php 
require_once 'admin_common/admin_footer.php';

?>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        <?php  $gender = $adminAuth->getGenderCount();?>

        var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count'],
          <?php  foreach ($gender as $row) { ?>
              ["<?=ucfirst($row['gender']); ?>", <?=$row['gender_count']; ?>],
          <?php } ?>
        ]);

        var options = {
          title: 'Male/Female User`s Graph'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));

        chart.draw(data, options);
      }
    </script>

<!-- Verified User graph -->

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        <?php  $verifiedUser = $adminAuth->getVerifiedUser();?>

        var data = google.visualization.arrayToDataTable([
          ['Verified', 'Count'],
          <?php  foreach ($verifiedUser as $row) { 
              if ($row['verified'] == 0) {
                   $row['verified'] = 'Non-Verified';
              }else{
                $row['verified'] = 'Verified';
              }
            ?>
              ["<?=$row['verified']; ?>", <?=$row['verified_users']; ?>],
          <?php } ?>
        ]);

        var options = {
            pieHole:0.4,
            title: 'Verified/Non-Verified User`s Graph'   
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));

        chart.draw(data, options);
      }
    </script>
