<?php
include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['update'])){

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $pid]);

    $message[] = 'Your product has been updated!';

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;

    if(!empty($image_01)){
        if($image_size_01 > 5000000){
            $message[] = 'Image size is too large!';
        }else{
            $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            unlink('../uploaded_img/'.$old_image_01);
            $message[] = 'First image updated!';
        }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;

    if(!empty($image_02)){
        if($image_size_02 > 5000000){
            $message[] = 'Image size is too large!';
        }else{
            $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            unlink('../uploaded_img/'.$old_image_02);
            $message[] = 'Second image updated!';
        }
    }
    
    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/'.$image_03;

    if(!empty($image_03)){
        if($image_size_03 > 5000000){
            $message[] = 'Image size is too large!';
        }else{
            $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            unlink('../uploaded_img/'.$old_image_03);
            $message[] = 'Third image updated!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- css custom -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include'../Components/admin_head.php' ?>
<!-- update products section starts -->
<section class="update-product">

        <h1 class="heading">Update Product</h1>

        <?php
            $update_id = $_GET['update']; 
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$update_id]);
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?=$fetch_products['id'];?>">        
            <input type="hidden" name="old_image_01" value="<?=$fetch_products['image_01'];?>">
            <input type="hidden" name="old_image_02" value="<?=$fetch_products['image_02'];?>">
            <input type="hidden" name="old_image_03" value="<?=$fetch_products['image_03'];?>">

            <div class="image-container">
                <div class="main-image">
                    <img src="../uploaded_img/<?=$fetch_products['image_01'];?>" alt="">
                </div>
                <div class="sub-images">
                    <img src="../uploaded_img/<?=$fetch_products['image_01'];?>" alt="">
                    <img src="../uploaded_img/<?=$fetch_products['image_02'];?>" alt="">
                    <img src="../uploaded_img/<?=$fetch_products['image_03'];?>" alt="">
                </div>
            </div>
            <span>Update Name</span>
                <input type="text" name="name" maxlength="1000" required placeholder="enter product name" class="box" value="<?=$fetch_products['name'];?>">
            <span>Update Price</span>
                <input type="number" name="price" maxlength="1000000" min="0" max="999999999" required placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;"  class="box" value="<?=$fetch_products['price'];?>">
            <span>Update Details</span>
                <textarea name="details" class="box" placeholder="enter product details" required maxlength="1000" cols="30" rows="10"><?=$fetch_products['details'];?></textarea>
            <span>Update first image</span>
                <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <span>Update second image</span>
                <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <span>Update third image</span>
                <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <div class="flex-btn">
                <input type="submit" value="update" class="btn" name="update">
                <a href="products.php" class="option-btn">Go Back</a>
            </div>
        </form>
        <?php 
            }
        }else{
            echo '<p class="empty">No Products added!</p>';
        }
        ?>

</section>
<!-- update products section ends -->


<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>