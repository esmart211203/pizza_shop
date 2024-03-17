<?php
require_once('db.php');
require_once('user.php');
?>

<!-- Loi thuong gap
    extends Db 
-->
<?php
class User_Db extends Db{
    public function login($email, $password) {
        $sql = self::$connection->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $sql->bind_param("ss", $email, $password);
        $sql->execute();
        
        $result = $sql->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            return $user['role'];
        } else {
            return null;
        }
    }
    public function addToCart($user_email, $product_code) {
        $stmt = self::$connection->prepare("INSERT INTO cart (user_email, product_code, quantity) VALUES (?,?,1)");
        $stmt->bind_param("ss", $user_email, $product_code);
        $stmt->execute();
    }
    public function getMyCart($user_email) {
        $stmt = self::$connection->prepare("SELECT * FROM cart WHERE user_email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $cart_items = array();
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
        }
    
        return $cart_items;
    }
    
    public function deleteCartItem($product_code) {
        $stmt = self::$connection->prepare("DELETE FROM cart WHERE product_code = ?");
        $stmt->bind_param("s", $product_code);
        $stmt->execute();
    }
    public function getProductPriceByCode($product_code) {
        $sql = self::$connection->prepare("SELECT product_price FROM product WHERE product_code = ?");
        $sql->bind_param("s", $product_code);
        $sql->execute();
    
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
    
        if ($row) {
            return $row['product_price'];
        } else {
            return null;
        }
    }
    
    public function checkout($user_email,$full_name,$address,$phone){
        $order_date = date("Y-m-d H:i:s");
        $query = "SELECT COUNT(*) as total FROM cart WHERE user_email = '$user_email'";
        $result = self::$connection->query($query);
        $row = $result->fetch_assoc();
        
        $total_amount = $row['total'];
        $status = "Processing"; 
        $sql = "INSERT INTO orders (user_email, order_date, total_amount, status, full_name, address, phone) 
        VALUES ('$user_email', '$order_date', '$total_amount', '$status', '$full_name', '$address', '$phone')";
        if (self::$connection->query($sql) === TRUE) {
            $order_id = self::$connection->insert_id; 
        
            $cart_query = "SELECT * FROM cart WHERE user_email = '$user_email'";
            $cart_result = self::$connection->query($cart_query);
        
            while ($row = $cart_result->fetch_assoc()) {
                $product_code = $row['product_code'];
                $quantity = $row['quantity'];
                $price = $this->getProductPriceByCode($product_code);
        
                $order_item_query = "INSERT INTO orderitems (order_id, product_code, quantity, price) 
                                    VALUES ('$order_id', '$product_code', '$quantity', '$price')";
                self::$connection->query($order_item_query);
            }
            //remove cart
            $del_cart = "DELETE FROM cart WHERE user_email = '$user_email'";
            $del_cart = self::$connection->query($del_cart);
            header("Location: ../Views/my_cart.php?msg='success'");
        } else {
            header("Location: ../Views/my_cart.php");
        }
    }
    public function getOrder($user_email){
        $stmt = self::$connection->prepare("SELECT * FROM orders WHERE user_email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $order_items = array();
        while ($row = $result->fetch_assoc()) {
            $order_items[] = $row;
        }
    
        return $order_items;
    }
    public function getAllUser(){
        $sql = self::$connection->prepare("SELECT * FROM user");
        $sql->execute(); //return an object
        
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        $arrUser = array();
        foreach($items as $key => $value){
            $arrUser[] = new User($value['id'], $value['email'], $value['password'], $value['status'], $value['role']);
        }
        return $arrUser;
    }
    public function deleteUserById($id){
        $stmt = self::$connection->prepare("DELETE FROM user WHERE id = $id");
        $stmt->execute();
    }
    public function blockUser($id){
        $stmt = self::$connection->prepare("UPDATE user SET status = 'block' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    public function unblockUser($id){
        $stmt = self::$connection->prepare("UPDATE user SET status = 'active' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    public function changePassword($email, $current_password, $new_password){
        $sql = self::$connection->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $sql->bind_param("ss", $email, $current_password);
        $sql->execute();
    
        $result = $sql->get_result();
        $user = $result->fetch_assoc();
    
        if ($user) {
            $sql = self::$connection->prepare("UPDATE user SET password = ? WHERE email = ?");
            $sql->bind_param("ss", $new_password, $email);
            $sql->execute();
            return true;
        } else {
            header("Location: ../Views/profile.php?msg3=danger");
            exit();
        }
    }
    public function registerUser($email, $password){
        $status = 'active';
        $role = 1;
        $stmt = self::$connection->prepare("INSERT INTO user (email, password, status, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $email, $password, $status, $role);
        $stmt->execute();
    }
    public function increaseQuantity($user_email, $product_code){
        $stmt = self::$connection->prepare("UPDATE cart
        SET quantity = quantity + 1
        WHERE user_email = ? AND product_code = ?");
        $stmt->bind_param("ss", $user_email, $product_code);
        $stmt->execute();
    }
    public function decreaseQuantity($user_email, $product_code){
        $stmt = self::$connection->prepare("UPDATE cart
        SET quantity = quantity - 1
        WHERE user_email = ? AND product_code = ?");
        $stmt->bind_param("ss", $user_email, $product_code);
        $stmt->execute();
    }
    public function getQuantity($user_email, $product_code){
        $stmt = self::$connection->prepare("SELECT quantity FROM cart WHERE user_email = ? AND product_code = ?");
        $stmt->bind_param("ss", $user_email, $product_code);
        $stmt->execute();
        $stmt->bind_result($quantity);
        $stmt->fetch();
        $stmt->close();
        return $quantity;
    }
}