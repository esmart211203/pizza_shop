<?php
include_once('base.php');
require_once('../Models/product_db.php');
$product_db = new Product_Db();
$products = $product_db->getAllProduct();
$get_product = $product_db->getProductByProductCode('pro1');
var_dump($get_product);
?>
    <div class="container">
        <h1 class="text-center">Trang quan ly</h1>
        <form method="post" action="../Controllers/create_product.php" enctype="multipart/form-data"> 
            <div class="row">
            <div class="mb-3 col-3">
                <label for="exampleInputEmail1" class="form-label">Prouct code</label>
                <input type="text" name="product_code" class="form-control">
            </div>
            <div class="mb-3 col-9">
                <label for="exampleInputEmail1" class="form-label">Prouct name</label>
                <input type="text" name="product_name" class="form-control">
            </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Prouct image</label>
                <input type="file" name="product_image" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="product_price" class="form-control" min="1" max="1000" value="1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <table class="table  table-bordered mt-5 ">
  <thead>
    <tr>
      <th scope="col">Code</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Description</th>
      <th scope="col">Image</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $key => $value) {
    ?>
    <tr>
      <th scope="row"><?php echo $value->product_code ?></th>
      <td><?php echo $value->product_name ?></td>
      <td><?php echo $value->product_price ?></td>
      <td><?php echo $value->description ?></td>
      <td>
        <img src="../uploads/<?php echo $value->product_image  ?>" width="50px;" alt="aa">
      </td>
      <td>
        <form action="../Controllers/delete_product.php" method="post">
            <input type="hidden" name="ma" value="<?php echo $value->ma ?>">
            <a href="edit_product.php?product_code=<?php echo $value->product_code ?>" class="btn btn-info">Edit</a>
            <button class="btn btn-danger">Xoa</button>
        </form>
      </td>
    </tr>  
    <?php  }  ?> 
  </tbody>
</table>
  </div>