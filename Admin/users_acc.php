<?php
include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_users = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_users->execute([$delete_id]);
    $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
    $delete_orders->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist->execute([$delete_id]);
    $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_messages->execute([$delete_id]);

    header('location:users_acc.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Accounts</title>

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
<?php include'../Components/admin_head.php'?>
<!-- users accounts section starts -->
<section class="accounts">
    <h1 class="heading">Users Accounts</h1>
    <div class="box-container">
        <?php 
            $select_account = $conn->prepare("SELECT * FROM `users`");
            $select_account->execute();
            if($select_account->rowCount() > 0){
                while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p> User id : <span><?=$fetch_accounts['id'];?></span></p>
            <p> Username : <span><?=$fetch_accounts['name'];?></span></p>
            <a href="users_acc.php?delete=<?=$fetch_accounts['id'];?>" class="delete-btn" onclick="return confirm('Delete this account ?')">Delete</a>
        </div>
        <?php 
                }
                }else{
                    echo'<p class="empty">No accounts registered</p>';
                }
        ?>
        
    </div>
</section>
<!-- users accounts section ends -->
<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>