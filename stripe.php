<?php

require __DIR__ . "/vendor/autoload.php";

session_start();
include 'config.php';

// Retrieve order details from session
$order_details = $_SESSION['order_details'];

$stripe_secret_key = "sk_test_51PU2zy2M6CAoBjlQwVhS0Q83qgE0uwAllWEmZoMcH9hN5zAfTm6NyX6wHESrvg0OIsjp4q2RI8tMukE9iQIMsmYU00iO3eCrso";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/KGBP/stripe_success.php",
    "cancel_url" => "http://localhost/KGBP/checkout.php",
    "line_items" => [[
        "quantity" => 1,
        "price_data" => [
            "currency" => "myr",
            "unit_amount" => $order_details['grand_total'] * 100, // amount in cents
            "product_data" => [
                "name" => $order_details['total_products']
            ]
        ]
    ]]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
