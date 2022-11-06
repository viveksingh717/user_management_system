<?php 

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

require_once 'admin_common/admin_header.php';

?>

<div class="card shadow-lg mt-4 mb-3">
  <div class="card-header text-center bg-danger bg-gradient fw-bold text-light">
    Total Deleted Users
  </div>
  <div class="card-body" id="tablerow">
    <h5 class="card-title text-center" id="cardTitle">Please Wait...</h5>
  </div>
</div>



<?php 
    require_once 'admin_common/admin_footer.php';
?>

<script>
    $(document).ready(function(){
        fetchAllDeletedUsers();

        function fetchAllDeletedUsers(){
            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{action:'getDeletedUsr'},
                success:function(res){
                    $("#cardTitle").hide();
                    $("#tablerow").html(res);
                    $("table").DataTable({
                      // order:[0,'desc']
                    })
                }
            });
        }

        $('body').on('click', '.restoreBtn', function(e){
        e.preventDefault();
        
        restore_id = $(this).attr("id");
        $.ajax({
          url: 'php_action/admin_action.php',
          method: 'post',
          data:{restore_id:restore_id},
          success: function(res){
            Swal.fire({
              icon: 'success',
              title: 'Post restored successfully.',
              showConfirmButton: true,
            });
            fetchAllDeletedUsers();
          }
        })
    });
    });


</script>



