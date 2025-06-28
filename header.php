<?php include 'connection.php';   ?>



<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <!-- box icon links -->
            <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
           <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
           <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
           <link rel="stylesheet" type="text/css" href="main.css">
          <title>header page</title>
</head>
<body>
     <header class="header" >
          <div class="flex">
             <a href="admin_pannel.php" class="logo"> <img src="images/logo1.jpg" alt="logo" width="160px" height="100px"></a>   
             <nav class="navbar">
                <a href="index.php">Home</a>
                 <a href="buy.php">Buy</a> 
                <a href="about.php">about us</a>
                <a href="contact.php">contact</a>   
           </nav>
           <div class="icons">
                <i class='bx bxs-user ' id="user-btn"> </i>
                <!-- <a href="wishlist.php"> <i class='bx bxs-heart ' id="user-btn"> </i></a> -->
                <?php   
                 $select_cart = mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id ='$user_id'") or die ('query faild');
                 $cart_num_rows = mysqli_num_rows($select_cart);
                 ?>
                <!-- <a href="cart.php"> <i class="fa-solid fa-house" id="user-btn"> </i><sup><?php echo $cart_num_rows; ?></sup> </a> -->
                <i class="fa-solid fa-bars" id="menu-btn" ></i>
            </div> 
          <div class="user-box">

              <p>Username: <span> <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?></span></p>
                <p>Email: <span> <?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?></span></p>

              
              <!-- <p>Username: <span> </span></p> 
              <p>Email: <span> </span></p> -->
              <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log out</button>
              </form>           
          </div>   

       </div>

     </header> 
       
       <div class="lin"></div>  
       <script type="text/javascript" src="script2.js"></script>
</body>
</html>