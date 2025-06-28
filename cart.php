<?php 
 session_start();
include 'connection.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    
    header('location:login.php');
    exit(); 
    
    $user_id = null; 
}
// $admin_id = $_SESSION['admin_name'];
$admin_id = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
 if(!isset($admin_id)){
 header('location:login.php');     
    }
 if(isset($_POST['logout'])){
        session_destroy();
        header('location:login.php');     
    }

    // update qty
    if(isset($_POST['update_qty_btn'])){
          $update_qty_id=$_POST['update_qty_id'];
          $update_value=$_POST['update_qty'];
          
          $update_query = mysqli_query($conn,"UPDATE `cart` SET quantity ='$update_value' WHERE id =' $update_qty_id' ") or ('query faild');
          if($update_query){
             header('location:cart.php');     
          }
    }
    // delete product from cart
    if(isset($_GET['delete'])){
        $delete_id =$_GET['delete'];
        
        mysqli_query($conn,"DELETE FROM `cart` WHERE id ='$delete_id'") or die('query faild');
        header('location:cart.php');
    }
    // delete property from cart
    if(isset($_GET['delete_all'])){
          mysqli_query($conn,"DELETE FROM `cart` WHERE user_id ='$user_id'") or die('query faild');
          $message[]='Removed successfully';
          header('location:cart.php');
    }
   ?> 

       
  
    <!DOCTYPE html>
    <html lang="en">
    <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
            <!-- Include Slick CSS -->
          <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/> -->
          <!-- box icon links -->
           <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
              <!----------bootstrap icon link--------->
          <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

          <link rel="stylesheet" type="text/css" href="main.css">
          <title>cart page</title>
    </head>
    <body>
         <?php  include 'header.php'; ?> 
       
       <section class="popular-brands show-products view_page" style="margin-top: 60px;">
          <h1 class="title">Property added in cart</h1>
         
                 <?php  if(isset($message)){
           foreach($message as $message){
               echo '<div class="message">
               
                    <span>'.$message.'</span>
                    <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                    
                   </div>';    
           }
     }
     ?>
         
               <div class="popular-brands-content box-container">
                <?php 
                   $grand_total = 0;
                 
                    $select_cart=mysqli_query($conn,"SELECT * FROM `cart`") or die('query faild');
                    if(mysqli_num_rows($select_cart)>0){
                        while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                                                
                    $price_str = $fetch_cart['price'];
                    $price_num = (float) preg_replace('/[^0-9.]/', '', $price_str);
                    $quantity = (int) $fetch_cart['quantity'];
                    $total_amt = $price_num * $quantity;
                    $grand_total += $total_amt;


                    ?> 
                <div class="card box">
                     <div class="icon">
                       <a href="cart.php?delete=<?php echo $fetch_cart['id'];?>" class="bx bxs-x" onclick="return confirm('Do you want to delete this product from your cart')">delete</a>
                        <button type="submit" name="add_to_cart"></button>       
                    </div>
                    
                    <img src="images/<?php echo $fetch_cart['image']; ?>">
               <div class="detail">
                    <div class="price" style="margin-left: 10px;"> Price :  <?php echo $fetch_cart['price'];  ?>Birr</div>
                    <div class="name"style="margin-left: 10px;"> Location :  <?php echo        $fetch_cart['name'];  ?></div>
               </div>
        </div>
                <div class="total-amt" style="margin-top:60px;text-align:center">
                    <p style="margin-bottom:30px">Total amount Payable : 
                 <span><?php echo number_format($grand_total, 2); ?> Birr</span></p>
                    <a href="checkout.php" style="text-align: center;" class=" btn $<?php echo ($grand_total)>1?'': 'disabled'?>">Proceed to checkout </a><br><br>
                         
                        </div>
                        
                 
                </div> 
               
                <?php 
                    
                         }     
                        }else{
                           echo ' <p class="empty"> no property added yet!</p>';
                        }
                    
                ?>   
              
              <div class="wishlist_total" style="text-align: center;">
                   
                    
               </div>
      </section>   
    
         <?php  include 'footer.php'; ?>
         <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
         <script type="text/javascript" src="script.js"></script>
    </body>
    </html>