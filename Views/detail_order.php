<?php
require_once('header.php');
require_once('../Models/order_db.php');
$order_db = new Order_Db();
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
$total_price_order = $order_db->calculateOrderTotalPrice($order_id);
$detail_order_item = $order_db->getOrderByOrderId($order_id);
?>
<div class="container">
    <h1 class="text-center">Detail order</h1>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Product code</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail_order_item as $key => $value) { ?>
            <tr>
                <th scope="row"><?php echo ++$key ?></th>
                <td><?php echo $value->product_code  ?></td>
                <td><?php echo $value->quantity  ?></td>
                <td>$<?php echo $value->price  ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <span class="badge badge-primary">Total orders: $<?php echo $total_price_order ?></span>
</div>
<?php
require_once('footer.php');
?>