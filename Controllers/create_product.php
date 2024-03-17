<?php
include_once('../Models/product_db.php');
include_once('../Models/product.php');
$product_db = new Product_Db();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_code = isset($_POST['product_code']) ? $_POST['product_code'] : '';
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : 0;
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $image = '';

    if (isset($_FILES['product_image']['name'])) {
        $image = basename($_FILES['product_image']['name']);
        $target_dir = '../uploads/';
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
    }
    $new_product = new Product($product_code, $product_name, $image, $product_price, $description);
    $product_db->createProduct($new_product);

    header("Location: ../Views/manage_product.php?msg3=insert");
}