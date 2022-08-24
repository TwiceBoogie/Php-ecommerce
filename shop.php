<?php

include('layouts/header.php');

$products = app('db')->select(
  "SELECT * FROM `products`"
);
?>

<!--Products-->
<section id="shop" class="my-5 py-5">
  <div class="container mt-5 py-5">
    <h3>Our Products</h3>
    <hr>
    <p>Here you can check out our new featured products</p>
  </div>
  <div class="row mx-auto container">


    <?php foreach ($products as $product) : ?>

      <div onclick="window.location.href='single_product.php?product_id=<?= $product['product_id']; ?>';" class="product text-center col-lg-3 col-md-4 col-sm-12">
        <a href="single_product.php?product_id=<?= $product['product_id'] ?>"><img class="img-fluid mb-3" src="assets/imgs/<?= $product['product_image']; ?>" /></a>
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <div>
          <h5 class="p-name"><?= $product['product_name']; ?></h5>
          <h4 class="p-price">$<?= $product['product_price']; ?></h4>
        </div>
        <a class="btn shop-buy-btn" href="single_product.php?product_id=<?= $product['product_id']; ?>">Buy Now</a>
      </div>

    <?php endforeach; ?>

  </div>

</section>


<?php include('layouts/footer.php'); ?>