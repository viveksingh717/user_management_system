<?php 
session_start();

require_once 'config/auth.php';

$current_userData = new Auth();

if (!isset($_SESSION['userEmail'])) {
    header('location:index.php');
}

$cemail = $_SESSION['userEmail'];
$userData = $current_userData->currentUserData($cemail);

$user_id = $userData['id'];
$user_name = $userData['name'];
$user_email = $userData['email'];
$user_contact = $userData['phone'];
$user_pass = $userData['password'];
$user_gender = $userData['gender'];
$user_dob = $userData['dob'];
$user_photo = $userData['photo'];
$user_created = $userData['created_at'];
$user_verified = $userData['verified'];
$user_token = $userData['token'];
$user_firstName = strtok($user_name, " ");

$dateFormate = date('d M Y', strtotime($user_created));

if ($user_verified == 0) {
    $user_verified = 'Not Verified';
}else{
    $user_verified = 'Verified';
}





?>