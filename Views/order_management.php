<?php
session_start();
require_once('header.php');

if ($_SESSION['is_admin'] === true) {
    require_once('../Models/order_db.php');
    $order_db = new Order_Db();
    $orders = $order_db->getAllOrders();
    $order_statistics = $order_db->OrderStatisticsByMonth();
?>
    <div class="container">
        <h1 class="text-center">Order Management</h1>
        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == "success") {
            echo "<div class='alert alert-success alert-dismissible'>
            Order accepted
            </div>";
        }
        ?>
        <table class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">Email Order</th>
                    <th scope="col">Total amount</th>
                    <th scope="col">Username</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $key => $value) { ?>
                    <tr>
                        <th scope="row"><?php echo $value->user_email ?></th>
                        <td><?php echo $value->total_amount ?></td>
                        <td><?php echo $value->full_name ?></td>
                        <td><?php echo $value->phone ?></td>
                        <td><?php echo $value->status ?></td>
                        <td>
                            <?php if ($value->status === 'Processing') {
                                echo '<a href="../Controllers/approve_order.php?order_id=' . $value->order_id . '" class="btn btn-primary">Approve</a>';
                            } else if($value->status === 'Approve order'){
                                echo '<a href="../Controllers/complete_order.php?order_id=' . $value->order_id . '" class="btn btn-info">Complete</a>';
                            }?>
                            <a href="detail_order.php?order_id=<?php echo $value->order_id ?>" class="btn btn-primary">Detail</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <hr width="50%">
        <h1 class="text-center">Order statistics by month</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">month</th>
                    <th scope="col">total_orders</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_statistics as $key => $value) { ?>
                    <tr>
                        <th scope="row"><?php echo ++$key ?></th>
                        <td><?php echo $value['month'] ?></td>
                        <td><?php echo $value['total_orders'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo 'Không thể truy cập';
}

require_once('footer.php');
?>