<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'php/header.php';

$users = new Auth();


?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <?php 
                if ($user_verified == 'Verified') :?>
                    <div class="card">
                        <div class="card-header fw-bold lead text-center bg-gradient">
                            Feedback Form
                        </div>
                        <div class="card-body p-4">
                            <form method="post" id="feedbackForm">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Subject</label>
                                    <input type="text" class="form-control" id="sub" name="subject" placeholder="Enter Subject" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Feedback</label>
                                    <textarea class="form-control" id="feedback" name="feedBack" rows="3" placeholder="Type Your Feedback Here.." required></textarea>
                                </div>

                                <div class="mb-3">
                                    <div class="d-grid">
                                        <button class="btn btn-dark bg-gradient fw-bold btn-lg" type="button" id="sendFeedback">Send Feedback</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else : ?> 
                    <div class="text-center text-muted lead"><h2>This email is not verified please verify your email!</h2></div>   
            <?php endif; ?>
        </div>
    </div>
</div>


<?php 

require_once 'php/footer.php';

?>

<script>
    $(document).ready(function(){
        $("#sendFeedback").click(function(e){
            e.preventDefault();

            if ($("#feedbackForm") === '') {
                return false;
            }

            $("#sendFeedback").val('please Wait..');

            $.ajax({
                url:'process.php',
                method:'post',
                data:$("#feedbackForm").serialize()+'&action=send_feedback',
                success:function(ress){
                    $("#feedbackForm")[0].reset();
                    $("#sendFeedback").val('Send Feedback');
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Your feedback has been saved',
                        showConfirmButton: true,
                    });
                }
            });

        });
    });
</script>