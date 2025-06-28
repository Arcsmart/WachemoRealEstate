<?php
include 'connection.php';
session_start();

$admin_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$admin_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

// if(!isset($admin_id)){
//     header('location:login.php');
//     exit();
// }

// Check if the logged-in user is an admin
$check_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$admin_id' AND user_type = 'admin'") or die('query failed');
if(mysqli_num_rows($check_admin) == 0){
    $message[] = 'You are not authorized to access this page.';
    // Optionally redirect to another page
    // header('location:home.php');
    // exit();
}

$message = [];
if (isset($_POST['submit_btn'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = 'admin'; // Directly set the user type to 'admin'

    if (!$email) {
        $message[] = 'Invalid email format';
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);

        $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'") or die('query failed');

        if (mysqli_num_rows($select_user) > 0) {
            $message[] = 'Admin already exists, please login';
        } else {
            if ($password != $cpassword) {
                $message[] = 'Passwords do not match';
            } else {
                // Added password length check
                if (strlen($password) < 6) {
                    $message[] = 'Password must be at least 6 characters';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $hashed_password = mysqli_real_escape_string($conn, $hashed_password);

                    mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`, `user_type`) VALUES ('$name','$email','$hashed_password', '$user_type')") or die('query not inserted');

                    $message[] = 'New admin added successfully!';
                    // Optionally clear the form after successful registration
                    $_POST = array();
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Add Admin</title>
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
       <!-- <div class="banner">
          <div class="detail">
                    <h1 style="color: #fff;" >Admin Dashdoard</h1>
                     <div  class="centered-container">
                        <p>We believe your home should be a reflection of your best life. 
                         </p>
                     </div>
                    
          </div>
       </div> -->
        <!-- admin_header.php -->
    <div class="line1"></div>

    <section class="form-container">

        <form method="post">
            <h1>Add New Admin</h1>
            <div style="text-align: center;">
                <?php
                if(isset($message)){
                    foreach($message as $msg){
                        echo '<div class="message">
                                <span>'.$msg.'</span>
                                <i class="bx bx-x-circle" onclick="this.parentElement.remove()"></i>
                            </div>';
                    }
                }
                ?>
            </div>

            <input type="text" name="name" placeholder="Enter admin name" required>
            <input type="email" name="email" placeholder="Enter admin email" required>
            <input type="password" name="password" placeholder="Enter admin password" required>
            <input type="password" name="cpassword" placeholder="Confirm admin password" required>
            <input type="submit" name="submit_btn"  value="Add Admin" class="btn">
            <p>Back to <a href="admin_pannel.php">Admin Panel</a></p>
        </form>

    </section>
</body>
</html>