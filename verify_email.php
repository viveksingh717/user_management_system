<?php 

require 'php/session.php';

$users = new Auth();

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $users->verify_user($email);

    header('location:profile.php');
    exit();

}else{
    header('location:home.php');
    exit();
}

?>