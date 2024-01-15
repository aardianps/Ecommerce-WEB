<?php
include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messages .php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

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
<!-- messages section starts -->
<section class="messages">
    <h1 class="heading">Messages</h1>
    <div class="box-container">
        <?php 
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            if($select_messages->rowCount() > 0){
                while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <p> User id: <span><?=$fetch_messages['user_id'];?></span> </p>
            <p> Name: <span><?=$fetch_messages['name'];?></span> </p>
            <p> Number: <span><?=$fetch_messages['number'];?></span> </p>
            <p> Email: <span><?=$fetch_messages['email'];?></span> </p>
            <p> Messages: <span><?=$fetch_messages['message'];?></span> </p>
            <a href="messages.php?delete=<?=$fetch_messages['id'];?>" class="delete-btn" onclick="return confirm('Delete this message ?')">Delete</a>

        </div>
        <?php 
                }
            }else{
                echo '<p class="empty">You have no messages</p>';
            }
        ?>
    </div>
</section>
<!-- messages section starts -->

<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>