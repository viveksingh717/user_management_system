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
  <div class="card-header text-center bg-success bg-gradient fw-bold text-light">
    Total Register Users
  </div>
  <div class="card-body" id="tablerow">
    <h5 class="card-title text-center" id="cardTitle">Please Wait...</h5>
  </div>
</div>

<!-- Display user detail modal -->

<div class="modal fade" id="showModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-muted fw-bold" id="uname"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-8"> 
            <div class="card">
              <div class="card-body">
                <p id="usrname"></p>
                <p id="uemail"></p>
                <p id="ugender"></p>
                <p id="ucontact"></p>
                <p id="created_at"></p>
                <p id="isverified"></p>
              </div>
            </div>
            </div>
            <div class="col-md-4"> 
              <div class="card align-self-center" id="uimage">
              
              </div>
            </div>
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
        fetchAllUsers();

        function fetchAllUsers(){
            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{action:'fetchusr'},
                success:function(res){
                    $("#cardTitle").hide();
                    $("#tablerow").html(res);
                    $("table").DataTable({
                      // order:[0,'desc']
                    })
                }
            });
        }

      $("body").on('click', '.viewBtn', function(e){
        e.preventDefault();

        viewId = $(this).attr('id');

        $.ajax({
          url:'./php_action/admin_action.php',
          method:'post',
          data:{viewId:viewId},
          success:function(res){
            data = JSON.parse(res);
            // var imagepath = '../uploads/' + data.photo;
            // var thumbimage = '../assets/images/PICA.jpg';
            $("#uname").text(data.name + '( ID : ' + data.id + ')');
            $("#usrname").text('Name : ' + data.name);
            $("#uemail").text('Email : ' + data.email);
            $("#ugender").text('Gender : ' + data.gender);
            $("#ucontact").text('Contact : ' + data.phone);
            $("#created_at").text('Joined At : ' + data.created_at);
            $("#isverified").text('Is-Veridied : ' + data.verified);

            if (data.photo) {
              $("#uimage").html('<img src="../' + data.photo +'" class="img-thumbnail img-fluid" />')
            }else{
              $("#uimage").html('<img src="../assets/images/PICA.jpg" class="img-thumbnail img-fluid" />');
            }
          }
        });

    });

    $('body').on('click', '.deleteBtn', function(e){
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
            // location.reload();
            fetchAllUsers();
          }
        })
    });

  });


</script>



