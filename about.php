<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel = "shortcut icon" type = "x-icon" href = "media/favicon.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Clubhouse | KGBP</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style4.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>The Clubhouse</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="media/about.jpg" alt="">
      </div>

      <div class="content">
         <h3>Who are we?</h3>
         <p>Kelab Golf Batu Pahat is a 9-hole golf course located in the Batu Pahat district in Johor. It is founded in 1952 and is considered as one of the best 9-hole golf course in Johor. The golf club provides several facilities that can be enjoyed by the club members and guests. It includes facilities such as putting green, club rental on the driving range, buggy services on the course, 10 driving range bays and a pro shop that sells golf equipment such as gloves, golf sets and golf apparels suitable for every golf enthusiast, from beginners to professionals.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Client's Reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="media/aiman.jpg" alt="">
         <p>"Absolutely thrilled with my new set of golf clubs from Kelab Golf Batu Pahat! I purchased the P770 Phantom Black Irons set for RM6999.99. The staff were incredibly knowledgeable and helped me find the perfect fit. The clubs are well-made and have significantly improved my game. Highly recommend!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Aiman Latiff</h3>
      </div>

      <div class="box">
         <img src="media/amir.jpg" alt="">
         <p>"Just got back from Kelab Golf Batu Pahat with a new golf bag, and I couldn't be happier! The selection was fantastic, and the staff were friendly and helpful throughout the process. The bag is stylish, durable, and has plenty of pockets for all my gear. Will definitely be returning for future purchases!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Amir Daniel</h3>
      </div>

      <div class="box">
         <img src="media/zaliff.jpg" alt="">
         <p>"Recently purchased a new golf glove from Kelab Golf Batu Pahat, and I'm thoroughly impressed. The quality is top-notch, and it provides excellent grip and comfort during my swings. The staff provided great customer service, making the shopping experience a breeze. Looking forward to shopping here again!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Zaliff Usri</h3>
      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>