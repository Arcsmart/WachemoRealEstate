<?php
session_start();
include 'connection.php';

// Geocoding function
function geocodeAddress($address) {
    $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);
    $opts = [
        "http" => [
            "header" => "User-Agent: MyRealEstateApp/1.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $data = json_decode($response, true);
    
    if (!empty($data)) {
        return [
            'lat' => $data[0]['lat'],
            'lng' => $data[0]['lon']
        ];
    }
    return null;
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location:login.php');
    exit();
}

$admin_id = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
if(!isset($admin_id)) {
    header('location:login.php');     
}

if(isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');     
}

// Add to cart logic
if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $cart_num = mysqli_query($conn,"SELECT * FROM `cart` WHERE name='$product_name' AND user_id ='$user_id'") or die('query failed');
    
    if(mysqli_num_rows($cart_num) > 0) {
        $message[] ='Property already exists in checkout';  
        header('location:cart.php');
        exit();  
    } else {
        mysqli_query($conn,"INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");  
        $message[]='Property successfully added';
        header('location:cart.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon-32x32.png" type="image/x-icon">
    
    <!-- Leaflet CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Other Styles -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="main.css">
    
    <style>
        #propertyMap {
            height: 300px;
            width: 100%;
            margin: 20px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            z-index: 1; 
        }
    </style>
    <title>View Property</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="popular-brands show-products view_page">
        <?php if(isset($message)): ?>
            <?php foreach($message as $msg): ?>
                <div class="message">
                    <span><?php echo $msg; ?></span>
                    <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php 
        if(isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn,"SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
            
            if(mysqli_num_rows($select_products) > 0) {
                while($fetch_products = mysqli_fetch_assoc($select_products)) {
                    $coordinates = geocodeAddress($fetch_products['name']);
                    $lat = $coordinates ? $coordinates['lat'] : 8.9806;
                    $lng = $coordinates ? $coordinates['lng'] : 38.7578;
        ?>
                    <form method="post" class="card box">
                        <div>
                            <img src="images/<?php echo $fetch_products['image']; ?>" alt="">
                        </div>
                        
                        <div class="detail">
                            <div class="price">Price: <?php echo $fetch_products['price']; ?> Birr</div>
                            <div class="name" style="margin-left: 10px;">Location: <?php echo $fetch_products['name']; ?></div>
                            <div class="detail"><?php echo $fetch_products['product_detail']; ?></div>
                            
                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                            <div id="propertyMap"></div>

                            <div class="icon">
                                <input type="number" name="product_quantity" value="1" min="1" class="quantity" placeholder="How much do you want to buy">
                                <button type="submit" name="add_to_cart">Go to Payment</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        // Initialize Leaflet map with verification
                        (function() {
                            // Verify Leaflet is loaded
                            if(typeof L === 'undefined') {
                                console.error('Leaflet library not loaded!');
                                return;
                            }
                            
                            const coords = [<?php echo $lat; ?>, <?php echo $lng; ?>];
                            const map = L.map('propertyMap').setView(coords, 13);
                            
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            L.marker(coords)
                                .addTo(map)
                                .bindPopup('<?php echo addslashes($fetch_products['name']); ?>');
                        })();
                    </script>
        <?php 
                }
            }
        }
        ?>
    </section>

    <?php include 'footer.php'; ?>
    
    <!-- Other scripts -->
    <script src="https://kit.fontawesome.com/16ffa0903e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>