<?php

include('layouts/header.php');

if (!app('login')->isLoggedIn()) {
  redirect('login.php');
}


$currentUser = app('current_user');
$query = "SELECT * FROM `orders` WHERE `user_id` = :id";
$orders = app('db')->select($query, array('id' => $currentUser->id));

?>

<!--Account-->
<section class="my-5 py-5">
  <div class="row container mx-auto">
    <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
      <h3 class="font-weight-bold">Account Info</h3>
      <hr class="mx-auto">
      <div class="account-info">
        <p>Name: <span><?= $currentUser->name ?></span></p>
        <p>Email: <span><?= $currentUser->email ?></span></p>
        <p><a href="#orders" id="orders-btn">Your Orders</a></p>
        <p><a href="logout.php" id="logout-btn">Logout</a></p>
      </div>
    </div>

    <div class="col-lg-6 col-md-12 col-sm-12">
      <form id="account-form" class="change-pass-form">
        <h3>Change Password</h3>
        <hr class="mx-auto">
        <div class="form-group">
          <label>Old Password</label>
          <input type="password" class="form-control" id="account-password" name="oldPass" placeholder="Old Password" />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control newPass" id="account-password" name="newPass" placeholder="New Password" />
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" class="form-control" id="account-password-confirm" name="newPassConfirm" placeholder="Confirm New Password" />
        </div>
        <div class="form-group">
          <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn">
        </div>
      </form>
    </div>

  </div>
</section>

<!--Orders-->
<secton id="orders" class="orders container my-5 py-3">
  <div class="container mt-2">
    <h2 class="font-weight-bold text-center">Your Orders</h2>
    <hr class="mx-auto">
  </div>

  <table class="mt-5 pt-5">
    <tr>
      <th>Order ID</th>
      <th>Order Cost</th>
      <th>Order Status</th>
      <th>Order Date</th>
      <th>Order Details</th>
    </tr>
    <?php foreach ($orders as $order) : ?>
      <tr>
        <td>
          <span><?= $order['order_id']; ?></span>
        </td>
        <td>
          <span>$<?= $order['order_cost']; ?></span>
        </td>
        <td>
          <span><?= $order['order_status']; ?></span>
        </td>
        <td>
          <span><?= $order['order_date']; ?></span>
        </td>
        <td>
          <form method="POST" action="order_details.php">
            <input type="hidden" value="<?= $order['order_status']; ?>" name="order_status" />
            <input type="hidden" value="<?= $order['order_id']; ?>" name="order_id" />
            <input class="btn order-details-btn" name="order_details_btn" type="submit" value="Details" />
          </form>
        </td>


      </tr>
    <?php endforeach; ?>
  </table>
</secton>

<?php include('layouts/footer.php'); ?>