<?php

include('layouts/header.php');

if (isset($_POST['order_pay_btn'])) {
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
}
?>

<!--Payment-->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Order Placed Successfully</h2>
        <hr class="mx-auto">
        <a href="account#orders"><input class="btn btn-primary" type="submit" value="Your Orders" /></a>
    </div>
</section>

<?php include('layouts/footer.php'); ?>