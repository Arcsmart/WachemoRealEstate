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
  $message[]='Request removed successfully';
  header('location:admin_order.php');
}
// Email functionality
function sendOrderCompletionEmail($userEmail, $orderId) {
  // Load PHPMailer files
  require __DIR__ . '/PHPMailer/Exception.php';
  require __DIR__ . '/PHPMailer/PHPMailer.php';
  require __DIR__ . '/PHPMailer/SMTP.php';

  // Use full namespace
  $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host    = 'smtp.gmail.com';
    $mail->SMTPAuth  = true;
    $mail->Username  = 'dawitalex560@gmail.com'; // Your email
    $mail->Password  = 'bdjg ivzg nxsl mqpx';    // App password
    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port    = 587;

    // Recipients
    $mail->setFrom('dawitalex560@gmail.com', 'Wachemo Real Estate');
    $mail->addAddress($userEmail);
    $imagePath = __DIR__ . '/images/logo1.jpg';
    $mail->addEmbeddedImage($imagePath, 'logo_wachemo');

    // Content
   $mail->isHTML(false);
   $mail->Subject = 'Welcome to Wachemo Real Estate! Find Your Dream Property';
   $mail->Body  = "Dear Valued Customer,\n\n"
            . "Warm welcome to the Wachemo Real Estate family!\n\n"
            . "Congratulations on taking this exciting step towards property ownership! "
            . "We're thrilled to be part of your journey in acquiring your dream property.\n\n"
            . "Your Request #$orderId has been successfully processed. "
            . "Our team is currently preparing your property documents and will send them to you shortly.\n\n"
            . "This is just the beginning of your property ownership journey with us. "
            . "Should you have any questions or need assistance, our support team is always ready to help.\n\n"
            . "Thank you for choosing Wachemo Real Estate - where dreams find their address!\n\n"
            . "Contact us\n\n"
            ."Email:tesfaye001@gmail.com\n"
            ."Phone:+25100043202\n"
            ."Address:Hossana\n"
            . "Best regards,\n"

            . "The Wachemo Real Estate Team,Hossana Ethiopia";

    $mail->send();
    return true;
  } catch (\PHPMailer\PHPMailer\Exception $e) {
    error_log("Mail Error: " . $e->getMessage());
    return $e->getMessage();
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
     $message[] = 'Notification email sent to client.';
   } else {
     $message[] = 'Failed to send notification email.'.$emailResult;
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
$select_orders_query = "SELECT * FROM `order`" . $sql_conditions . " ORDER BY id DESC";
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
     <title>Admin Panel</title>
     <style>
            .order-container {
        padding: 20px;
      }
      .title {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
      }
      .box-container {
        width: 100%; 
        margin-left: 0;
        margin-right: 0;

      }

        .order-table {
           width: 100%;
           margin: 20px auto;
           border-collapse: collapse;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-table th, .order-table td {
            border: 1px solid #ddd;
           padding: 10px;
           text-align: left;
           white-space: nowrap; 
        }

        .order-table th {
           background-color: #f2f2f2;
           font-weight: bold;
        }
        form {
  display: flex;
  gap: 10px;
  align-items: center;
}
/* Add/Modify these styles in your <style> section */
.payment-status-column {
  width: 400px; 
  min-width: 270px;
}

form {
  display: flex;
  gap: 10px;
  align-items: center;
  min-width: 180px; 
}

select {
  flex: 1; 
  min-width: 100px; 
  padding: 5px;
}

.btn {
  flex-shrink: 0; 
  /* padding: 6px 10px; */
  text-transform: uppercase;
  width: auto; 
}


        .delete {
           display: inline-block;
           padding: 8px 12px;
           background-color: #e74c3c;
           color: white;
           text-decoration: none;
           border-radius: 5px;
           font-size: 14px;
        }

        .delete:hover {
           background-color: #c0392b;
        }

        .btn {
           display: inline-block;
           /* padding: 8px 12px; */
           background-color: #3498db;
           color: white;
           text-decoration: none;
           border-radius: 5px;
           font-size: 10px;
           cursor: pointer;
           border: none;
        }
        .btn {
           /* padding: 8px 15px;  */
           text-transform: uppercase; 
           box-sizing: border-box; 
           padding: 6px 12px;  /* Reduced padding */
          text-transform: uppercase;
          width: 10px;       /* Fixed width */
          flex-shrink: 0;     /* Prevent shrinking */
           box-sizing: border-box; /* Include padding in width */
           flex-shrink: 0; /* Prevent button from shrinking */
  width: 250%; /* Fixed button width relative to column */
  min-width: auto; /* Absolute minimum button width */
  padding: 6px 3px;
  text-transform: uppercase;
  font-size: 12px;

          }

        .btn:hover {
           background-color: #2980b9;
        }

        .empty {
           text-align: center;
           padding: 20px;
           font-size: 16px;
           color: #777;
        }

      
        .payment-status-column {
          width: 350px !important;
         }
       


     </style>
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
     <h1 style="color: #fff;" >Admin Dashboard</h1>
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
    <div class="box-container" style="margin:auto;">
      <?php
      if(mysqli_num_rows($select_orders)>0){
         echo '<table class="order-table">';
         echo '<thead>';
         echo '<tr>';
        //  echo '<th>ID</th>';
         echo '<th>User Name</th>';
        
         echo '<th>Date</th>';
         echo '<th>Phone Number</th>';
         echo '<th>Email</th>';
         echo '<th>Total Price</th>';
         echo '<th>Address</th>';
         echo '<th>Method</th>';
         echo '<th  class="payment-status-column">Payment Status</th>';
         echo '<th style="width: 120px;">Action</th>';
         echo '</tr>';
         echo '</thead>';
         echo '<tbody>';
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
           echo '<tr>';
          //  echo '<td>'.htmlspecialchars($fetch_orders['user_id']).'</td>';
           echo '<td>'.htmlspecialchars($fetch_orders['name']).'</td>';
          
           echo '<td>'.htmlspecialchars($fetch_orders['placed_on']).'</td>';
           echo '<td>'.htmlspecialchars($fetch_orders['number']).'</td>';  
           echo '<td>'.htmlspecialchars($fetch_orders['email']).'</td>';
           echo '<td>'.htmlspecialchars($fetch_orders['total_price']).'</td>';
           echo '<td>'.htmlspecialchars($fetch_orders['address']).'</td>';
           echo '<td>'.htmlspecialchars($fetch_orders['method']).'</td>';
           echo '<td style="width: 150px;">';
           echo '<form method="post">';
           echo '<input type="hidden" name="order_id" value="'.htmlspecialchars($fetch_orders['id']).'">';
           echo '<select name="update_payment">';
           echo '<option disabled selected>'.htmlspecialchars($fetch_orders['payment_status']).'</option>';
           echo '<option value="pending">Pending</option>';
           echo '<option value="complete">Complete</option>';
           echo '</select>';
           
        //    echo '<td class="update-button-column"><input type="submit" name="update_order" value="Update" class="btn"></td>';

           echo '<input type="submit" name="update_order" value="update" class="btn">';
           echo '</form>';
           echo '</td>';
           echo '<td><a href="admin_order.php?delete='.htmlspecialchars($fetch_orders['id']).'" onclick="return confirm(\'You want to delete this request\')" class="delete">Delete</a></td>';
           echo '</tr>';
         }
         echo '</tbody>';
         echo '</table>';
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