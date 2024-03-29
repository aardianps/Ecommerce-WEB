<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">
    <section class="flex">

        <strong><a href="dashboard.php" class="logo">Admin<span>Panel</span></a></strong>

        <nav class="navbar">
            <a href="dashboard.php">Home</a>
            <a href="products.php">Products</a>
            <a href="placed_orders.php">Orders Placed</a>
            <a href="admin_acc.php">Admins</a>
            <a href="users_acc.php">Users</a>
            <a href="messages.php">Messages</a>
        </nav>
        
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        
        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
                $select_profile->execute([$admin_id]);
                $fetch_profile = @$select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= $fetch_profile['name']; ?></p>
            <a href="update_profile.php" class="btn">Update Profile</a>
            <div class="flex-btn">
                <a href="admin_login.php" class="option-btn">Login</a>
                <a href="admin_reg.php" class="option-btn">Register</a>
            </div>
            <a href="../Components/admin_logout.php" onclick="return confirm('Are you sure want to LogOut ?')" class="delete-btn">Logout</a>
        </div>
    
    </section>
</header>