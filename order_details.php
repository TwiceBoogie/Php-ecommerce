<?php

include('layouts/header.php');

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $order_details = app('db')->select(
        "SELECT `order_items`.*, `products`.`product_image` FROM `order_items`, `products` WHERE `order_id`=:id AND `products`.`product_id` = `order_items`.`product_id`",
        array("id" => $order_id)
    );

    $order_total_price = calculateTotalOrderPrice($order_details);
} else {

    header('location: account');
    exit;
}

function calculateTotalOrderPrice($order_details)
{

    $total = 0;
    print_r($order_details);

    foreach ($order_details as $row) {
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];

        $total = $total + ($product_price * $product_quantity);
    }

    return $total;
}
?>

<!--Order Details-->
<secton id="orders" class="orders container my-5 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center">Order Details</h2>
        <hr class="mx-auto">
    </div>

    <table class="mt-5 pt-5 mx-auto">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>

        </tr>
        <?php foreach ($order_details as $row) : ?>

            <tr>
                <td>
                    <div>
                        <img src="./assets/imgs/<?= $row['product_image']; ?>">
                        <div>
                            <p class="mt-3"><?= $row['product_name']; ?></p>
                        </div>
                    </div>

                </td>
                <td>
                    <span>$<?= $row['product_price']; ?></span>
                </td>
                <td>
                    <span><?= $row['product_quantity']; ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($order_status == "Not Paid") : ?>
        <form style="float: right;" method="POST" action="payment">
            <input type="hidden" name="order_total_price" value="<?= $order_total_price; ?>" />
            <input type="hidden" name="order_status" value="<?= $order_status; ?>" />
            <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now" />
        </form>
    <?php endif; ?>
</secton>

<?php include('layouts/footer.php'); ?>