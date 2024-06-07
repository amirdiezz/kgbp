<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    $message[] = 'Payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
    exit;
}

$payment_filter = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel = "shortcut icon" type = "x-icon" href = "media/favicon.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders | KGBP Staff</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Placed Orders</h1>

   <section class="filter">
      <div class="filter-container">
         <form method="GET" action="">
            <label for="payment_status">Filter : </label>
            <select name="payment_status" id="payment_status" onchange="this.form.submit()">
               <option value="">All Status</option>
               <option value="Pending" <?php echo ($payment_filter == 'Pending') ? 'selected' : ''; ?>>Pending</option>
               <option value="Shipped" <?php echo ($payment_filter == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
            </select>
         </form>
      </div>
   </section>

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
            $filter_query = "SELECT * FROM `orders`";
            if ($payment_filter) {
                $filter_query .= " WHERE payment_status = '$payment_filter'";
            }
            $filter_query .= " ORDER BY id DESC"; // Sorting by id in descending order
            $select_orders = mysqli_query($conn, $filter_query) or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
            <tr>
               <td><?php echo $fetch_orders['placed_on']; ?></td>
               <td><?php echo $fetch_orders['id']; ?></td>
               <td><?php echo $fetch_orders['total_products']; ?></td>
               <td>RM <?php echo $fetch_orders['total_price']; ?></td>
               <td>
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                     <select name="update_payment">
                        <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                        <option value="Pending">Pending</option>
                        <option value="Shipped">Shipped</option>
                     </select>
                     <input type="submit" value="update" name="update_order" class="option-btn">
                     <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
                  </form>
               </td>
               <td><a href="invoice.php?order_id=<?php echo $fetch_orders['id']; ?>" class="option-btn" target="_blank">View</a></td>
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

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
