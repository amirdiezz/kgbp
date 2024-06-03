<?php

include 'config.php';

session_start();

$order_id = $_GET['order_id'];

if(!isset($order_id)){
   header('location:orders.php');
}

$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id'") or die('query failed');

if(mysqli_num_rows($order_query) > 0){
   $order = mysqli_fetch_assoc($order_query);
} else {
   header('location:orders.php');
}

$subtotal_products = 0; // Initialize subtotal for products
$cart_total = 0; // Initialize cart total

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" type="x-icon" href="media/favicon.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Invoice | KGBP</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style4.css">

   <style>
   .invoice img {
      display: block;
      margin: 0 auto;
   }

   .invoice .order-details td {
      text-align: left;
   }

   .invoice .order-details tr{
    border: none;
   }

   .invoice .product-details {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      margin-bottom: 50px;
   }
   
   .invoice .product-details th,
   .invoice .product-details td {
      border-bottom: 1px solid #ddd;
      padding: 10px;
   }

   .invoice h3{
      display: flex;
      justify-content: flex-end;
      font-size:2rem;
   }

   .invoice h2 {
      display: flex;
      justify-content: flex-end;
      font-size: 2.5rem;
   }
</style>


</head>
<body>

<section class="invoice">
    <img height="50rem" src="media/biglogo.png">
   <h1 class="title">Order Invoice</h1>

   <div class="box-container">
      <div class="box">
         <table class="order-details">
            <tr>
               <td>
                  <p><strong><?php echo $order['name']; ?></strong></p>
                  <p><?php echo $order['number']; ?></p>
                  <p><?php echo $order['address']; ?></p><br>
                  <p><strong>Placed On:</strong> <?php echo $order['placed_on']; ?></p>
                  <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
               </td>
            </tr>
         </table>
       </div>
   </div><br>
    
    <div class="box-container">
      <div class="box">
         <table class="product-details">
            <thead>
               <tr>
                  <th>Product Name</th>
                  <th>Price Per Quantity</th>
                  <th>Quantity</th>
                  <th>Subtotal</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $products = explode(', ', $order['total_products']);
               foreach($products as $product){
                  if(trim($product) == '') continue;
                  preg_match('/(.+) \((\d+)\)/', $product, $matches);
                  $product_name = $matches[1];
                  $product_quantity = $matches[2];
                  
                  $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE name = '$product_name'") or die('query failed');
                  $product_data = mysqli_fetch_assoc($product_query);
                  $product_price = $product_data['price'];
                  $subtotal = $product_price * $product_quantity;
                  $subtotal_products += $subtotal; // Add subtotal to subtotal for products
                  $cart_total += $subtotal; // Add subtotal to cart total
               ?>
               <tr>
                  <td><?php echo $product_name; ?></td>
                  <td>RM <?php echo $product_price; ?></td>
                  <td><?php echo $product_quantity; ?></td>
                  <td>RM <?php echo $subtotal; ?></td>
               </tr>
               <?php
               }
               ?>
            </tbody>
         </table>
         <h3>Subtotal: RM <?php echo $subtotal_products; ?></h3>
         <h3>Shipping Fee : RM 10.00</h3>
         <h2>Total Price: RM <?php echo $cart_total + 10; ?></h2>
      </div>
   </div>

</section>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
