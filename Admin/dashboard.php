<?php
include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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

<?php include '../Components/admin_head.php' ?>

<!-- admin dashboard section starts -->
<section class="dashboard">

    <h1 class="heading">Dashboard</h1>

    <div class="box-container">

        <div class="box">
            <h3>Welcome!</h3>
            <p><?= $fetch_profile['name'];?></p>
            <a href="update_profile.php" class="btn">Update Profile</a>
        </div>

        <div class="box">
            <?php
                $total_pendings = 0;
                $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_pendings->execute(['pending']);
                while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                    $total_pendings  += $fetch_pendings['total_price'];
                }
            ?>
            <h3><span>Rp</span><?= $total_pendings;?><span>/-</span></h3>
            <p>Total Pendings</p>
            <a href="placed_orders.php" class="btn">See Orders</a>
        </div>

        <div class="box">
            <?php
                $total_completes = 0;
                $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_completes->execute(['completed']);
                while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                    $total_completes  += $fetch_completes['total_price'];
                }
            ?>
            <h3><span>Rp</span><?= $total_completes;?><span>/-</span></h3>
            <p>Total Completes</p>
            <a href="placed_orders.php" class="btn">See Orders</a>
        </div>

        <div class="box">
                <?php 
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();
                    $numbers_of_orders = $select_orders->rowCount()
                ?>
                <h3><?= $numbers_of_orders; ?></h3>
                <p>Total Orders</p>
                <a href="placed_orders.php" class="btn">See Orders</a>
        </div>

        <div class="box">
                <?php 
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    $numbers_of_products = $select_products->rowCount()
                ?>
                <h3><?= $numbers_of_products; ?></h3>
                <p>Products</p>
                <a href="products.php" class="btn">See Products</a>
        </div>
        
        <div class="box">
                <?php 
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    $numbers_of_users = $select_users->rowCount()
                ?>
                <h3><?= $numbers_of_users; ?></h3>
                <p>Users Accounts</p>
                <a href="users_acc.php" class="btn">See Users</a>
        </div>

        <div class="box">
                <?php 
                    $select_admins = $conn->prepare("SELECT * FROM `admins`");
                    $select_admins->execute();
                    $numbers_of_admins = $select_admins->rowCount()
                ?>
                <h3><?= $numbers_of_admins; ?></h3>
                <p>Admins Accounts</p>
                <a href="admin_acc.php" class="btn">See Admins</a>
        </div>

        <div class="box">
                <?php 
                    $select_messages = $conn->prepare("SELECT * FROM `messages`");
                    $select_messages->execute();
                    $numbers_of_messages = $select_messages->rowCount()
                ?>
                <h3><?= $numbers_of_messages; ?></h3>
                <p>Messages</p>
                <a href="messages.php" class="btn">See Messages</a>
        </div>

    </div>    

</section>
<!-- admin dashboard section ends -->



<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>