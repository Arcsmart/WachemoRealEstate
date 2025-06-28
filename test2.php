<?php

session_start();

include 'connection.php';

error_reporting(E_ALL);

ini_set('display_errors', 1);

$admin_id = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : null;



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



  mysqli_query($conn,"DELETE FROM `order` WHERE id ='$delete_id'") or die('query faild');

  $message[]='User removed successfully';

  header('location:admin_order.php');

}

// Email functionality



function sendOrderCompletionEmail($userEmail, $orderId) {
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dawitalex560@gmail.com'; // Your Gmail
        $mail->Password   = 'bdjg ivzg nxsl mqpx';     // App Password
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('dawitalex560@gmail.com', 'Admin');
        $mail->addAddress($userEmail);

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Your Order is Complete!';
        $mail->Body    = "Dear customer,\n\nYour order with ID: $orderId has been completed.\n\nThank you!";

        $mail->send();
        error_log("Email sent to $userEmail");
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error:". $e->getMessage());
        return false;
    }
}

// updating payment status

if(isset($_POST['update_order'])){

 $order_id=$_POST['order_id'];

 $update_payment=$_POST['update_payment'];



 // Fetch the order details before updating

 $select_order_details = mysqli_query($conn, "SELECT email FROM `order` WHERE id = '$order_id'") or die('query failed');

 $order_data = mysqli_fetch_assoc($select_order_details);

 $user_email = $order_data['email'];



 mysqli_query($conn,"UPDATE `order` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query faild');

 $message[]='Payment status updated!';



 // Send email notification if the status is updated to 'complete'

 //bdjg ivzg nxsl mqpx

 if ($update_payment === 'complete' && $user_email) {

   if (sendOrderCompletionEmail($user_email, $order_id)) {

     $message[] = 'Notification email sent to user.';

   } else {

     $message[] ='Failed to send email: ';


   }

 }

}

// --- START: Improved Search Functionality ---

$search_query_display = ""; // For displaying in the input field

$sql_conditions = "";

$search_active = false; // Flag to know if a search is active



if (isset($_GET['search_term']) && !empty(trim($_GET['search_term']))) {

  $search_term_raw = trim($_GET['search_term']);

  $search_query_display = $search_term_raw; // Keep raw input for display

  $search_term_escaped = mysqli_real_escape_string($conn, $search_term_raw);

  $search_active = true;



  // Explode the search term by spaces to search in multiple fields

  $search_parts = explode(' ', $search_term_escaped);

  $conditions = [];



  foreach ($search_parts as $part) {

    $part = trim($part);

    if (!empty($part)) {

      // Check for price range (e.g., 1000-2000)

      if (preg_match('/^(\d+)-(\d+)$/', $part, $matches)) {

        $min_price = intval($matches[1]);

        $max_price = intval($matches[2]);

        $conditions[] = "(total_price >= $min_price AND total_price <= $max_price)";

      } else {

        // Search in 'name', 'email' columns (case-insensitive)

        $conditions[] = "(LOWER(name) LIKE LOWER('%$part%') OR LOWER(email) LIKE LOWER('%$part%') OR LOWER(address) LIKE LOWER('%$part%'))";

      }

    }

  }



  if (!empty($conditions)) {

    $sql_conditions = " WHERE " . implode(' OR ', $conditions);

  }

}



// Fetch orders based on search conditions or all orders

$select_orders_query = "SELECT * FROM `order`" . $sql_conditions;

$select_orders = mysqli_query($conn, $select_orders_query) or die('query failed');

// --- END: Improved Search Functionality ---

?>

<!DOCTYPE html>

<html lang="en">

<head>

     <meta charset="UTF-8">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">

     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

     <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>

     <link rel="stylesheet" type="text/css" href="style.css">

     <title>admin pannel</title>

</head>

<body>

  <header class="header" >

   <div class="flex">

    <a href="admin_pannel.php" class="logo"> <img src="images/logo1.jpg" alt="logo" width="160px" height="100px"></a>

    <nav class="navbar">

     <a href="admin_pannel.php">Home</a>

     <a href="admin_product.php">Add Property</a>

     <a href="admin_order.php">Requests</a>

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





    <form method="post">

       <button type="submit" name="logout" class="logout-btn">Log out</button>

    </form>

  </div>



 </div>



 </header>

  <div class="banner">

  <div class="detail">

     <h1 style="color: #fff;" >Admin Dashdoard</h1>

     <div class="centered-container">

      <p>We believe your home should be a reflection of your best life.

      </p>

     </div>





  </div>

 </div>

 <div class="line1"></div>



   <div style="text-align: center;margin: left 5px;">

    <?php if(isset($message)){

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

<div class="search-container" style="margin: 60px; text-align: center;">

  <form method="get" style="display: inline-block; position: relative; width: 400px;">

    <input type="text" name="search_term"

       placeholder="Search by Name, Email"

       value="<?php echo htmlspecialchars($search_query_display); ?>"

       style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; padding-right: 40px">

    <button type="submit" style="position: absolute; top: 15%; left: 180px; transform: translateY(-10%); background: none; border: none; cursor: pointer; color:#555;padding:0 1px;">

      <i class='bx bx-search' style="font-size: 20px;"></i>

    </button>

  </form>

</div>

<section class="order-container">

    <h1 class="title">Total Requests</h1>

    <div class="box-container">

      <?php

      if(mysqli_num_rows($select_orders)>0){

         while($fetch_orders = mysqli_fetch_assoc($select_orders)){



         ?>

      <div class="box">

         <p>User Name: <span><?php echo $fetch_orders['name'] ;?></span></p>

         <p >User id: <span><?php echo $fetch_orders['user_id'] ;?></span></p>

         <p>Placed on: <span><?php echo $fetch_orders['placed_on'] ;?></span></p>

         <p>Number:<span><?php echo $fetch_orders['number'] ;?></span></p>

         <p>Email:<span><?php echo $fetch_orders['email'] ;?></span></p>

         <p>Total Price:<span><?php echo $fetch_orders['total_price'] ;?></span></p>

         <p>Method:<span><?php echo $fetch_orders['method'] ;?></span></p>

         <p>Address:<span><?php echo $fetch_orders['address'] ;?></span></p>

         <p>Total Product:<span><?php echo $fetch_orders['total_products'] ;?></span></p>

         <form method="post">

           <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id'] ;?>">

           <select name="update_payment" >

            <option disabled selected><?php echo $fetch_orders['payment_status'] ;?></option>

            <option value="pending">Pending</option>

            <option value="complete">complete</option>

           </select>

           <input type="submit" name="update_order" value="Approve payment" class="btn">

            <a href="admin_order.php?delete=<?php echo $fetch_orders['id'] ;?>" onclick="return confirm('You want delete this order')" class="delete" style="margin-top: 10px;">Delete</a>



         </form>





      </div>

      <?php

           }

      }else{

           echo'<div class="empty">

      <p>No requests found!</p>

      </div>';

      }

      ?>

    </div>

</section>

<script type="text/javascript" src="script.js"></script>

</body>

</html>