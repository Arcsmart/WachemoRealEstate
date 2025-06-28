<?php 
session_start();
$admin_id = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : null;
if (!isset($admin_id)) {
header('location:login.php');
}
if (isset($_POST['logout'])) {
session_destroy();
header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <!-- box icon links -->
            <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
           <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
           <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
           <link rel="stylesheet" type="text/css" href="style.css">
          <title>Document</title>
</head>
<body>
     <header class="header" >
          <div class="flex">
             <a href="admin_pannel.php" class="logo"> <img src="images/logo1.jpg" alt="logo" width="160px" height="100px"></a>   
             <nav class="navbar">
                <a href="admin_pannel.php">Home</a> 
                <a href="admin_product.php">Products</a>
                <a href="admin_order.php">Orders</a>
                <a href="admin_user.php">Users</a>
                <a href="admin_message.php">Messages</a>   
           </nav>
           <div class="icons">
                <i class='bx bxs-user ' id="user-btn"> </i>
                <i class="fa-solid fa-bars" id="menu-btn" ></i>
            </div> 
          <div class="user-box">

              <p>Username: <span> <?php echo isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : ''; ?></span></p>
                <p>Email: <span> <?php echo isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : ''; ?></span></p>

              
              <!-- <p>Username: <span> </span></p> 
              <p>Email: <span> </span></p> -->
              <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log out</button>
              </form>           
          </div>   

       </div>

     </header> 
       <div class="banner">
          <div class="detail">
                    <h1 style="color: #fff;" >Admin Dashdoard</h1>
                     <div  class="centered-container">
                        <p>We believe your home should be a reflection of your best life. 
                         </p>
                     </div>
                    
          </div>
       </div>
       <div class="lin"></div>  
       <script type="text/javascript" src="script.js"></script>
</body>
</html>