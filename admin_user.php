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

 mysqli_query($conn,"DELETE FROM `users` WHERE id ='$delete_id'") or die('query faild');
 $message[]='User removed seccefully';
 header('location:admin_user.php');
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
  // Search in 'name' and 'email' columns (case-insensitive)
  $conditions[] = "(LOWER(name) LIKE LOWER('%$part%') OR LOWER(email) LIKE LOWER('%$part%'))";
 }
 }

 if (!empty($conditions)) {
 $sql_conditions = " WHERE " . implode(' OR ', $conditions);
 }
}

// Fetch users based on search conditions or all users
$select_users_query = "SELECT * FROM `users`" . $sql_conditions . " ORDER BY id DESC";
$select_users = mysqli_query($conn, $select_users_query) or die('query failed');
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
        .user-table {
           width: 90%;
           margin: 20px auto;
           border-collapse: collapse;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-table th, .user-table td {
           border: 1px solid #ddd;
           padding: 10px;
           text-align: left;
        }

        .user-table th {
           background-color: #f2f2f2;
           font-weight: bold;
        }

        .delete_me {
           display: inline-block;
           padding: 8px 12px;
           background-color: #e74c3c;
           color: white;
           text-decoration: none;
           border-radius: 5px;
           font-size: 14px;
        }

        .delete_me:hover {
           background-color: #c0392b;
        }

        .user-type-admin {
           color: orange;
           font-weight: bold;
        }

        .empty {
           text-align: center;
           padding: 20px;
           font-size: 16px;
           color: #777;
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
  <button type="submit" style="position: absolute; top: 0%; left: 180px; transform: translateY(-10%); background: none; border: none; cursor: pointer; color: #555;">
   <i class='bx bx-search' style="font-size: 20px;"></i>
  </button>
 </form>
</div>
 <section class="message-container" style="background-color: #f5f5f5;">
    <h1 class="title">Total Users Account</h1>
    <div class="box-container">
      <?php
      if(mysqli_num_rows($select_users)>0){
        echo '<table class="user-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th>User Type</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($fetch_users=mysqli_fetch_assoc($select_users)){
 echo '<td>'.$fetch_users['id'].'</td>';
 echo '<td>'.$fetch_users['name'].'</td>';
 echo '<td>'.$fetch_users['email'].'</td>';
           echo '<td class="user-type-'.htmlspecialchars($fetch_users['user_type']).'">'.htmlspecialchars($fetch_users['user_type']).'</td>';
           echo '<td><a href="admin_user.php?delete='.$fetch_users['id'].'" onclick="return confirm(\'You want to delete this user\')" class="delete_me">Delete</a></td>';
           echo '</tr>';
         }
         echo '</tbody>';
         echo '</table>';
       }else{
            echo'<div class="empty">
       <p>No users found!</p>
       </div>';
       }
       ?>
     </div>
  </section>
 <script type="text/javascript" src="script.js"></script>
 </body>
 </html>




