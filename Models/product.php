<?php
require_once('db.php');
?>
<?php
class Product{
    public $product_code;
    public $product_name;
    public $product_image;
    public $product_price;
    public $description;
    public function __construct($product_code,$product_name,$product_image,$product_price,$description){
        $this->product_code = $product_code;
        $this->product_name = $product_name;
        $this->product_image = $product_image;
        $this->product_price = $product_price;
        $this->description = $description;
    }
}
?>