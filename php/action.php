<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../config/vendor/autoload.php';
require_once '../config/auth.php';

$user = new Auth();
$mail = new PHPMailer(true);

// Register handing code //
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $name = $user->input_validator($_POST['name']);
    $email = $user->input_validator($_POST['email']);
    $pass = $user->input_validator($_POST['password']);

    // $hashPass = password_hash($pass, PASSWORD_DEFAULT);

    if ($user->check_user_exist($email)) {
        echo $user->showMessage('danger', 'User alredy exist');
    }else{
        if ($user->register($name, $email, $pass)) {
            echo 'success';
            $_SESSION['userName'] = $name;
            $_SESSION['userEmail'] = $email;

            try {
                // $mail->SMTPDebug = 2;  //debugging
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                
                $mail->SMTPAuth   = true;                                  
                // $mail->Username   = 'vs4092344@gmail.com';                     
                // $mail->Password   = 'vivek777';
                $mail->Username   = Database::USERNAME;                     
                $mail->Password   = Database::PASSWORD;                               
                // $mail->SMTPSecure = 'ssl';   
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
                $mail->Port       = 465;                           
    
                //Recipients
                $mail->setFrom(Database::USERNAME, 'Vivek-Admin');
                $mail->addAddress($email);
               
                $mail->isHTML(true);
                $mail->Subject = 'Email Verification';
                $mail->Body = '<h3>Click on the below link to verify your email.</h3>
                <p><a href="http://localhost/user_management/verify_email.php?email='.$email.'">http://localhost/user_management/verify_email.php?email='.$email.'</a></p>
                </br>
                <p> Regards </p>
                <strong>Vivek Coolhunter!</strong>';
    
                $mail->send();
                echo $user->showMessage('success', 'We have sent you verification link on your registered email-id, please check email.');
            } catch (Exception $e) {
                echo $user->showMessage('danger', 'Something went wrong, please check your email and try again.');
        }
        }else{
            echo $user->showMessage('danger', 'Something went wrong!');
        }
    }
}
// Register handing code End //

// Login handing code //
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $user->input_validator($_POST['email']);
    $password = $user->input_validator($_POST['password']);

    $logedIn = $user->login($email, $password);
    if ($logedIn != null) {
        if (!empty($_POST['remember'])) {
            setcookie("email", $email, time()+(30*24*60*60), '/');
            setcookie("password", $password, time()+(30*24*60*60), '/');
        }else{
            setcookie("email", 1, '/');
            setcookie("password", 1, '/');
        }
        echo 'login';
        $_SESSION['userEmail'] = $email;
    }else{
        echo $user->showMessage('danger', 'Something went wrong!');
    }
}
// Login handing code End//

//reset password //
if (isset($_POST['action']) && $_POST['action'] == 'reset') {

    $email = $user->input_validator($_POST['email']);

    // $logedUser = $_SESSION['userEmail'];

    $userDetail = $user->currentUserData($email);

    if (!empty($userDetail)) {
        $token = uniqid();
        $token = str_shuffle($token);

        $user->update_token($token, $email);

        try {
            // $mail->SMTPDebug = 2;  //debugging
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                
            $mail->SMTPAuth   = true;                                  
            // $mail->Username   = 'vs4092344@gmail.com';                     
            // $mail->Password   = 'vivek777';
            $mail->Username   = Database::USERNAME;                     
            $mail->Password   = Database::PASSWORD;                               
            // $mail->SMTPSecure = 'ssl';   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
            $mail->Port       = 465;                           

            //Recipients
            $mail->setFrom(Database::USERNAME, 'Vivek-Admin');
            $mail->addAddress($email);
            // $mail->addReplyTo('vs4092344@gmail.com');
            // $mail->addCC('imvivek0777@gmail.com');
            // $mail->addBCC('bcc@example.com');

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reset password';
            $mail->Body = '<h3>Click on the below link to reset your pasword.</h3>
            <p><a href="http://localhost/user_management/reset-pass.php?email='.$email.'&token='.$token.'">http://localhost/user_management/reset-pass.php?email='.$email.'&token='.$token.'</a></p>
            </br>
            <p> Regards </p>
            <strong>Vivek Coolhunter!</strong>';

            $mail->send();
            echo $user->showMessage('success', 'We have sent you reset password link on your registered email-id, please check email.');
        } catch (Exception $e) {
            echo $user->showMessage('danger', 'Something went wrong, please check your email and try again.');
        }
    }else{
        echo $user->showMessage('danger', 'User not found');
    }

}

if (isset($_POST['action']) && $_POST['action'] == 'isLoginCheck') {
    if (!$user->currentUserData($_SESSION['userEmail'])) {
        echo 'Bye';
        unset($_SESSION['userEmail']);
    }
}




?>