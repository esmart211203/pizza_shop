<?php
require_once('db.php');
require_once('order.php');
require_once('order_item.php');
?>

<?php
class Order_Db extends Db{
    public function getAllOrders(){
        $sql = self::$connection->prepare("SELECT * FROM orders");
        $sql->execute(); //return an object

        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        $arrOrder = array();
        foreach($items as $key => $value){
            $arrOrder[] = new Orders($value['order_id'],$value['user_email'],$value['order_date'], $value['total_amount'], 
            $value['status'], $value['full_name'], $value['address'], $value['phone']);
        }
        return $arrOrder;
    }
    public function ApproveOrder($order_id, $status){
        $sql = self::$connection->prepare("UPDATE orders SET status=? WHERE order_id = ?");
        $sql->bind_param("si", $status, $order_id);
        $sql->execute();
    }
    public function CompleteOrder($order_id){
        $sql = self::$connection->prepare("UPDATE orders SET status='Complete the order' WHERE order_id = ?");
        $sql->bind_param("i", $order_id);
        $sql->execute();
    }
    public function getOrderByOrderId($order_id){
        $sql = self::$connection->prepare("SELECT * FROM orderitems WHERE order_id = ?");
        $sql->bind_param("i", $order_id);
        $sql->execute(); //return an object

        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        $arrOrder = array();
        foreach($items as $key => $value){
            $arrOrder[] = new OrderItems($value['order_item_id'],$value['order_id'],$value['product_code'], $value['quantity'], $value['price']);
        }
        return $arrOrder;
    }
    public function OrderStatisticsByMonth(){
        $sql = self::$connection->prepare("SELECT MONTH(order_date) AS month, COUNT(*) AS total_orders
        FROM orders
        GROUP BY MONTH(order_date)");
        $sql->execute();
        
        $orderStatistics = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        
        return $orderStatistics;
    }
    public function calculateOrderTotalPrice($order_id){
        $sql = self::$connection->prepare("SELECT SUM(price * quantity) AS total_price
        FROM orderitems
        WHERE order_id = ?");
        $sql->bind_param("i", $order_id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $total_price = $row['total_price'];
        return $total_price;
    }

}