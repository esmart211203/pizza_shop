<?php
include_once('../Models/product_db.php');
include_once('../Models/product.php');
$product_db = new Product_Db();

$product_code = $_GET['product_code'] ? $_GET['product_code'] : '';
$get_product = $product_db->getProductByProductCode($product_code);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $new_product_price = isset($_POST['product_price']) ? $_POST['product_price'] : 0;
    $new_description = isset($_POST['description']) ? $_POST['description'] : '';
    //update
    $get_product->product_name = $new_product_name;
    $get_product->product_price = $new_product_price;
    $get_product->description = $new_description;
    
    $image = '';
    $previous_photo = $get_product->product_image;
    // Kiểm tra xem có tệp ảnh mới được chọn hay không
    if (isset($_FILES['product_image']['name']) && !empty($_FILES['product_image']['name'])) {
        $image = basename($_FILES['product_image']['name']);
        $target_dir = '../uploads/';
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
        $get_product->product_image = $image;
    } else {
        // Nếu không có ảnh mới, sử dụng ảnh cũ
        $image = $previous_photo;
    }
    $product_db->updateProduct($get_product);

    header("Location: ../Views/manage_product.php?msg3=insert");
}