<?php
include_once('../Models/order_db.php');
$order_db = new Order_Db();

$order_id = $_GET['order_id'] ? $_GET['order_id'] : 0;
$status = 'Approve order';
$order_db->ApproveOrder($order_id, $status);
header("Location: ../Views/order_management.php?msg=success");