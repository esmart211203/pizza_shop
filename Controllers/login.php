<?php
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array();
}
include_once('../Models/user_db.php');
$user_db = new User_Db();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu
    $email = $_POST["email"];
    $password = $_POST["password"];

    $role = $user_db->login($email, $password);

    if ($role !== false) {
        $_SESSION['user'] = $email;
        $_SESSION['loggedin'] = true;
    
        if ($role == 1) {
            $_SESSION['is_admin'] = true;
            header("Location: ../Views/manage_product.php");
            exit(); 
        } else {
            $_SESSION['is_admin'] = false; 
            header("Location: ../Views/index.php");
            exit(); 
        }
    } else {
        header("Location: ../Views/index.php");
        exit(); 
    }
}
