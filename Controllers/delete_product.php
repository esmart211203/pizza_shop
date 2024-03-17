<?php

include_once('../Models/product_db.php');
$product_db = new Product_Db();

$product_code = isset($_POST['product_code']) ? $_POST['product_code'] : '';

$product_db->deleteProduct($product_code);
header("Location: ../Views/manage_product.php");
exit();