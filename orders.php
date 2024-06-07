<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="media/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | KGBP</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style4.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
    <h3>Your Orders</h3>
</div>

<section class="placed-orders">

    <h1 class="title">Placed Orders</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Placed On</th>
                    <th>Order ID</th>
                    <th>Total Products</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY `id` DESC") or die('query failed');
                if (mysqli_num_rows($order_query) > 0) {
                    while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
                ?>
                <tr>
                    <td><?php echo $fetch_orders['placed_on']; ?></td>
                    <td><?php echo $fetch_orders['id']; ?></td>
                    <td><?php echo $fetch_orders['total_products']; ?></td>
                    <td>RM <?php echo $fetch_orders['total_price']; ?></td>
                    <td style="color:<?php echo ($fetch_orders['payment_status'] == 'Pending') ? 'red' : 'green'; ?>;">
                        <?php echo $fetch_orders['payment_status']; ?>
                    </td>
                    <td><a href="invoice.php?order_id=<?php echo $fetch_orders['id']; ?>" class="option-btn" target="_blank">View Invoice</a></td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="empty">No orders placed yet!</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
