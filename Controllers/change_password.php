<?php
session_start(); // Bắt đầu session
$user_email = $_SESSION['user'];
include_once('../Models/user_db.php');
$user_db = new User_Db();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $user_db->changePassword($user_email, $current_password, $new_password);
        header("Location: ../Views/profile.php?msg3=success");
        exit();
    } 
    header("Location: ../Views/profile.php?msg3=danger");
    exit();
}
?>