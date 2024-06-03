<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Product already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="media/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | KGBP</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style4.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>PRODUCTS</h3>
    </div>

    <section class="filter">
        <div class="filter-container">
            <form method="GET" action="">
               <label for="category">Filter by Category:</label>
               <select name="category" id="category" onchange="this.form.submit()">
               <option value="">All Categories</option>
                  <?php
                    // Fetch categories from the database
                    $categoryQuery = "SELECT DISTINCT category FROM products";
                    $categoryResult = mysqli_query($conn, $categoryQuery);

                    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                            $selected = (isset($_GET['category']) && $_GET['category'] == $categoryRow['category']) ? 'selected' : '';
                            echo '<option value="' . $categoryRow['category'] . '" ' . $selected . '>' . $categoryRow['category'] . '</option>';
                        }
                    }
                  ?>
               </select>
            </form>
        </div>


    <section class="products">

        <h1 class="title">Latest Products</h1>

        <div class="box-container">
            <?php
            $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
            $select_products = "SELECT * FROM products";
            if ($category) {
                $select_products .= " WHERE category = '$category'";
            }
            $result = mysqli_query($conn, $select_products) or die('query failed');
            if (mysqli_num_rows($result) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($result)) {
            ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                        <div class="price">RM <?php echo $fetch_products['price']; ?></div>
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
