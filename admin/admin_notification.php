<?php 

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

require_once 'admin_common/admin_header.php';

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 mt-3 mb-3">
            <div class="card shadow-lg">
                <div class="card-header fw-bold p-2 text-center text-muted">
                    All Notifications
                </div>
                <div class="card-body" id="notificationBody">
                    
                </div>
            </div>
        </div>
    </div>
</div>



<?php 
require_once 'admin_common/admin_footer.php';
?>


<script>
    $(document).ready(function(){
        getAllNotification();

        function getAllNotification(){
            $.ajax({
                url:'php_action/admin_action.php',
                method:'post',
                data:{action:'notification'},
                success: function(res){
                    // console.log(res);
                    $("#notificationBody").html(res);
                }
            });
        }
    });

</script>


