<?php
include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
    $delete_admin->execute([$delete_id]);
    header('location:admin_acc.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts</title>

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

<!-- admins accounts section starts -->
<section class="accounts">
    <h1 class="heading">Admins Accounts</h1>
    <div class="box-container">
    <div class="box">
        <p>Register new admin</p>
        <a href="admin_reg.php" class="option-btn">Register</a>
    </div>
        <?php 
            $select_account = $conn->prepare("SELECT * FROM `admins`");
            $select_account->execute();
            if($select_account->rowCount() > 0){
                while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p> Admin id : <span><?=$fetch_accounts['id'];?></span></p>
            <p> Username : <span><?=$fetch_accounts['name'];?></span></p>
            <div class="flex-btn">
            <?php 
                if($fetch_accounts['id'] == $admin_id){
                    echo '<a href="update_profile.php" class="option-btn">Update</a>';
                }
            ?>
                <a href="admin_acc.php?delete=<?=$fetch_accounts['id'];?>" class="delete-btn" onclick="return confirm('Delete this account ?')">Delete</a>
            
            </div>
        </div>
        <?php 
                }
                }else{
                    echo'<p class="empty">No accounts registered</p>';
                }
        ?>
        
    </div>
</section>
<!-- admins accounts section ends -->



<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>