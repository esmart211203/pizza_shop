<?php
include_once('../Models/user_db.php');

$user_db = new User_db();



//
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

if ($password !== $confirm_password) {
    header("Location: ../Views/register.php");
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user_db->registerUser($email, $hashed_password);
    header("Location: ../Views/login.php");
}
?>
