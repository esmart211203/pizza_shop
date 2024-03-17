    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
            form{
                width: 500px;
            }
            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                font-weight: bold;
            }

            input[type="text"] {
                width: 100%;
                padding: 8px;
                border-radius: 4px;
                border: 1px solid #ccc;
            }

            button[type="submit"] {
                padding: 8px 16px;
                border-radius: 4px;
                border: none;
                background-color: #007bff;
                color: #fff;
                cursor: pointer;
            }

            button[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
<?php
session_start();
include_once('base.php');
require_once('../Models/user_db.php');
require_once('../Models/product_db.php');
$user_db = new User_Db(); 
$product_db = new Product_Db(); 
$user_email = $_SESSION['user'];
$my_order = $user_db->getOrder($user_email);
$cart_items = $user_db->getMyCart($user_email);
//get product in cart
$arr_product_code = array();
foreach($cart_items as $data){
    $product = $product_db->getProductByProductCode($data['product_code']);
    if ($product) {
        $arr_product_code[] = $product;
    }
}
?>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
		      <a class="navbar-brand" href="index.php"><span class="flaticon-pizza-1 mr-1"></span>Pizza<br><small>Delicous</small></a>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="oi oi-menu"></span> Menu
		      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="my_cart.php" class="nav-link">My cart</a></li>
	          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
			  <?php
				if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
					echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>';
				} else {
					echo '<li class="nav-item"><a href="../Controllers/logout.php" class="nav-link">Logout</a></li>';
				}
				?>
	        </ul>
	      </div>
		  </div>
	</nav>

    <div class="container bg-light mt-5">
        <?php
            if (isset($_GET['msg']) == "success") {
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        Ordered successfully
                        </div>";
            } 
        ?>
        <table class="table">
            <thead>
                <tr>
                <th scope="col"><h1 style="color: black;">Shopping Cart</h1></th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arr_product_code as $key => $value) { ?>
                <tr>
                    <th scope="row">
                        <img style="width: 100px;" src="../uploads/<?php echo $value->product_image ?>" alt="">
                    </th>
                    <td><?php echo $value->product_price ?></td>
                    <td>
                    <?php 
                        $quantity = $user_db->getQuantity($user_email, $value->product_code);
                        if ($quantity >= 1) { 
                            echo '<a href="../Controllers/decrease_quantity.php?user_email=' . $user_email . '&product_code=' . $value->product_code . '" class="btn btn-primary">-</a>';
                        }
                        echo '<span class="p-2" style="border: 1px solid black; border-radius: 10px;">' . $quantity . '</span>';
                        echo '<a href="../Controllers/increase_quantity.php?user_email=' . $user_email . '&product_code=' . $value->product_code . '" class="btn btn-primary">+</a>';?>
                    </td>
                    <td>
                        <a href="../Controllers/delete_cart_item.php?product_code=<?php echo $value->product_code; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if($arr_product_code) { ?>
            <form action="../Controllers/checkout.php" method="post">
            <label for="">Username</label>
                <input type="text" name="full_name" required><br>
            <label for="phone">Phone</label>
                <input type="text" name="phone" pattern="[0-9]{10}" required>
            <label for="">Address</label>
                <input type="text" name="address" required>
            <button type="submit" class="btn btn-primary mb-3 mt-2">Checkout</button>
        </form>
        <?php } ?>
        <br><br>
        <?php if ($my_order) { ?>
            <h1 class="text-center" style="color: black;">Manage order</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><h1 style="color: black;">User order</h1></th>
                        <th scope="col">Total amount</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Order date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($my_order as $key => $value) { ?>
                        <tr>
                            <th scope="row">
                                <?php echo $value['full_name'] ?>
                            </th>
                            <td><?php echo $value['total_amount'] ?></td>
                            <td><?php echo $value['phone'] ?></td>
                            <td><?php echo $value['address'] ?></td>
                            <td><?php echo $value['order_date'] ?></td>
                            <td><?php echo $value['status'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>