<?php
// Include
include('layouts/header.php');

// Logic
if (isset($_GET['product_id'])) {

  $product_id = $_GET['product_id'];

  $product = app('db')->select(
    "SELECT * FROM `products` WHERE `product_id` = :id",
    array("id" => $product_id)
  );

  // no product id was given
} else {

  header('location: /');
}
?>



<!--Single Product-->
<section class="container single-product my-5 pt-5">
  <div class="row mt-5">
    <?php foreach ($product as $item) : ?>

      <div class="col-lg-5 col-md-6 col-sm-12">
        <img class="img-fluid w-100 pb-1" src="assets/imgs/<?= $item['product_image']; ?>" id="mainImg" />
        <div class="small-image-group">
          <div class="small-image-col">
            <img src="assets/imgs/<?= $item['product_image']; ?>" width="100%" class="small-image" />
          </div>
          <div class="small-image-col">
            <img src="assets/imgs/<?= $item['product_image2']; ?>" width="100%" class="small-image" />
          </div>
          <div class="small-image-col">
            <img src="assets/imgs/<?= $item['product_image3']; ?>" width="100%" class="small-image" />
          </div>
          <div class="small-image-col">
            <img src="assets/imgs/<?= $item['product_image4']; ?>" width="100%" class="small-image" />
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12">
        <h6>Keyboards/Mice</h6>
        <h3 class="py-4"><?= $item['product_name']; ?></h3>
        <h2><?= $item['product_price']; ?></h2>

        <form method="POST" action="cart">
          <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>" />
          <input type="hidden" name="product_image" value="<?= $item['product_image']; ?>" />
          <input type="hidden" name="product_name" value="<?= $item['product_name']; ?>">
          <input type="hidden" name="product_price" value="<?= $item['product_price']; ?>">
          <input type="number" min=0 name="product_quantity" value="1" />
          <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>
        </form>

        <h4 class="mt-5 mb-5">Product Details</h4>
        <span><?= $item['product_description']; ?></span>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<script>
  var mainImg = document.getElementById("mainImg");
  var smallImg = document.getElementsByClassName("small-image");

  for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function() {
      mainImg.src = smallImg[i].src
    }
  }
</script>

<?php include('layouts/footer.php'); ?>