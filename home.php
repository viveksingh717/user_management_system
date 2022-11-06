<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'php/header.php';

?>

<div class="container">
    <?php if ($user_verified == 'Not Verified') : ?>
    <div class="alert alert-danger alert-dismissible fade show text-center mt-2" role="alert">
        <strong>Not Verified!</strong> Your email is not verified! We have sent you an e-mail verification link on your registered mail-id, check and verify.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
    
    <div class="card mt-4 mb-4 shadow-lg">
        <h6 class="card-header d-flex justify-content-between">
            <span class="text-muted p-2">All Post</span>
            <a href="javascript:void(0)" class="btn btn-dark btn-sm bg-gradient fw-bold" data-bs-toggle="modal" data-bs-target="#addNewModal"><i class="fa-solid fa-plus-circle fa-lg"></i>&nbsp;Add New</a>
        </h6>

        <div class="card-body" id="display_table">
            <div class="text-center">
              <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;"></div>
              <p class="text-center fw-bold">Loading...</p>
            </div>
        </div>
    </div>
</div>

<!-- Add New Post Modal -->

<div class="modal fade" id="addNewModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-muted">Add New Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="post-form" class="p-2">
          <div class="form-group mb-3">
              <label class="fw-bold">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
          </div>
          <div class="form-group mb-3">
              <label class="fw-bold">Post</label>
              <textarea class="form-control" id="post" name="post" rows="3" placeholder="Add New Post" required></textarea>
          </div>

          <div class="form-group mb-3">
            <button type="button" class="btn btn-dark bg-gradient" id="submmitBtn">Save Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add New Post Modal End-->

<!-- Edit Post Modal -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-muted">Update Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="postEdit-form">
          <input type="hidden" name="id" id="editId">
          <div class="form-group mb-3">
              <label class="fw-bold">Title</label>
              <input type="text" class="form-control" id="etitle" name="title">
          </div>
          <div class="form-group mb-3">
              <label class="fw-bold">Post</label>
              <textarea class="form-control" id="epost" name="post" rows="3"></textarea>
          </div>
          <div class="form-group mb-3">
            <button class="btn btn-primary bg-gradient" id="updateBtn">Update Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Post Modal End-->



<?php 

require_once 'php/footer.php';

?>

<script>
  $(document).ready(function(){
    fetch_data();
      
      function fetch_data(){
          $.ajax({
          url:'process.php',
          method:'post',
          data:{task:'display_data'},
          success:function(res){
            $("#display_table").html(res);
            $("table").DataTable({
              // order:[0,'desc']
            })
          }
        });
      }

        //Add data using ajax//
      $("#submmitBtn").click(function(e){
        e.preventDefault();
        if ($("#post-form")[0].checkValidity()) {
          $("#submmitBtn").val('Please Wait..');

          $.ajax({
          url:'process.php',
          method:'post',
          data:$("#post-form").serialize()+'&action=add_post',
          success:function(ress){
            $("#addNewModal").modal('hide');
            $("#submmitBtn").val('Submit');
            $("#post-form")[0].reset();
            Swal.fire({
              icon: 'success',
              title: 'New post added successfully.',
              showConfirmButton: true,
              // timer: 2000,
            });
            fetch_data()
          }
        });
        }
      });

      //Show data in form//
      $("body").on("click", ".editBtn", function(e){
          e.preventDefault();
          edit_id = $(this).attr('id');

          $.ajax({
            url: 'process.php',
            method:'post',
            data:{edit_id:edit_id},
            success: function(res){
              var data = JSON.parse(res);
              $("#editId").val(data.id);
              $("#etitle").val(data.title);
              $("#epost").val(data.post);
            }
          });
        });

      //Update data using ajax request//
      
      $("#updateBtn").click(function(e){
        e.preventDefault();

        $.ajax({
          url: 'process.php',
          method: 'post',
          data: $("#postEdit-form").serialize()+"&action=updateForm",
          success: function(ress){
            Swal.fire({
              icon: 'success',
              title: 'Post updated successfully.',
              showConfirmButton: true,
              // timer: 2000,
            });
            $("#postEdit-form")[0].reset();
            $("#editModal").modal('hide');
            fetch_data();
          }
        });
      })

      $('body').on('click', '.deleteBtn', function(e){
        e.preventDefault();
        delete_id = $(this).attr("id");
        $.ajax({
          url: 'process.php',
          method: 'post',
          data:{delete_id:delete_id},
          success: function(res){
            Swal.fire({
              icon: 'success',
              title: 'Post deleted successfully.',
              showConfirmButton: true,
            });

            fetch_data();
          }
        })
      });

     $('body').on('click', '.infoBtn', function(e){
        e.preventDefault();

        view_id = $(this).attr('id');

        $.ajax({
          url:'process.php',
          method:'post',
          data:{view_id:view_id},
          success:function(res){
            data = JSON.parse(res);
            Swal.fire({
              title: '<strong>Post - <u>ID('+data.id+')</u></strong>',
              icon: 'info',
              html:
                '<b>'+data.title+'</b> ' +
                '<p>'+data.post+'</p> ' +
                '<small>'+data.created_at+'</small>, ',
                
              showCloseButton: true,
              showCancelButton: true,
              focusConfirm: false,
              confirmButtonText:
                '<i class="fa fa-thumbs-up"></i> Great!',
              confirmButtonAriaLabel: 'Thumbs up, great!',
            })
          }
        });
     });

     //Check user is-login

     $.ajax({
       url:'php/action.php',
       method:'post',
       data:{action:'isLoginCheck'},
       success: function(res){
         console.log(res);
         if (res === 'Bye') {
           window.location = 'index.php';
         }
       }
     })
  });
  
</script>