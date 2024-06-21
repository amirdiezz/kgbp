<?php

session_start();
include 'config.php';

// Check if order details are present in the session
if (!isset($_SESSION['order_details'])) {
    die('Order details not found.'); // Or redirect to an error page
}

$order_details = $_SESSION['order_details'];

// Extract order details
$user_id = $order_details['user_id'];
$name = $order_details['name'];
$number = $order_details['number'];
$email = $order_details['email'];
$method = $order_details['method'];
$address = $order_details['address'];
$total_products = $order_details['total_products'];
$grand_total = $order_details['grand_total'];
$placed_on = $order_details['placed_on'];

// Save order details to the database
$insert_order_query = "INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$grand_total', '$placed_on')";
if (!mysqli_query($conn, $insert_order_query)) {
    die('Failed to save order: ' . mysqli_error($conn)); // Or redirect to an error page
}

// Update product stocks in the `products` table
$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
while ($cart_item = mysqli_fetch_assoc($cart_query)) {
    $product_name = $cart_item['name'];
    $product_quantity = $cart_item['quantity'];
    $update_stock_query = "UPDATE `products` SET stocks = stocks - $product_quantity WHERE name = '$product_name'";
    if (!mysqli_query($conn, $update_stock_query)) {
        die('Failed to update product stocks: ' . mysqli_error($conn)); // Or redirect to an error page
    }
}

// Clear the cart after order is placed
$clear_cart_query = "DELETE FROM `cart` WHERE user_id = '$user_id'";
if (!mysqli_query($conn, $clear_cart_query)) {
    die('Failed to clear cart: ' . mysqli_error($conn)); // Or redirect to an error page
}

// Clear order details from the session
unset($_SESSION['order_details']);

// Set success message in session
$_SESSION['success_message'] = 'Order placed successfully!';

// Redirect to the cart page
header('Location: success.php');
exit();

?>
