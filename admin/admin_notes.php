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
  <div class="card-header text-center bg-primary bg-gradient fw-bold text-light">
    Total Notes Created By Users
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
        fetchAllPost();

        function fetchAllPost(){
            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{action:'fetchPost'},
                success:function(res){
                    $("#cardTitle").hide();
                    $("#tablerow").html(res);
                    $("table").DataTable({
                      // order:[0,'desc']
                    })
                }
            });
        }

        $('body').on('click', '.deletePost', function(e){
            e.preventDefault();
            
            delete_id = $(this).attr("id");
            $.ajax({
            url: 'php_action/admin_action.php',
            method: 'post',
            data:{delete_id:delete_id},
            success: function(res){
                Swal.fire({
                icon: 'success',
                title: 'Post deleted successfully.',
                showConfirmButton: true,
                });
                fetchAllPost();
            }
            })
        });
    });

   

</script>



