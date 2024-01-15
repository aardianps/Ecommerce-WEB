<?php
include '../Components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['submit'])){

    $user_name = $_POST['name'];
    $user_password = filter_var($user_name, FILTER_SANITIZE_STRING);
    $user_password = sha1($_POST['pass']);
    $user_password = filter_var($user_password, FILTER_SANITIZE_STRING);
    $cuser_password = sha1($_POST['cpass']);
    $cuser_password = filter_var($cuser_password, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
    $select_admin->execute([$user_name]);
    

    if($select_admin->rowCount() > 0){
        $message[] = 'Username already exists!';
    }else{
        if($user_password != $cuser_password){
            $message[] = 'Your password not matched!';
        }else{
            $insert_admin = $conn->prepare("INSERT INTO `admins` (name, password) VALUES(?,?)");
            $insert_admin->execute([$user_name,$cuser_password]);
            $message[] = 'New Admin Registered!';
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
    <title>Admin Registration</title>

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

    <!-- admin registration section start -->
    <section class="form-container">
        <form action="" method="post">
            <h3>Register</h3>
                <input type="text" name="name" maxlength="20" style="text-align: center;" 
                    required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                    <br>
                <input type="password" name="pass" maxlength="20" style="text-align: center;" 
                    required placeholder="enter your password" class="box"  oninput="this.value = this.value.replace(/\s/g, '')">
                    <br>
                <input type="password" name="cpass" maxlength="20" style="text-align: center;" 
                    required placeholder="confirm your password" class="box"  oninput="this.value = this.value.replace(/\s/g, '')">
                    <br>

                <input type="submit" value="Register" name="submit" class="btn">
        </form>
    </section>
    <!-- admin registration section ends -->

<!-- custom js file -->
<script src="../js/admin_script.js"></script>

</body>
</html>