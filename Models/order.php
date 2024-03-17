<?php
require_once('db.php');
class Orders{
    public $order_id;
    public $user_email;
    public $order_date;
    public $total_amount;
    public $status;
    public $full_name;
    public $address;
    public $phone;
    public function __construct($order_id, $user_email,$order_date,$total_amount,$status, $full_name, $address, $phone){
        $this->order_id = $order_id;
        $this->user_email = $user_email;
        $this->order_date = $order_date;
        $this->total_amount = $total_amount;
        $this->status = $status;
        $this->full_name = $full_name;
        $this->address = $address;
        $this->phone = $phone;
    }
}