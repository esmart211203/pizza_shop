<?php
session_start(); // (session)
include_once('../Models/user_db.php');
$user_db = new User_db();
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array();
}
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../Views/login.php");
    exit();
}else{
    $user_email = $_SESSION['user'];
    $product_code = $_GET['product_code'];
    $add_to_cart = $user_db->addToCart($user_email,$product_code);
    header("Location: ../Views/my_cart.php");
    exit();
}
?>
