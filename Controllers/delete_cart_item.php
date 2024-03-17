<?php
include_once('../Models/user_db.php');
$user_db = new User_Db();
$product_code = $_GET['product_code'] ? $_GET['product_code'] : '';
$user_db->deleteCartItem($product_code);
header("Location: ../Views/my_cart.php");