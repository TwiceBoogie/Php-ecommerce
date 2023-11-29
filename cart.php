<?php

include('layouts/header.php');

if (isset($_POST['add_to_cart'])) {

  //if user has already added product to cart
  if (isset($_SESSION['cart'])) {

    $products_array_ids = array_column($_SESSION['cart'], "product_id"); // Array with all products ids
    // if product has already been added to cart or not
    if (!in_array($_POST['product_id'], $products_array_ids)) {

      $product_id = $_POST['product_id'];

      $product_array = array(
        'product_id' => $_POST['product_id'],
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_image' => $_POST['product_image'],
        'product_quantity' => $_POST['product_quantity']
      );

      $_SESSION['cart'][$product_id] = $product_array;
    } else {
      echo '<script>alert("Product was already added!");</script>';
    }

    // if this is the first product
  } else {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];


    $product_array = array(
      'product_id' => $product_id,
      'product_name' => $product_name,
      'product_price' => $product_price,
      'product_image' => $product_image,
      'product_quantity' => $product_quantity
    );

    $_SESSION['cart'][$product_id] = $product_array;
  }

  //Calculate Total
  calculateTotalCart();

  //Remove Product from Cart
} else if (isset($_POST['remove_product'])) {

  $product_id = $_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);

  //calculate total
  calculateTotalCart();
} else if (isset($_POST['edit_quantity'])) {

  //Get ID and Quantity from the form
  $product_id = $_POST['product_id'];
  $product_quantity = $_POST['product_quantity'];

  //Extract the product array from the session
  $product_array = $_SESSION['cart'][$product_id];

  //Update Product Quantity
  $product_array['product_quantity'] = $product_quantity;


  //Return array to back to its place in the session
  $_SESSION['cart'][$product_id] = $product_array;


  //calculate total
  calculateTotalCart();
} else {
  //header('location:index.php');
}


function calculateTotalCart()
{

  $total = 0;

  foreach ($_SESSION['cart'] as $key => $value) {

    $product = $_SESSION['cart'][$key];

    $price = $product['product_price'];
    $quantity = $product['product_quantity'];


    $total = $total +  ($price * $quantity);
  }

  $_SESSION['total'] = $total;
}


?>



<br>
<br>
<br>
<!--Cart-->
<secton class="cart container my-10 py-5">
  <div class="container mt-5">
    <h2 class="font-weight-bolde">Your Cart</h2>
    <hr>
  </div>

  <table class="mt-5 pt-5">
    <tr>
      <th>Product</th>
      <th>Quantity</th>
      <th>Subtotal</th>
    </tr>
    <?php if (isset($_SESSION['cart'])) { ?>
      <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
        <tr>
          <td>
            <div class="product-info">
              <img src="assets/imgs/<?php echo $value['product_image']; ?>" />
              <div>
                <p><?php echo $value['product_name']; ?></p>
                <small><span>$</span><?php echo $value['product_price']; ?></small>
                <br>
                <form method="POST" action="cart">
                  <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                  <input type="submit" name="remove_product" class="remove-btn" value="remove" />
                </form>
              </div>
            </div>
          </td>

          <td>

            <form method="POST" action="cart">
              <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
              <input type="number" min=0 name="product_quantity" value="<?php echo $value['product_quantity']; ?>" />
              <input type="submit" name="edit_quantity" value="edit" class="edit-btn" />
            </form>

          </td>

          <td>
            <span>$</span>
            <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
          </td>
        </tr>
      <?php } ?>
    <?php } ?>
  </table>
  <div class="cart-total">
    <table>
      <tr>
        <td>Total</td>
        <?php if (isset($_SESSION['total'])) { ?>
          <!--Can also use ['cart']-->
          <td>$<?php echo $_SESSION['total']; ?></td>
        <?php } ?>
      </tr>
    </table>
  </div>

  <div class="checkout-container">

    <form method="POST" action="checkout">
      <input type="submit" value="Checkout" name="checkout" class="btn checkout-btn" />
    </form>

  </div>

</secton>

<?php include('layouts/footer.php'); ?>