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
      //  searching functionality
      $where_clause = "WHERE 1=1";
$search_term = '';
$min_price = null;
$max_price = null;

if (isset($_GET['search_all']) && !empty($_GET['search_all'])) {
    $search_all = mysqli_real_escape_string($conn, $_GET['search_all']);
    $search_term = trim($search_all); // Trim leading/trailing spaces

    // Attempt to extract a price range from the search term
    if (preg_match('/(\d+)-(\d+)/', $search_term, $price_matches)) {
        $min_price = intval($price_matches[1]);
        $max_price = intval($price_matches[2]);
        // Remove the price range from the search term for name searching
        $search_term = trim(str_replace($price_matches[0], '', $search_term));
    } elseif (preg_match('/>=(\d+)/', $search_term, $min_matches)) {
        $min_price = intval($min_matches[1]);
        $search_term = trim(str_replace($min_matches[0], '', $search_term));
    } elseif (preg_match('/<=(\d+)/', $search_term, $max_matches)) {
        $max_price = intval($max_matches[1]);
        $search_term = trim(str_replace($max_matches[0], '', $search_term));
    }elseif (preg_match('/(\d+)/', $search_term, $single_price_match)) {
        $min_price = intval($single_price_match[1]);
        $max_price = intval($single_price_match[1]);
        $search_term = trim(str_replace($single_price_match[0], '', $search_term));
     }

    // Search by name if there's any remaining search term
    if (!empty($search_term)) {
        $where_clause .= " AND name LIKE '%$search_term%'";
    }

    // Filter by price if min or max price is found
    if ($min_price !== null) {
       $where_clause .= " AND price >= $min_price";
    }
    if ($max_price !== null) {
        $where_clause .= " AND price <= $max_price";
    }
}

$select_products = mysqli_query($conn, "SELECT * FROM `products` $where_clause") or die('query failed');
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
         <!--box icons -->
           <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
         

          <link rel="stylesheet" type="text/css" href="main.css">
          <title>Buy page</title>
    </head>
    <body>
         <?php  include 'header.php'; ?> 
         <!-- <div style="margin-top: 40px;">Let's Get it</div> -->
         <br><br><br><br>
         <!-- <div class="banner" style="background-image: url('images/12345.jpg');height:89vh;">
          <div class="detail" style="margin-top: 100px;">
                    <h1 style="color:orange;" >Buy Now</h1>
                     <div  class="centered-container">
                        <p>We believe your home should be a reflection of your best life. 
                         </p>
                         <a href="index.php" style="color: orange;">Home</a><span>/Buy now</span>
                     </div>
                    
          </div>
        </div> -->
  <div class="search-container" style="margin: 60px; text-align: center;">
    <form method="get" style="display: inline-block; position: relative; width: 400px;">
        <input type="text" name="search_all" 
               placeholder="Search by Location or Price (e.g., Apartment 1000-2000)" 
               style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%; padding-right: 40px">
        <button type="submit"style="position: absolute; top: 15%; left: 165px; transform: translateY(-20%); background: none; border:1px; cursor: pointer; color: #555;margin:20px;padding:0 1px;">
            <i class='bx bx-search' style="font-size: 20px;"></i>
        </button>
    </form>
</div>
       
         <section class="popular-brands show-products">
          <h1 class="title" style="margin:40px;">Find Your Home</h1>
                 <?php  if(isset($message)){
           foreach($message as $message){
               echo '<div class="message">
               
                    <span>'.$message.'</span>
                    <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                    
                   </div>';    
           }
     }
     ?>
         
               <div class="popular-brands-content box-container">
                <?php 
               if(mysqli_num_rows($select_products) > 0) {
        while($fetch_products = mysqli_fetch_assoc($select_products)) {


                ?> 
                <form method="post" class="card box">
                    <img src="images/<?php echo $fetch_products['image']; ?>" alt="">
                    <div class="price" style="margin-left: 10px;"> Price :  <?php echo $fetch_products['price'];  ?>Birr</div>
                   <div class="name"style="margin-left: 10px;"> Location :  <?php echo $fetch_products['name'];  ?></div>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id'];  ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'];  ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price'];  ?>">
                    <input type="hidden" name="product_quantity" value="1" min="1">
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['image'];  ?>">
                    <div class="icon">
                        <a href="view_page.php?pid=<?php echo $fetch_products['id'];  ?>">view more</a>
                        <!-- <button type="submit" name="add_to_wishlist" class="fa-solid fa-thumbs-up"></button> 
                          <button type="submit" name="add_to_cart" class="fa-solid fa-thumbs-down"></button>       -->
                    </div>
                </form> 
                
                <?php 
                  }
               }else{
                 echo'<p class="empty">not property added yet</p>';
               }
                ?>   
               </div>
      </section>   
    
         <?php  include 'footer.php'; ?>
         <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
         <script type="text/javascript" src="script.js"></script>
    </body>
    </html>