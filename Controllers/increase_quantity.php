<?php
include_once('../Models/user_db.php');
$user_db = new User_Db();
$user_email = isset($_GET['user_email']) ? $_GET['user_email'] : '';
$product_code = isset($_GET['product_code']) ? $_GET['product_code'] : '';

if ($user_email && $product_code != '') {
    $user_db->increaseQuantity($user_email, $product_code);
    header("Location: ../Views/my_cart.php");
    exit();
} else {
    header("Location: ../Views/my_cart.php");
    exit();
}
?>