<?php 
session_start();
 include 'connection.php';
   error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $admin_id = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : null;
    // $admin_id=$_SESSION['admin_name'];
if(!isset($admin_id)){
    header('location:login.php');     
    }
    if(isset($_POST['logout'])){
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
          <title>admin pannel</title>
</head>
<body>
 <!-- admin_header.php -->
 <header class="header" >
          <div class="flex">
             <a href="admin_pannel.php" class="logo"> <img src="images/logo1.jpg" alt="logo" width="160px" height="100px"></a>   
             <nav class="navbar">
                <a href="admin_pannel.php">Home</a> 
                <a href="admin_product.php">Add Property</a>
                <a href="admin_order.php">Requests</a>
                <a href="admin_user.php">Users</a>
                <a href="admin_message.php">Messages</a> 
                <a href="add_admin.php">Add Admin</a>   
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
<!-- admin_header.php -->
    
    <div class="line4"></div>
    <section class="dashboard">
        <div class="box-container">
            <div class="box">
                <?php 
                $total_pendings = 0;
                $select_pendings = mysqli_query($conn,"SELECT * FROM `order` WHERE payment_status= 'pending'") or die('query failed');
                while($fetch_pending = mysqli_fetch_assoc($select_pendings)){
            //    $total_pendings += $fetch_pending['total_price'];
                $total_pendings = mysqli_num_rows($select_pendings);

                }
                ?>
                <h4><?php echo $total_pendings; ?></h4>
                <p>Total Listings Awaiting Approval</p>
            </div>

             <div class="box">
                <?php 
                $total_completes = 0;
                $select_completes = mysqli_query($conn,"SELECT * FROM `order` WHERE payment_status= 'complete'") or die('query failed');
                while($fetch_completes = mysqli_fetch_assoc($select_completes)){
            //    $total_completes += $fetch_completes['total_price'] ;
               $total_completes = mysqli_num_rows($select_completes);

                }
                ?>
                <h4><?php echo $total_completes; ?></h4>
                <p>Total Approved Listings</p>
            </div>

              <div class="box">
                <?php 
               
                $select_orders = mysqli_query($conn,"SELECT * FROM `order` ") or die('query failed');
                $num_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h4><?php echo $num_of_orders; ?></h4>
                <p> Total Property Requests</p>
            </div>

            <div class="box">
                <?php 
               
                $select_products = mysqli_query($conn,"SELECT * FROM `products` ") or die('query failed');
                $num_of_products=mysqli_num_rows($select_products);
                ?>
                <h4><?php echo $num_of_products; ?></h4>
                <p>Total Property Listed</p>
            </div>


               <div class="box">
                <?php 
               
                $select_users = mysqli_query($conn,"SELECT * FROM `users` WHERE user_type='user'") or die('query failed');
                $num_of_users=mysqli_num_rows($select_users);
                ?>
                <h4><?php echo $num_of_users; ?></h4>
                <p>total Vistors </p>
            </div>

               <div class="box">
                <?php 
               
                $select_admin = mysqli_query($conn,"SELECT * FROM `users` WHERE user_type='admin'") or die('query failed');
                $num_of_admin = mysqli_num_rows($select_admin);
                ?>
                <h4><?php echo $num_of_admin; ?></h4>
                <p>total admin</p>
            </div>
             <div class="box">
                <?php 
               
                $select_users = mysqli_query($conn,"SELECT * FROM `users`") or die('query failed');
                $num_of_users=mysqli_num_rows($select_users);
                ?>
                <h4><?php echo $num_of_users; ?></h4>
                <p>total registered users</p>
            </div>

             <div class="box">
                <?php 
               
                $select_message = mysqli_query($conn,"SELECT * FROM `message`") or die('query failed');
                $num_of_message=mysqli_num_rows($select_message);
                ?>
                <h4><?php echo $num_of_message; ?></h4>
                <p>new message</p>
            </div>
         </div>

         
           
        
    </section>
    <script type="text/javascript" src="script.js"></script>     
</body>
</html>