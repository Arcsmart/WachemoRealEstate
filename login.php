<?php
session_start(); // Now at the very top
include 'connection.php';

if (isset($_POST['submit_btn'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];  

    if (!$email) {
        $message[] = 'Invalid email format';
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'") or die('Query failed');

        if (mysqli_num_rows($select_user) > 0) {
            $row = mysqli_fetch_assoc($select_user);

            if (password_verify($password, $row['password'])) {
                if ($row['user_type'] == 'admin') {  
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['admin_email'] = $row['email'];
                    $_SESSION['admin_id'] = $row['id'];
                    header('location:admin_pannel.php');
                    exit();
                } elseif ($row['user_type'] == 'user') {  
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['user_id'] = $row['id'];
                    header('location:index.php');
                    exit();
                } else {
                    $message[] = 'Unknown user type';
                }
            } else {
                $message[] = 'Incorrect email or password';
            }
        } else {
            $message[] = 'Incorrect email, password, or not registered';
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
    <title>Login page</title>
</head>
<body>
    <section class="form-container">
        <form method="post">
            <h1>Login Now</h1>
            <div style="text-align: center; color: red;">
                <?php
                if (isset($message)) {
                    foreach ($message as $msg) {
                        echo '<div class="message">
                                <span>'.$msg.'</span>
                                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                              </div>';
                    }
                }
                ?>
            </div>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="submit" name="submit_btn" value="Login now" class="btn">
            <p>Do not have an account? <a href="register.php">Register now</a></p>
        </form>
    </section>
</body>
</html>






