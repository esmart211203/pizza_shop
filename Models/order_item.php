<?php
require_once('db.php');
class OrderItems{
    public $order_item_id;
    public $order_id;
    public $product_code;
    public $quantity;
    public $price;
    public function __construct($order_item_id, $order_id, $product_code, $quantity, $price){
        $this->order_item_id = $order_item_id;
        $this->order_id = $order_id;
        $this->product_code = $product_code;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}