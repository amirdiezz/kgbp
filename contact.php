<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'Message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message[] = 'Message sent successfully!';
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
   <link rel = "shortcut icon" type = "x-icon" href = "media/favicon.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us | KGBP</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style4.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Contact Us</h3>
   <p>Any questions, <?php echo htmlspecialchars($user_name); ?>?</p>
   <p>Share your thoughts with us!</p>
</div>

<section class="contact">
   <form action="" method="post">
      <h3>Share your Experience!</h3>
      <input type="text" name="name" required placeholder="Enter your name" class="box">
      <input type="email" name="email" required placeholder="Enter your email" class="box">
      <input type="number" name="number" required placeholder="Enter your phone number" class="box">
      <textarea name="message" class="box" placeholder="Enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Send Message" name="send" class="btn">
   </form>

</section>



<section class="map">

   <div class="flex">

      <div class="image">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.724853028901!2d102.94617807581523!3d1.8561503597375577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d05729504df3a1%3A0xff639913fd2447a7!2sBatu%20Pahat%20Golf%20Club!5e0!3m2!1sen!2smy!4v1716431834384!5m2!1sen!2smy" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <div class="content">
         <h3>KELAB GOLF BATU PAHAT</h3>
         <p>678, Jalan Dato Mohd. Shah,</p>
         <p>Taman Koperasi</p>
         <p>83000 Batu Pahat, Johor Darul Takzim,</p>
         <p>Malaysia.</p><br>
         <p>Phone Number : +607-432 9221</p>
         <p>Email : customerservice@kgbp.com</p><br>
         <p>Business Hours :</p>
         <p>Monday - Sunday | 7.00 A.M. - 6.00 P.M.</p>
      </div>

   </div>

</section>






<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>