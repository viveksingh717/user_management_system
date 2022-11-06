<?php 

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

require_once 'admin_common/admin_header.php';

?>

<div class="card shadow-lg mt-4 mb-2">
  <div class="card-header text-center bg-warning fw-bold text-light">
    All Feedback
  </div>
  <div class="card-body" id="tablerow">
    <h5 class="card-title text-center" id="cardTitle">Please Wait...</h5>
  </div>
</div>

<!-- Reply feedback modal -->

<div class="modal fade" id="feedbackModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-muted bg-gradient">Reply Feedback Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="post" class="p-2" id="feedbackForm">
              <div class="form-group mb-3">
                  <textarea class="form-control" id="feed" name="feedMessage" rows="3" placeholder="Write Your Message Here.." required></textarea>
              </div>

              <div class="form-group mb-3">
                <div class="d-grid gap-2">
                  <button class="btn btn-danger bg-gradient fw-bold" id="feedbackReply">Send Reply</button>
                </div>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="feedbackModal" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-light font-weight-bold">Reply Feedback Form </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" class="p-2" id="feedbackForm">
            <div class="form-group">
                <textarea class="form-control" id="feed" name="feedMessage" rows="6" placeholder="Write Your Message Here.." required></textarea>
            </div>

            <input type="submit" class="btn btn-danger btn-block font-weight-bold" id="feedbackReply" value="Send Reply" />
        </form>
      </div>
    </div>
  </div>
</div> -->


<?php 
require_once 'admin_common/admin_footer.php';
?>

<script>
    $(document).ready(function(){
        fetchAllFeeds();

        function fetchAllFeeds(){
            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{action:'feeds'},
                success:function(res){
                    $("#cardTitle").hide();
                    $("#tablerow").html(res);
                    $("table").DataTable({
                      // order:[0,'desc']
                    })
                }
            });
        }
    
    var feed_id;
    var usr_id;

    $("body").on('click', '.reply', function(e){
        // e.preventDefault();
       feed_id = $(this).attr('feed_id');
       usr_id = $(this).attr('usr_id');
    });

    $("#feedbackReply").click(function(e){
        if ($("#feedbackForm")[0].checkValidity()) {
            let feedMessage = $("#feed").val();
            e.preventDefault();

            $("#feedbackReply").val('Please wait..');

            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{feed_id:feed_id, usr_id:usr_id,feedMessage:feedMessage},
                success:function(res){
                    console.log(res);
                    $("#feedbackReply").val('Send Reply');
                    $("#feedbackModal").modal('hide');
                    $("#feedbackForm")[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Reply Sent Successfully!',
                        showConfirmButton: true,
                    });

                    fetchAllFeeds();
                }
            });
        }
    })

  });


</script>


