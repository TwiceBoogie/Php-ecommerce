<?php

include("./layouts/header.php");

$keyboards = app('db')->select(
  "SELECT * FROM `products` WHERE `product_category`='keyboards' LIMIT 4"
);
$mice = app('db')->select(
  "SELECT * FROM `products` WHERE `product_category`='mice' LIMIT 4"
);
?>
<main>
  <section id="home">
    <div class="container">
      <h5>Don't Just Grow...</h5>
      <h1><span>Evolve</span> Stay Ahead of the Competition!</h1>
      <p>Check out quaity products at the most affordable prices!</p>
      <a href="shop.php"><button>Shop Now</button></a>
    </div>
  </section>


  <!--New-->
  <section id="new" class="w-100">
    <div class="row p-0 m-0">
      <!--One-->
      <div class="one col-lg-4 col-md-6 col-sm-12 p-0">
        <img class="img-fluid" src="assets/imgs/one.jpg" />
        <div class="details">
          <h2>Keyboards</h2>
          <a href="shop.php"><button class="text-uppercase">Show Now</button></a>
        </div>
      </div>
      <!--Two-->
      <div class="one col-lg-4 col-md-6 col-sm-12 p-0">
        <img class="img-fluid" src="assets/imgs/two.jpg" />
        <div class="details">
          <h2>Mice</h2>
          <a href="shop.php"><button class="text-uppercase">Show Now</button></a>
        </div>
      </div>

      <!--Three-->
      <div class="one col-lg-4 col-md-6 col-sm-12 p-0">
        <img class="img-fluid" src="assets/imgs/three.jpg" />
        <div class="details">
          <h2>Much More!</h2>
          <a href="shop.php"><button class="text-uppercase">Show Now</button></a>
        </div>
      </div>
    </div>
  </section>

  <!--Featured Keyboards-->
  <section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
      <h3>Featured Keyboards</h3>
      <hr class="mx-auto">
      <p>Here you can check out our wicked awesome Keyboards!</p>
    </div>
    <div class="row mx-auto container-fluid">

      <?php foreach ($keyboards as $keyboard) : ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <a href="single_product.php?product_id=<?= $keyboard['product_id']; ?>"><img class="img-fluid mb-3" src="assets/imgs/<?= $keyboard['product_image']; ?>" /></a>
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?= $keyboard['product_name']; ?></h5>
          <h4 class="p-price">$<?= $keyboard['product_price']; ?></h4>
          <a href="single_product.php?product_id=<?= $keyboard['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!--Banner-->
  <section id="banner" class="my-5 py-5">
    <div class="container">
      <h4>Good things are coming!</h4>
      <h1><br></h1>
      <a href="shop.php"><button class="text-uppercase">Shop Now</button></a>
    </div>
  </section>

  <!--Featured Mice-->
  <section id="clothes" class="my-5">
    <div class="container text-center mt-5 py-5">
      <h3>Featured Mice</h3>
      <hr class="mx-auto">
      <p>Here you can check out our amazing selection of Mice!</p>
    </div>
    <div class="row mx-auto container-fluid">

      <?php foreach ($mice as $mouse) : ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <a href="single_product.php?product_id=<?= $mouse['product_id']; ?>"><img class="img-fluid mb-3" src="assets/imgs/<?= $mouse['product_image']; ?>" /></a>
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?= $mouse['product_name']; ?></h5>
          <h4 class="p-price">$<?= $mouse['product_price']; ?></h4>
          <a href="single_product.php?product_id=<?= $mouse['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

</main>
<!--Home-->
<?php include('layouts/footer.php'); ?>