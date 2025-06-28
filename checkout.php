<?php 
session_start();
include 'connection.php';
$message =[];
// Redirect if not logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    
    header('location:login.php');
    exit(); 
    
    $user_id = null; 
}
$user_id = $_SESSION['user_id'];
$admin_id = $_SESSION['user_name'] ?? null;
if (!$admin_id) {
    header('location:login.php');
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}

// Process order
$message = [];
if (isset($_POST['order-btn'])) {
    // Validate and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $number = mysqli_real_escape_string($conn, $_POST['number'] ?? '');
    $method = mysqli_real_escape_string($conn, $_POST['method'] ?? '');
    
    // Address fields with proper checks
    $flat = mysqli_real_escape_string($conn, $_POST['flate'] ?? '');
    $street = mysqli_real_escape_string($conn, $_POST['street'] ?? '');
    $city = mysqli_real_escape_string($conn, $_POST['city'] ?? '');
    $state = mysqli_real_escape_string($conn, $_POST['state'] ?? '');
    $country = mysqli_real_escape_string($conn, $_POST['country'] ?? '');
    $pin_code = mysqli_real_escape_string($conn, $_POST['pin_code'] ?? '');
    
    $address = "flat no. $flat, $street, $city, $state, $country - $pin_code";
    $placed_on = date('d-M-Y');

    // Calculate cart total
    $cart_total = 0;
    $cart_products = [];
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $sub_total = $cart_item['price'] * $cart_item['quantity'];
             $cart_total += $sub_total;
             
           }
    }
    $total_products = implode(', ', $cart_products);

    // Insert order
    mysqli_query($conn, "INSERT INTO `order` (`user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`) 
        VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')");
                  
          // Clear cart
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
    
          
          $_SESSION['message'] = ['Thank you for your payment!
A confirmation email with your transaction details will be sent shortly. You’ll receive another notification once your payment is securely processed, along with updates on the next steps in your property transaction.'];
          
           

   
}

// Handle contact message
if (isset($_POST['submit-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $number = mysqli_real_escape_string($conn, $_POST['number'] ?? '');
    $msg = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

    // Check for existing message
    $select_message = mysqli_query($conn, "SELECT * FROM `message` 
        WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'");
        
    if (mysqli_num_rows($select_message) === 0) {
        mysqli_query($conn, "INSERT INTO `message` (`user_id`, `name`, `email`, `number`, `message`) 
            VALUES ('$user_id', '$name', '$email', '$number', '$msg')");
    }
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
          <link rel="stylesheet" type="text/css" href="main.css">
          <title>checkout page</title>
    </head>
    <body>
         <?php  include 'header.php'; ?> 
   
         

        <div class="checkout-form">
          <h1 class="title">Payment Process</h1>
      
     <div class="display-order">
          <div class="box-container">
          <?php
          $select_cart=mysqli_query($conn,"SELECT *FROM `cart` WHERE user_id='$user_id'") or die('query faild');
          $total=0;
          $grand_total=0;
         
          if(mysqli_num_rows($select_cart)>0){
             while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                  $price = (float) preg_replace('/[^0-9.]/', '', $fetch_cart['price']);
                   $total_price = $price * $fetch_cart['quantity'];
                   $grand_total += $total_price;
                   ?>
                <div class="box">
                    <img src="images/<?php echo $fetch_cart['image'];?>" alt="">
                    <span><?= $fetch_cart['name'];?>(<?= $fetch_cart['quantity'];?>)</span>
               </div>     
         
          <?php 
                       }       
                }
          ?>
           </div>
           <!-- <span class="grand-total">Total Amount Payable:<?= $grand_total;?></span> -->
           <span class="grand-total">Total Amount Payable: <?= number_format($grand_total, 2) ?> Birr</span>

     </div>
           
           <form method="post">
                                <?php
            if(isset($_SESSION['message'])){
    foreach($_SESSION['message'] as $msg){
        echo '<div class="message">
            <span>'.$msg.'</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
        </div>';    
       }
           unset($_SESSION['message']); // Clear the message after display
      }
             
         ?>
  
                <div class="input-field">
                    <input type="text" placeholder="Enter your name" name="name" required>
                </div> 
                 <div class="input-field">
                    <input type="number" placeholder="Enter your number" name="number" required>
                  </div>
                  <div class="input-field">
                    <input type="email" placeholder="Enter your email" name="email" required>
                  </div>  
                   <div class="input-field">
                    <label> Select Payment Method</label>
                    <select name="method" required>
                           <option selected disabled>Select Payment method</option>
                           <option value="Telebirr">Telebirr</option>
                           <option value="Mobile Banking">Mobile Banking</option>
                           <option value="visa card">Visa card</option>         
                    </select>
                  </div> 
                  
                 <div class="input-field">
                    <label> Adderss </label>
                    <input type="text" placeholder="" name="address" required>
                  </div>
                  
                   <div class="input-field">
                    <label>Account Number </label>
                    <input type="text" placeholder="" name="pin code" required>
                  </div> 
                  <input type="submit" name="order-btn" class="btn" value="pay now">           
           </form>
        </div>

          
         <?php  include 'footer.php'; ?>
          <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> 
           <script>
        const messages = document.querySelectorAll('.message');
        if (messages.length > 0 && messages[messages.length - 1].textContent.includes('Payment successfully')) {
            
            setTimeout(function() {
                window.location.href = 'checkout.php';
            },4000); 
        }
    </script> 
         <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
         <script type="text/javascript" src="script.js"></script>
    </body>
    </html>