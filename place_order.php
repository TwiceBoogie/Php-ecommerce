<?php

if (!app('login')->isLoggedIn()) {
    redirect('checkout.php');
}



if (isset($_POST['place_order'])) {


    app('db')->insert("orders", array(
        "order_cost" => SecureSession::get('total'),
        "order_status" => "Order Pending",
        "user_id" => SecureSession::get('user_id'),
    ));

    //2. Issue New Order and Store Order Information in DB

    $order_id = app('db')->lastInsertId();



    //3. Get Products from Cart (from Session)
    foreach ($_SESSION['cart'] as $key => $value) {

        $product = $_SESSION['cart'][$key]; //Returns array with product []
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];

        //4. Store each single item in order_items DB
        app('db')->insert("order_items", array(
            "order_id" => $order_id,
            "product_id" => $product_id,
            "product_name" => $product_name,
            "product_price" => $product_price,
            "product_quantity" => $product_quantity,
            "user_id" => SecureSession::get("user_id")
        ));
    }





    //5. Remove Everything from Cart --> Delay until payment is recieved
    //unset($_SESSION['cart']);
    SecureSession::destroy("cart");
    SecureSession::destroy("total");


    //6. Inform User Whether Everything is fine or there is a problem
    // header('location: ../payment.php?order_status=order placed successfully');
    header("Content-Type: application/json");
    $server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : false;
    $code = 201;
    $text = "Created";

    if (substr(php_sapi_name(), 0, 3) == 'cgi') {
        header("Status: {$code} {$text}", true);
    } elseif ($server_protocol == 'HTTP/1.1' or $server_protocol == 'HTTP/1.0') {
        header($server_protocol . " {$code} {$text}", true, $code);
    } else {
        header("HTTP/1.1 {$code} {$text}", true, $code);
    }
    $msg = array(
        "order_status" => "Order Placed Successfully",
        "page" => "payment.php",
    );
    echo json_encode($msg);
    exit;
}
