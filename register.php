<?php
include 'connection.php';
$message = []; 
if (isset($_POST['submit_btn'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (!$email) {
        $message[] = 'Invalid email format';
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);

        $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'") or die('query failed');

        if (mysqli_num_rows($select_user) > 0) {
            $message[] = 'User already exists, please login';
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

                    mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$hashed_password')") or die('query not inserted');
                    
                    $message[] = 'Registered successfully';
                   
                }
                //  header('location:login.php');
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
          <!-- box icon links -->
           <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
           <link rel="stylesheet" type="text/css" href="style.css">
          <title>Register Page</title>
</head>

<body>
   
     <section class="form-container">
    
          <form method="post">
             <h1>Register Now</h1>
             <div style="text-align: center;">            
                <?php 
    if(isset($message)){
        foreach($message as $msg){
            echo '<div class="message">
                    <span>'.$msg.'</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                  </div>';
        }
    }
    ?> </div>
      
             <input type="text" name="name" placeholder="Enter your name" required>
             <input type="email" name="email" placeholder="Enter your email" required>
             <input type="password" name="password" placeholder="Enter your password" required>
             <input type="password" name="cpassword" placeholder="Confirm your password" required>
             <input type="submit" name="submit_btn"  value="Register now " class="btn"> 
             <p>Aready have an account ? <a href="login.php">Login now</a> </p>
          </form>

    </section>
     <script>
        const messages = document.querySelectorAll('.message');
        if (messages.length > 0 && messages[messages.length - 1].textContent.includes('Registered successfully')) {
            
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 1500); 
        }
    </script>      
</body>
</html>







