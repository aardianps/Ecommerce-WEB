<?php

include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
    $update_profile_name->execute([$name, $admin_id]);

    $emptypass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prevpass = $_POST['prevpass'];
    $oldpass = sha1($_POST['oldpass']);
    $oldpass = filter_var($oldpass, FILTER_SANITIZE_STRING);
    $newpass = sha1($_POST['newpass']);
    $newpass = filter_var($newpass, FILTER_SANITIZE_STRING);
    $confirmpass = sha1($_POST['confirmpass']);
    $confirmpass = filter_var($confirmpass, FILTER_SANITIZE_STRING);

    if($oldpass == $emptypass){
        $message[] = 'Please enter your old password!';
    }elseif($oldpass != $prevpass){
        $message[] = 'Old password not matched!';
    }elseif($newpass != $confirmpass){
        $message[] = 'Confirm your password again!';
    }else{
        if($newpass != $emptypass){
            $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_admin_pass->execute([$confirmpass, $admin_id]);
            $message[] = 'Password updated successfully!';
        }else{
            $message[] = 'Please enter the new password!';
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
    <title>Profile Update</title>

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
<!-- profile update section start -->
<section class="form-container">
    <form action="" method="post">
        <h3>Update your Profile</h3>
        <input type="hidden" name="prevpass" value="<?= $fetch_profile['password'];?>">
        <input type="text" name="name" maxlength="20" style="text-align: center;" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?=$fetch_profile['name'];?>">
            <br>
        <input type="password" name="oldpass" maxlength="20" style="text-align: center;" placeholder="enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <br>
        <input type="password" name="newpass" maxlength="20" style="text-align: center;" placeholder="enter your new password" class="box"  oninput="this.value = this.value.replace(/\s/g, '')">
            <br>
        <input type="password" name="confirmpass" maxlength="20" style="text-align: center;" placeholder="confirm your new password" class="box"  oninput="this.value = this.value.replace(/\s/g, '')">
            <br>
        <input type="submit" value="Update Profile" name="submit" class="btn">
</section>
<!-- profile update section ends -->

<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>