
$(document).ready(function(){
    $("#regLink").click(function(e){
        e.preventDefault();

        $("#login-box").hide();
        $("#register-box").show();
    });

    $("#signInBtnLink").click(function(e){
        e.preventDefault();
        $("#login-box").show();
        $("#register-box").hide();
    });

    $("#forgetPassLink").click(function(e){
        e.preventDefault();
        $("#login-box").hide();
        $("#forgetPass-box").show();
    });

    $("#bckBtn").click(function(e){
        e.preventDefault();
        $("#login-box").show();
        $("#forgetPass-box").hide();
    });

    // Register ajax//
    $("#registerBtn").click(function(e){
        e.preventDefault();
        if ($("#register-form") == '') {
            $(".errorMsg").text("Invalid input please check and try again");
            $("#registerBtn").val('Sign Up');
        }

        $("#registerBtn").val('Please Wait..');

        if ($("#rpass").val() != $("#cpass").val()) {
            $(".errorMsg").text("* Passwprd did not match, try again");
            $("#registerBtn").val('Sign Up');
        }else{
            $(".errorMsg").text("");
            $.ajax({
                url:'php/action.php',
                method:'post',
                data: $("#register-form").serialize()+"&action=register",
                success: function(res){
                    if (res == 'success') {
                        $("#registerBtn").val('Sign Up');
                        $("#regAlert").html(''); 
                        window.location = 'login.php';
                    }else{
                        $("#regAlert").html(res); 
                        }
                }
            });
        }
    });

    // Login Ajax//
    $("#loginBtn").click(function(e){
        e.preventDefault();
        if ($("#login-form") == '') {
            $(".loginErrorMsg").text("Invalid input, check and try again");
            $("#loginBtn").val('Sign Up');
        }

        $("#loginBtn").val('Please Wait..');

        $.ajax({
            url:'php/action.php',
            method:'post',
            data: $("#login-form").serialize()+"&action=login",
            success:function(response){
                $("#loginBtn").val('Login');
                console.log(response);
                if (response == 'login') {
                    window.location = 'home.php';
                }else{
                    $("#loginAlert").html(response);
                }
            }
        })
    });

    //Login ajax End//

    //Reset password ajax //
    $("#resetBtn").click(function(e){
    e.preventDefault();

    if ($("#reset-form") == '') {
            $(".errorMsg").text("Please enter your registerd email.");
            $("#resetBtn").val('Reset Password');
        }

        $("#resetBtn").val('Please Wait..');

        $.ajax({
            url:'php/action.php',
            method:'post',
            data:$("#reset-form").serialize()+"&action=reset",
            success:function(resData){
                $("#resetBtn").val('Reset Password');
                $("#reset-form")[0].reset();
                $("#forgetAlert").html(resData);
                console.log(resData);
            }
        });

    });

});
