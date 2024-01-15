<?php 
include'Components/connect.php';
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

include 'Components/wishlist_cart.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- swiper slide link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include'Components/user_header.php';?>

<div class="home-bg">
    <section class="swiper home-slider">
        <div class="swiper-wrapper">

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/art1.png" width="500px" height="500px" alt="">
                </div>
                <div class="content">
                    <span>Menyediakan kebutuhan rumah tangga</span>
                    <h3>Perlengkapan Rumah Tangga</h3>
                    <a href="shop.php" class="btn">Beli sekarang</a>
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/art2.png" width="500px" height="500px" alt="">
                </div>
                <div class="content">
                    <span>Menyediakan kebutuhan rumah tangga</span>
                    <h3>Peralatan Dapur</h3>
                    <a href="shop.php" class="btn">Beli sekarang</a>
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/art3.png" width="500px" height="500px" alt="">
                </div>
                <div class="content">
                    <span>Menyediakan kebutuhan rumah tangga</span>
                    <h3>Perlengkapan Masak</h3>
                    <a href="shop.php" class="btn">Beli sekarang</a>
                </div>
            </div>

        </div>

        <div class="swiper-pagination"></div>

    </section>
</div>

<!-- home category section starts -->
<section class="home-category">
    <h1 class="heading">Shop by Category</h1>
    <div class="swiper category-slider">

        <div class="swiper-wrapper">
            <a href="category.php?category=alatmasak" class="swiper-slide slide">
                <img src="images/kitchen.png" alt="">
                <h3>Alat Masak</h3>
            </a>

            <a href="category.php?category=alatmakan" class="swiper-slide slide">
                <img src="images/cutlery.png" alt="">
                <h3>Alat Makan</h3>
            </a>

            <a href="category.php?category=bumbu" class="swiper-slide slide">
                <img src="images/ingredient.png" alt="">
                <h3>Bumbu Dapur</h3>
            </a>

            <a href="category.php?category=buah" class="swiper-slide slide">
                <img src="images/fruit.png" alt="">
                <h3>Buah-Buahan</h3>
            </a>

            <a href="category.php?category=sayuran" class="swiper-slide slide">
                <img src="images/vegetables.png" alt="">
                <h3>Sayuran</h3>
            </a>
            
            <a href="category.php?category=bahan" class="swiper-slide slide">
                <img src="images/grocery.png" alt="">
                <h3>Bahan Masak</h3>
            </a>

            <a href="category.php?category=food" class="swiper-slide slide">
                <img src="images/biryani.png" alt="">
                <h3>Makanan</h3>
            </a>
            
            <a href="category.php?category=snack" class="swiper-slide slide">
                <img src="images/snack.png" alt="">
                <h3>Cemilan</h3>
            </a>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<!-- home category section ends -->

<!-- home products section starts -->
<section class="home-products">
    <h1 class="heading">Products</h1>
    <div class=" swiper products-slider">
        <div class="swiper-wrapper">
        <?php 
            $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
            $select_products->execute();
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){       
        ?>
        <form action="" method="post" class="slide swiper-slide">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">

            <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
            <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/<?= $fetch_products['image_01'] ?>" class="image" alt="">
            <div class="name"><?= $fetch_products['name'] ?></div>
            <div class="flex">
                <div class="price">Rp <span><?=$fetch_products['price'];?></span></div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
            </div>
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
        </form>
        <?php 
                }
            }else{
                echo '<p class="empty">No Products to show!</p>';
            }
        ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<!-- home products section ends -->











<?php include'Components/footer.php';?>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<!-- custom js file link -->
<script src="js/script.js"></script>

<script>
    var swiper = new Swiper(".home-slider", {
        loop:true,
        grabCursor:true,    
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
    });

    var swiper = new Swiper(".category-slider", {
        loop:true,
        grabCursor:true,    
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
    breakpoints: {
        650: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 4,
        },
      },
    });

    var swiper = new Swiper(".products-slider", {
        loop:true,
        grabCursor:true,    
        pagination: {
            el: ".swiper-pagination",
        },
    breakpoints: {
        650: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
</script>
</body>
</html>