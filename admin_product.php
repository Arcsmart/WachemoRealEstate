<?php 
session_start();
 include 'connection.php';
 $message[]='';
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
   
    // adding proprety to database
   if(isset($_POST['add_product'])){
     $product_name=mysqli_real_escape_string($conn,$_POST['name']);
     $product_price=mysqli_real_escape_string($conn,$_POST['price']);
     $product_detail=mysqli_real_escape_string($conn,$_POST['detail']);
     $image = $_FILES['image']['name'];
     $image_size = $_FILES['image']['size'];
     $image_tmp_name = $_FILES['image']['tmp_name'];
     $image_folder ='images/' .$image;
     $select_product_name = mysqli_query($conn, "SELECT name, image FROM `products` WHERE 
     name ='$product_name'") or die('query failed');

    if (mysqli_num_rows($select_product_name)>20000000) {
        $fetch_product = mysqli_fetch_assoc($select_product_name);
        if(!empty($fetch_product['image'])) {
            $message[] = 'Property already exists';
        } else {
            // Image validation and upload
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } elseif (empty($image)) {
                $message[] = 'Please select an image.';
            } else {
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    $inseert_product = mysqli_query($conn, "INSERT INTO `products`(`name`,`price`,`product_detail`,`image`) VALUES('$product_name','$product_price','$product_detail','$image')") or die('query failed');

                    if ($inseert_product) {
                        $message[] = 'Property added successfully';
                        // header('location:admin_product.php');
                    } else {
                        $message[] = 'Failed to add property to database.';
                    }
                } else {
                    $message[] = 'Failed to upload image.';
                }
            }
        }
    } else {
        // Image validation and upload
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } elseif (empty($image)) {
            $message[] = 'Please select an image.';
        } else {
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $inseert_product = mysqli_query($conn, "INSERT INTO `products`(`name`,`price`,`product_detail`,`image`) VALUES('$product_name','$product_price','$product_detail','$image')") or die('query failed');

                if ($inseert_product) {
                    $message[] = 'Property added successfully';

                    // header('location:admin_product.php');
                } else {
                    $message[] = 'Failed to add property to database.';
                }
            } else {
                $message[] = 'Failed to upload image.';
            }
        }
    }
}


// Delete property from database
if(isset($_GET['delete'])){
     $delete_id = $_GET['delete'];    
    $select_delete_image=mysqli_query($conn,"SELECT image FROM `products` WHERE id ='$delete_id'") or die('query faild');
    $fetch_delete_image=mysqli_fetch_assoc($select_delete_image);
    unlink('images/'.$fetch_delete_image['image']);
    mysqli_query($conn,"DELETE FROM `products` WHERE id ='$delete_id'") or die('query faild'); 
    mysqli_query($conn,"DELETE FROM `cart` WHERE pid ='$delete_id'") or die('query faild'); 
    mysqli_query($conn,"DELETE FROM `wishlist` WHERE pid ='$delete_id'") or die('query faild'); 
      header('location:admin_product.php');    
}
// update products

if(isset($_POST['update_product'])){
    $update_id=$_POST['update_id'];
    $update_name=$_POST['update_name'];
    $update_price=$_POST['update_price'];
    $update_detail=$_POST['update_detail'];
    $update_image=$_FILES['update_image']['name'];
    $update_image_tmp_name=$_FILES['update_image']['tmp_name'];
    $update_image_folder='images/'.$update_image;

   
    if (!empty($update_image)) {
        
        if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
            
            $update_query = mysqli_query($conn, "UPDATE `products` SET `name`='$update_name', `price`='$update_price', `product_detail`='$update_detail', `image`='$update_image' WHERE id='$update_id'") or die('query failed');
        } else {
            
            $message[] = 'Failed to upload new image.';
        }
    } else {
        
        $update_query = mysqli_query($conn, "UPDATE `products` SET `name`='$update_name', `price`='$update_price', `product_detail`='$update_detail' WHERE id='$update_id'") or die('query failed');
         $message[]='updated successfully !';
    }
    
      header('location:admin_product.php');    
      
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
    <section class="add-products form-container">
             
   <div style="text-align: center;margin: left 5px;">
               <?php  if(isset($message)){
           foreach($message as $message){
               echo '<div class="message">
               
                    <span>'.$message.'</span>
                    
                    
                   </div>';    
           }
     }
     ?>
     </div>

        
    
          <form action="" method="post" enctype="multipart/form-data">
              <div class="input-field">
                 <label >Property location</label>
                 <input type="text" name="name" required>
              </div>
              <div class="input-field">
                  <label>Proprety price </label>
                  <input type="number" name="price" required>  
              </div>
               <div class="input-field">
                <label>Proprety detail </label>
                <textarea name="detail" required></textarea> 
              </div> 
               <div class="input-field">
                  <label>Proprety image </label>
                  <input type="file" name="image" accept="image/jpg, image/jpeg,image/png,image/webp" required>  
              </div>
              <input type="submit" name="add_product" value="add property" class="btn">                 

          </form>
    </section>
    <div class="lin3"></div>
   <section class="show-products">
    <div class="box-container">
        <?php 
        $select_products=mysqli_query($conn, "SELECT * FROM `products`") or die('query faild');
        if(mysqli_num_rows($select_products)>0){
            while($fetch_products=mysqli_fetch_assoc($select_products)){
        ?>
        <div class="box">
            <img src="images/<?php echo $fetch_products['image'];?> ">
            <p><i class="fa-solid fa-location-dot"></i>:<?php echo $fetch_products['name'];?></p>
            <p>Price:<?php echo $fetch_products['price'];?>Birr</p>
            <details><?php echo $fetch_products['product_detail'];?></details>
            <a href="admin_product.php?edit=<?php echo $fetch_products['id'];?>" class="edit">edit</a>
             <a href="admin_product.php?delete=<?php echo $fetch_products['id'];?>" class="delete" onclick="return confirm('You want to delete')">delete</a>
             
        </div>
        <?php

    }
        } else{
            echo '<div class="empty">
                <p>No property added yet!</p>
             </div>';

        }
        ?>
    </div>
   </section>
    
    <section class="update-container">
        <?php
        if(isset($_GET['edit'])){
          $edit_id = $_GET['edit'];
          $edit_query=mysqli_query($conn,"SELECT * FROM `products` WHERE id='$edit_id'") or die('query faild');
          if(mysqli_num_rows($edit_query)>0){
            while($fetch_edit=mysqli_fetch_assoc($edit_query)){

            ?>
            <form method="post" enctype="multipart/form-data">
                <img src="images/<?php echo $fetch_edit['image'] ;?>">
                <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id'];?>">
                <input type="text" name="update_name" value="<?php echo $fetch_edit['name'];?>">
                <input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price'];?>">
                <textarea name="update_detail"><?php echo $fetch_edit['product_detail'];?></textarea>
                <input type="file" name="update_image" accept="image/jpg,image/jpeg,image/png,image/webp">
                <input type="submit" name="update_product" value="update" class="edit btn">
                <input type="reset" name="" value="cancel" class="option-btn btn" id="close-form">

            </form>
            <?php 
            }
          }
          echo "<script>document.querySelector('.update-container').style.display='block'</script>";
           
        }
       ?>
    </section>
  <script>
        const messages = document.querySelectorAll('.message');
        if (messages.length > 0 && messages[messages.length - 1].textContent.includes('Property added successfully')) {
            
            setTimeout(function() {
                window.location.href = 'admin_product.php';
            }, 1500); 
        }
    </script>      
   
    <script type="text/javascript" src="script.js"></script>     
</body>
</html>