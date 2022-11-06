<?php 
session_start();

unset($_SESSION['userName']);
unset($_SESSION['userEmail']);

header('location:../index.php');

?>