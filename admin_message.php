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
   
  // Delete property from database
if(isset($_GET['delete'])){
     $delete_id = $_GET['delete'];    
  
    mysqli_query($conn,"DELETE FROM `message` WHERE id ='$delete_id'") or die('query faild'); 
      header('location:admin_message.php');    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
          <!-- box icon links -->
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
    <div class="line1"></div>
    
             
   <div style="text-align: center;margin: left 5px;">
               <?php  if(isset($message)){
           foreach($message as $message){
               echo '<div class="message">
               
                    <span>'.$message.'</span>
                    <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                    
                   </div>';    
           }
     }
     ?>
     </div>

        
    <div class="lin3"></div>
    <section class="message-container" style="background-color: #f5f5f5;">
          <h1 class="title">Unread message</h1>
          <div class="box-container">
                <?php 
                $select_message=mysqli_query($conn,"SELECT * FROM `message`") or die('query failed');
                if(mysqli_num_rows($select_message)>0){
                    while($fetch_message=mysqli_fetch_assoc($select_message)){

                   ?> 
                <div class="box">
                    <p>User id: <span><?php echo $fetch_message['id'] ;?></span></p>
                     <p >Name: <span><?php echo $fetch_message['name'] ;?></span></p>
                      <p>Email: <span><?php echo $fetch_message['email'] ;?></span></p>
                      <p>Message:<?php echo $fetch_message['message'] ;?></p>
                      <a href="admin_message.php?delete=<?php echo $fetch_message['id'] ;?>" onclick="return confirm('You want delete this message')" class="delete_me" style="margin-top: 10px;">Delete</a>
                </div>  
                <?php 
                       }
                }else{
                         echo'<div class="empty">
                    <p>No product added yet!</p>
                    </div>';
                       }
                ?> 
          </div>
    </section>
   <script type="text/javascript" src="script.js"></script>     
</body>
</html>