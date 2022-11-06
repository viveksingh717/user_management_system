$(document).ready(function(){
    fetchNotification();

    function fetchNotification(){
        $.ajax({
            url:'./process.php',
            method:'post',
            data:{action:'checkNotify'},
            success: function(res){
                $("#notifyBadge").html(res);
            }
        });
    }

    $("body").on('click', '.close', function(e){
        e.preventDefault();

        var notification_id = $(this).attr('id');

        $.ajax({
            url:'./process.php',
            method:'post',
            data:{notification_id:notification_id},
            success:function(ress){
                console.log(ress);
                fetchNotification();
            }
        });
    });

    $("#update_profile_form").submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'process.php',
            method:'post',
            processData:false,
            contentType:false,
            cache:false,
            data: new FormData(this),
            success:function(ress){
                console.log(ress);
                location.reload();
            }
        });
    });

    // Change Password ajax request

    $("#update_pass").click(function(e){
        e.preventDefault();

        var currentPass = $("#currPass").val();
        $("#update_pass").val('Please wait..');

        if (currentPass != '') {
            var newPass = $("#newPass").val();
            var confPass = $("#conPass").val();

            if (newPass != confPass) {
                $("#errorBox").text('Password did not match');
                $("#update_pass").val('Update Password');
            }

            $.ajax({
                url:'process.php',
                method:'post',
                data: $("#changePass_form").serialize()+'&action=changePass',
                success:function(res){
                    $("#update_pass").val('Update Password');
                    $("#successMsg").html(res);
                    $("#changePass_form")[0].reset();
                }
            });

        }else{
            $("#errorBox").text('Current Password should not be blank');
            $("#update_pass").val('Update Password');
        }
    });

    //Verify Email//

    $("#email_verify").click(function(e){
        e.preventDefault();
        $(this).text('Please Wait..');

        $.ajax({
            url:'process.php',
            method:'post',
            data:{action:'verify_email'},
            success:function(res){
                console.log(res);
                $("#msgSent").html(res);
                $("#email_verify").text('Verify Now');
            }
        });
    });
});