$(document).ready(function(){
    $("#admin_loginBtn").click(function(e){
        if ($("#admin_form")[0].checkValidity()) {
            e.preventDefault(); 
            
            $(this).val('Please Wait..');

            $.ajax({
                url:'./php_action/admin_action.php',
                method: 'post',
                data:$("#admin_form").serialize()+'&action=adminLogin',
                success: function(res){
                    console.log(res);
                    if (res === 'admin_login') {
                        window.location= 'admin_dashboard.php';
                    }else{
                        $("#admin_loginBtn").val('Login');
                        $("#admin_form")[0].reset();
                        $("#login_error").html(res);
                    }
                }
            });
        }
    });

    getAllNotification();

        function getAllNotification(){
            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{action:'notificationAlert'},
                success: function(res){
                    console.log(res);
                    $("#adminNotification").html(res);
                }
            });
        }

        $("body").on('click', '.close', function(e){
            e.preventDefault();

            var notificationId = $(this).attr('id');

            $.ajax({
                url:'./php_action/admin_action.php',
                method:'post',
                data:{notificationId:notificationId},
                success:function(ress){
                    getAllNotification();
                }
            });
        });
});