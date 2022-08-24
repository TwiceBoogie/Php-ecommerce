<?php
include('layouts/header.php');

if (!app('login')->isLoggedIn()) {
    echo '<script>alert("You Need to Login to Checkout");</script>';
    redirect('login.php');
}

if (!empty($_SESSION['cart'])) {

    //If Cart is not Empty, Let user in 
    $user = app('db')->select(
        "SELECT `users`.*, `user_details`.`phone`, `user_details`.`city`, `user_details`.`address` 
        FROM `users` LEFT JOIN `user_details` ON `users`.`user_id` = `user_details`.`user_id` WHERE `users`.`user_id` = :id",
        array("id" => SecureSession::get("user_id"))
    );
} else {

    //If cart is empty,send user to home page
    redirect("index.php");
}

?>

<!--Checkout-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Check Out</h2>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container">

        <form id="checkout-form">
            <?php foreach ($user as $var) : ?>
                <div class="form-group checkout-small-element">
                    <label>Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" value="<?= $var['user_name'] ?>" />
                </div>
                <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" value="<?= $var['user_email'] ?>" />
                </div>
                <div class="form-group checkout-small-element">
                    <label>Phone</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" value="<?= $var['phone'] ?>" />
                </div>
                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" value="<?= $var['city'] ?>" />
                </div>
                <div class="form-group checkout-large-element">
                    <label>
                        <Address></Address>
                    </label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" value="<?= $var['address'] ?>" />
                </div>
            <?php endforeach; ?>
            <div class="form-group checkout-btn-container">
                <?php if (isset($_SESSION['cart'])) { ?>
                    <p>Total Amount: $ <?php echo $_SESSION['total']; ?></p>
                <?php } ?>
                <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order" />
            </div>
        </form>
    </div>
</section>

<?php include('layouts/footer.php'); ?>