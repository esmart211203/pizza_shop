<?php
require_once('header.php');
?>
<?php
require_once('../Models/product_db.php');
$product_db = new Product_Db();
$product_code = $_GET['product_code'] ? $_GET['product_code'] : '';
$get_product = $product_db->getProductByProductCode($product_code);
?>
    <div class="container">
        <hr><br>
        <h1 class="text-center">Trang quan ly</h1>
        <form method="post" action="../Controllers/update_product.php?product_code=<?php echo $product_code ?>" enctype="multipart/form-data"> 
            <div class="row">
            <div class="mb-3 col-3">
                <label for="exampleInputEmail1" class="form-label">Prouct code</label>
                <input type="text" name="product_code" class="form-control" value="<?php echo $get_product->product_code ?>">
            </div>
            <div class="mb-3 col-9">
                <label for="exampleInputEmail1" class="form-label">Prouct name</label>
                <input type="text" name="product_name" class="form-control" value="<?php echo $get_product->product_name ?>">
            </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Prouct image</label>
                <input type="file" name="product_image" class="form-control">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3"><?php echo $get_product->description ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="product_price" class="form-control" min="1" max="99999" value="<?php echo $get_product->product_price ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php
require_once('footer.php');
?>