<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_number = $_POST['update_number'];
   $update_address = mysqli_real_escape_string($conn, $_POST['update_address']);

   $update_query = "UPDATE `users` SET name = '$update_name', number = '$update_number', address = '$update_address' WHERE id = '$user_id'";
   
   if(mysqli_query($conn, $update_query)){
      $message[] = 'Profile updated successfully!';
   } else {
      $message[] = 'Profile update failed!';
   }
}

$select_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select_profile) > 0) {
    $fetch_profile = mysqli_fetch_assoc($select_profile);
    $user_name = $fetch_profile['name']; // Fetch the user's name
} else {
    $user_name = "User"; // Default value in case user not found
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" type="x-icon" href="media/favicon.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile | KGBP</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style4.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>My Profile</h3>
   <p>Welcome back, <?php echo htmlspecialchars($user_name); ?>!</p>
   <p>Ready to explore more?</p>
</div>

<section class="edit-profile">

   <h1 class="title">Profile Details</h1>
   <div class="box-container">
   <?php
      $select_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_profile) > 0){
         $fetch_profile = mysqli_fetch_assoc($select_profile);
      }
   ?>
    <div class="box">
        <form action="" method="post">
            <p>Name</p>
            <input type="text" name="update_name" class="box" placeholder="Enter your name" value="<?php echo $fetch_profile['name']; ?>" required><br>
            <p>Email</p>
            <input type="email" name="update_email" class="box" placeholder="Enter your email" value="<?php echo $fetch_profile['email']; ?>" readonly><br>
            <p>Phone Number</p>
            <input type="text" name="update_number" class="box" placeholder="Enter your number" value="<?php echo $fetch_profile['number']; ?>" required><br>
            <p>Address</p>
            <input type="text" name="update_address" class="box" placeholder="Enter your address" value="<?php echo $fetch_profile['address']; ?>"><br>
            <input type="submit" value="Update Profile" name="update_profile" class="btn">
        </form>
    </div>
    </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
