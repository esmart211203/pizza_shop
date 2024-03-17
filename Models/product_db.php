<?php
require_once('db.php');
require_once('product.php');
?>

<!-- Loi thuong gap
    extends Db 
-->
<?php
class Product_Db extends Db{
    public function getAllProduct(){
        $sql = self::$connection->prepare("SELECT * FROM product");
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        $arrProduct = array();
        foreach($items as $key => $value){
            $arrProduct[] = new Product($value['product_code'],$value['product_name'], $value['product_image'], 
            $value['product_price'], $value['description']);
        }
        return $arrProduct;
    }
    public function createProduct($product){
        $stmt = self::$connection->prepare("INSERT INTO product (product_code, product_name, product_image, product_price, description) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssis",$product->product_code, $product->product_name, $product->product_image, $product->product_price, $product->description);
        $stmt->execute();
    }
    public function updateProduct($product){
        $stmt = self::$connection->prepare("UPDATE product SET product_name=?, product_image=?, product_price=?, description=? WHERE product_code=?");
        $stmt->bind_param("ssiss", $product->product_name, $product->product_image, $product->product_price, $product->description, $product->product_code);
        $stmt->execute();
    }
    public function deleteProduct($product_code){
        $stmt = self::$connection->prepare("DELETE FROM product WHERE product_code = ?");
        $stmt->bind_param("s", $product_code);
        $stmt->execute();
    }
    public function getProductByProductCode($product_code){
        $sql = self::$connection->prepare("SELECT * FROM product WHERE product_code = ?");
        $sql->bind_param("s", $product_code);
        $sql->execute();
    
        $result = $sql->get_result();
    
        if ($row = $result->fetch_assoc()) {
            $product = new Product($row['product_code'], $row['product_name'], $row['product_image'], $row['product_price'], $row['description']);
            return $product;
        }
    
        return null;
    }
}
?>