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
            <!-- Include Slick CSS -->
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
          <!-- box icon links -->
           <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

          <link rel="stylesheet" type="text/css" href="main.css">
          <title>index page</title>
    </head>
    <body>
          
        <!-- header.php -->
          <header class="header" >
          <div class="flex">
             <a href="admin_pannel.php" class="logo"> <img src="images/logo1.jpg" alt="logo" width="160px" height="100px"></a>   
             <nav class="navbar">
                <a href="index.php">Home</a> 
                <a href="buy.php">Buy</a>
                <a href="about.php">about us</a>
                <a href="contact.php">contact</a>   
           </nav>
           <div class="icons">
                <i class='bx bxs-user ' id="user-btn"> </i>
                <i class="fa-solid fa-bars" id="menu-btn" ></i>
            </div> 
          <div class="user-box">

              <p>Username: <span> <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?></span></p>
                <p>Email: <span> <?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?></span></p>

              
              
              <form method="post">
                    <button type="submit" name="logout" class="logout-btn">Log out</button>
              </form>           
          </div>   

       </div>

     </header> 
 <!-- header.php -->
           <!----------------Home slider-------------------->
          
           <div class="container-fluid">
               <div class="hero-slider">
                    <div class="slider-item">
                      <img src="images/villa.jpg" alt="img"> 
                      <div class="slider-caption">
                         <!-- <span>Test The Quality life</span>  -->
                         <h1>Your perfect Home <br>Wachemo Real Estate</h1>
                         <p>Embrace a pure lifestyle in a handcrafted home, made with <br>ecological materials by the hardworking people of this pristine environment!</p>
                         <a href="buy.php">Buy now</a>

                      </div>       
                    </div>
                    <div class="slider-item">
                      <img src="images/large2.jpg" alt="img"> 
                      <div class="slider-caption">
                         <!-- <span>Test The Quality life</span>  -->
                         <h1>Your perfect Home <br>Wachemo Real Estate</h1>
                         <p>Embrace a pure lifestyle in a handcrafted home, made with <br>ecological materials by the hardworking people of this pristine environment!</p>
                         <a href="buy.php">Buy now</a>

                      </div>       
                    </div>
                    <div class="slider-item">
                      <img src="images/large3.jpg" alt="img"> 
                      <div class="slider-caption">
                         <!-- <span>Test The Quality life</span>  -->
                         <h1>Your perfect Home <br>Wachemo Real Estate</h1>
                         <p>Embrace a pure lifestyle in a handcrafted home, made with <br>ecological materials by the hardworking people of this pristine environment!</p>
                         <a href="buy.php">Buy now</a>
                         
                      </div>       
                    </div>
                   <div class="slider-item">
                      <img src="images/100031.jpeg" alt="img"> 
                      <div class="slider-caption">
                         <!-- <span>Test The Quality life</span>  -->
                         <h1>Your perfect Home <br>Wachemo Real Estate</h1>
                         <p>Embrace a pure lifestyle in a handcrafted home, made with <br>ecological materials by the hardworking people of this pristine environment!</p>
                         <a href="buy.php">Buy now</a>

                      </div>       
                    </div>  
               </div>  
               <div class="controls">
                    <i class="bx bxs-chevron-left prev"></i>
                    <i class="bx bxs-chevron-right next"></i>
               </div>   
           </div>
           <div class="services">
            <div class="row">
              <div class="box">
                <img src="" alt="">
                <div>
                  <h1>Expert Guidance, Always Within Reach.</h1>
                  <p>Navigate the Wachemo real estate market with confidence. Our expert support is available to guide you, whenever you require assistance.</p>
                </div>
              </div>
               <div class="box">
                <img src="" alt="">
                <div>
                  <h1>Fast Track Your Property Dreams.</h1>
                  <p>We accelerate your real estate journey, making the process quick and efficient.</p>
                </div>
              </div>
               <div class="box">
                <img src="" alt="">
                <div>
                  <h1>vartual Guidance support</h1>
                  <p>Immerse Yourself in Wachemo Real Estate: Discover Properties Through Virtual Tours and Interactive Guidance.</p>
                </div>
              </div>
            </div>
           </div>
           <div class="story">
               <div class="row">
                  <div class="box">
                    <span>Our story</span>
                    <h1>We provided more than 100 home since 2010</h1>
                    <p>Since 2010, we've had the pleasure of connecting over 100 buyers with their ideal homes – properties frequently situated in desirable environments with captivating views, building lasting happiness and trust.</p>
                    <a href="buy.php" class="btn">shop now</a>
                    
                  </div>
                  <div class="box">
                       <img src="images/image4.avif" alt="image">
                    </div>
               </div>
           </div>
           <!-----------testimonial--------->
           <div class="testimonal-fluid" style="background-color: #555;height:80vh;margin-top: 10px;">
            <h1 class="title">What Our Customers Say's</h1>
            <div class="testimonal-slider">
              <div class="testimonal-item">
                <img src="images/DSC_5675.JPG" alt="#">
                <span>Anaol Gemedo</span>
                <h1>Your Perfect choice</h1>
                <p >&quot;Choosing Wachemo Real Estate was the best decision I made. Their experience and dedication truly shine through, and I'm thrilled with my new home.&quot;
                         </p>
              </div>
              <div class="testimonal-item">
                <img src="images/DSC_5672.JPG" alt="#">
                <span>Amanuel Wondimu</span>
                <h1>Your Perfect choice</h1>
                <p>&quot;Your Real Estate  really understood my desire for a home in a nice environment. I'm so happy with the location and the fantastic views my new property offers.&quot;
                              </p>
              </div>
              <div class="testimonal-item">
                <img src="images/human.jpeg" alt="#">
                <span>Deve Perman</span>
                <h1>Your Perfect choice</h1>
                <p>&quot;Finding a home with a great view was high on my list, and Wachemo Real Estate delivered! I wake up every day to a beautiful vista, and the neighborhood is so lovely. Highly recommend!&quot;</p>
              </div>
            </div>
            <div class="controls">
                    <i class="bx bxs-chevron-left prev1"></i>
                    <i class="bx bxs-chevron-right next1"></i>
               </div>
           </div>
           <!-----discover section--------->
           <div class="discover">
               <div class="detail">
                   <h1>Enjoy Your Life </h1>
                   <span>Buy Now And Save 30% off!</span>
                   <p>Imagine a life where stunning lake views are your everyday backdrop. Discover the unique charm and tranquility of lakeside living in Hawassa. Explore a range of properties, from charming cottages to luxurious waterfront estates, all offering a connection to nature and a relaxed pace of life. Let us help you discover your perfect lakeside retreat.</p>
                   <a href="buy.php" class="btn">Discover Now</a>
               </div>
               <div class="img-box">
                  <img src="images/image15.avif" alt="">
               </div>
           </div>
           
          <?php  include 'footer.php'; ?>
          
         <div>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
             <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>  
             <!-- loading  -->
                 

             <script  src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
              <script type="text/javascript" src="script2.js"></script> 
         </div>
        
            
          </body>
    </html>