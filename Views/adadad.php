<?php
require_once('header.php');                
?>
<?php
require_once('../Models/product_db.php');
$product_db = new Product_Db();
$products = $product_db->getAllProduct();
?>

<?php
require_once('footer.php');