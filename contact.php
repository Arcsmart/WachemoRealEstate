    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'connection.php';
$message=[];
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    } else {
    header('location:login.php');

    exit();
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
if(isset($_POST['submit-btn'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $number = mysqli_real_escape_string($conn,$_POST['number']);
    $user_message = mysqli_real_escape_string($conn,$_POST['message']); // Use a different variable for the user's message

    $select_message= mysqli_query($conn,"SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number='$number' AND message='$user_message'") or die('query faild');

    if(mysqli_num_rows($select_message)>0){
        $message[]='Message already sent';
    } else {
        mysqli_query($conn,"INSERT INTO `message`(`user_id`,`name`,`email`,`number`,`message`) values ('$user_id','$name','$email','$number','$user_message')") or die('query faild');
        $message[]='Message sent successfully';
        // header('location:contact.php');
        // exit();
    }
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
          <title>contact page</title>
    </head>
    <body>
         <?php include 'header.php'?>
         <div class="banner">
          <div class="detail" style="margin-top: 100px;">
                    <h1 style="color:orange;" >Contact Us</h1>
                     <div  class="centered-container">
                        <p>We believe your home should be a reflection of your best life. 
                         </p>
                         <a href="index.php" style="color: orange;">Home</a><span>/Contact</span>
                     </div>
                    
          </div>
        </div>
        <!--from services-->
         
           

           <div class="form-container">
  
                <h1 class="title">Leave a Message</h1>  
                <form method="post">
                                        <?php 
    if(isset($message)){
        foreach($message as $msg){
            echo '<div class="message">
                    <span>'.$msg.'</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                  </div>';
        }
    }
    ?>
                    <div class="input-field">
                       
                        
                         <input type="text" name="name" placeholder="Your Name" required>    
                    </div>
                     <div class="input-field">
                        
                         <input type="email" name="email" placeholder="Your Email" required>    
                    </div>
                     <div class="input-field">
                        
                         <input type="text" name="number" placeholder="Phone Number" required>    
                    </div>
                     <div class="input-field">
                        
                        <textarea name="message" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" name="submit-btn" style="background-color: orange;">Send Message</button>
                </form>  
           </div>
           <div class="address">
                <h1 class="title">Our Contact</h1>
                <div class="row">
                <div class="box">
                    <i class="fa-solid fa-map"></i>
                    <div>
                       <h4>Address</h4> 
                       <p>Heto Hossana <br> Ethiopia</p>      
                    </div>
                </div>
                <div class="box">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                       <h4>Phone Number</h4> 
                       <p> +251-90-020-45-00</p>      
                    </div>
                </div>
                <div class="box">
                    <i class="fa-solid fa-envelope"></i>
                       <h4>Email:</h4>
                       
                       <p> wachemorealestate@gmail.com</p>      
                    </div>
                </div>
               </div>
           </div>

           <div></div>
       
      <?php  include 'footer.php'; ?>
     
         <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
           <script>
        const messages = document.querySelectorAll('.message');
        if (messages.length > 0 && messages[messages.length - 1].textContent.includes('Message sent successfully')) {
            
            setTimeout(function() {
                window.location.href = 'contact.php';
            }, 10000); 
        }
    </script>      
         <script type="text/javascript" src="script.js"></script>
    </body>
    </html>