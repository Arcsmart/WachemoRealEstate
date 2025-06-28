<?php 
 session_start();
include 'connection.php';
// if (isset($_SESSION['user_id'])) {
//     $user_id = $_SESSION['user_id'];
// } else {
    
//     header('location:login.php');
//     exit(); 
    
//     $user_id = null; 
// }

// $admin_id = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
//  if(!isset($admin_id)){
//  header('location:login.php');     
//     }
 if(isset($_POST['logout'])){
        session_destroy();
        header('location:login.php');     
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
          <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
          <link rel="stylesheet" type="text/css" href="main.css">
          <title>About page</title>
    </head>
    <body>
         <?php  include 'header.php'; ?> 
         <div class="banner" style="background-image: url('images/unplash.jpeg');height:auto;">
          
          <div class="detail">
                    <h1 style="color:orange;">About Us</h1>
                     <div  class="centered-container">
                        <p>Let's Get Your Perfect Home </p>
                         <a href="index.php" style="color: orange;">Home</a><span>/About US</span>
                     </div>
                    
          </div>

       </div>
       <!-- about us -->
        <div class="about-us">
          <div class="row">
              <div class="box">
                  <div  class="title">
                    <span>ABOUT OUR ONLINE SUPPORT</span>
                  <h1>Hello, With 7 years of experience</h1> 
                  </div> 
                  <p>Over 25 years Ecommerce helping companies reach their financial and branding goals 
                  
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Explicabo nisi laborum totam assumenda minima quibusdam placeat fugit est quae beatae, animi id incidunt rem suscipit obcaecati vero, quod eum maiores.
              </p>
               </div>
               <div class="img-box">
                    <img src="images/image3.avif" alt="#">
               </div>     
          </div>
        </div>
         <!--------features---------->
         <div class="features">
            <div class="title">
                <h1>Complete Customer Ideals</h1> 
                <span>Best Features</span>   
            </div>
            <div class="row">
                 <div class="box">
                    <img src="images/realopen.jpg" alt="#">
                    <h4>Any Time</h4>
                    <p>Your Dedicated Support, Around the Clock</p>
                 </div>
                  <div class="box">
                    <img src="images/unsplashabout.avif" alt="#">
                    <h4>Confidence in Your Investment</h4>
                    <p>Secure Transactions, Peace of Mind</p>
                 </div> 
                  <div class="box">
                    <img src="images/realgift.jpg" alt="#">
                    <h4>Exclusive Welcome Offering</h4>
                    <p>Unlock the Door to Their Dream Property And 
                      The Gift of Exceptional Living</p>
                 </div> 
                  <div class="box">
                    <img src="images/download12.jpeg" alt="#">
                    <h4>Connecting You Globally with Premier Properties</h4>
                    <p>Exclusive Listings Upon Request (20+ Million Birr)</p>
                 </div>    
            </div>
         </div>
    <!--------team section---------->
    <div class="team">
          <div class="title">
             <h1>Our Workable Team</h1> 
             <span>Best team</span>      
          </div>
          <div class="row">
              <div class="box">
                 <div class="img-box">
                      <img src="images/girl3.jpeg" alt="#">        
                  </div>
                  <div class="detail">
                        <span>Finance  Manager</span>
                        <h4>Bekelech Haile</h4>
                         <div class="icons">
                       <i class="fa-brands fa-instagram"></i>     
                       <i class="fa-brands fa-youtube"></i>
                       <i class="fa-brands fa-square-x-twitter"></i>
                       <i class="fa-brands fa-whatsapp"></i>      
                     </div>      
                  </div>
              </div>
              <div class="box">
                 <div class="img-box">
                      <img src="images/man2.jpg" alt="#">        
                  </div>
                  <div class="detail">
                        <span>Business Developer</span>
                        <h4>Abebe Haile</h4>
                         <div class="icons">
                       <i class="fa-brands fa-instagram"></i>     
                       <i class="fa-brands fa-youtube"></i>
                       <i class="fa-brands fa-square-x-twitter"></i>
                       <i class="fa-brands fa-whatsapp"></i>      
                     </div>      
                  </div>
              </div>
              <div class="box">
                 <div class="img-box">
                      <img src="images/girl.jpeg" alt="#">        
                  </div>
                  <div class="detail">
                        <span>Manager</span>
                        <h4>Abebech woo</h4>
                         <div class="icons">
                       <i class="fa-brands fa-instagram"></i>     
                       <i class="fa-brands fa-youtube"></i>
                       <i class="fa-brands fa-square-x-twitter"></i>
                       <i class="fa-brands fa-whatsapp"></i>      
                     </div>      
                  </div>
              </div> 
              <div class="box">
                 <div class="img-box">
                      <img src="images/man1.jpg" alt="#">        
                  </div>
                  <div class="detail">
                        <span>Sales  Manager</span>
                        <h4>Yonas Abebe</h4>
                         <div class="icons">
                       <i class="fa-brands fa-instagram"></i>     
                       <i class="fa-brands fa-youtube"></i>
                       <i class="fa-brands fa-square-x-twitter"></i>
                       <i class="fa-brands fa-whatsapp"></i>      
                     </div>      
                  </div>
              </div> 
              <div class="box">
                 <div class="img-box">
                      <img src="images/man.jpeg" alt="">        
                  </div>
                  <div class="detail">
                        <span>Finace Manager</span>
                        <h4>devo white</h4>
                         <div class="icons">
                       <i class="fa-brands fa-instagram"></i>     
                       <i class="fa-brands fa-youtube"></i>
                       <i class="fa-brands fa-square-x-twitter"></i>
                       <i class="fa-brands fa-whatsapp"></i>      
                     </div>      
                  </div>
              </div>        
          </div>
    </div>
         <?php  include 'footer.php'; ?>
<script type="text/javascript" src="script.js"></script>
    </body>
    </html>