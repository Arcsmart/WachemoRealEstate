<?php include 'connection.php' ?>


<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
          <!-------------bootstrap icon link---------------->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

          <!-------------slick slider link---------------->
           <link rel="stylesheet" type="text/css"  href="main.css">
          <title>Wachemo - Home page</title>
</head>
<body>
      <section class="popular-brands">
          <h1>POPULAR BRANDS</h1>
         <div class="controls">
                    <i class="bx bxs-chevron-left left"></i>
                    <i class="bx bxs-chevron-right right"></i>
               </div>
               <div class="popular-brands-content">
                <?php 
                $select_products=mysqli_query($conn,"SELECT * FROM `products`") or die('query faild');
                if(mysqli_num_rows($select_products)>0){
                    while($fetch_products=mysqli_fetch_assoc($select_products)){

                ?> 
                <form method="post" class="card">
                    <img src="images/<?php echo $fetch_products['image']; ?>" alt="">
                    <div class="price"><?php echo $fetch_products['price'];  ?></div>
                   <div class="name"><?php echo $fetch_products['name'];  ?></div>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id'];  ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'];  ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price'];  ?>">
                    <input type="hidden" name="product_quantity" value="1" min="1">
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['image'];  ?>">
                    <div class="icon">
                        <a href="view_page.php?pid=<?php echo $fetch_products['id'];  ?>"  class="fa-solid fa-eye"></a>
                        <button type="submit" name="add_to_wishlist" class="bx bxs-heart"></button> 
                          <button type="submit" name="add_to_cart" class="bx bxs-cart"></button>      
                    </div>
                </form>
                
                <?php 
                  }
               }else{
                 echo'<p class="empty">not product added yet</p>';
               }
                ?>   
               </div>
      </section>    
        <script type="text/javascript" src="script2.js">
          $(document).ready(function () {
                      $('.popular-brands-content').slick({
          lazyLoad: 'ondemand',
          slidesToShow: 4,
          slidesToScroll: 1,
           nextArrow: $(".left"),
           prevArrow: $(".right"),
          responsive: [
          {
          breakpoint: 1024,
          settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
          }
          },
          {
          breakpoint: 600,
          settings: {
          slidesToShow: 2,
          slidesToScroll: 2
          }
          },
          {
          breakpoint: 480,
          settings: {
          slidesToShow: 1,
          slidesToScroll: 1
          }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
          ]
          });

          })
                            
        </script>  
        
           <script  src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
</body>
</html>