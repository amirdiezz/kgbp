<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">
         <a href="admin_page.php" class="logo">
         <img src="media/adminlogo.png">
         </a>

      <nav class="navbar">
         <a href="admin_products.php">Products</a>
         <a href="admin_orders.php">Orders</a>
         <a href="admin_contacts.php">Feedbacks</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>Name : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn" onclick="return confirm('Are you sure you want to log out of KGBP?');">Logout</a>
      </div>

   </div>

</header>