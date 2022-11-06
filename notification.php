<?php 

require_once 'php/header.php';

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 mt-4 mb-3">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient fw-bold text-center text-muted p-3">
                    Notifications
                </div>
                <div class="card-body" id="notificationBody">
                    
                </div>
            </div>
        </div>
    </div>
</div>


<?php 

require_once 'php/footer.php';

?>

<script>
    $(document).ready(function(){
        fetchNotification();

        function fetchNotification(){
            $.ajax({
                url:'process.php',
                method:'post',
                data:{action:'getNotify'},
                success: function(res){
                    console.log(res);
                    $("#notificationBody").html(res);
                }
            });
        }
    });
</script>