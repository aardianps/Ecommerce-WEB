<?php 
include'Components/connect.php';
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    }else{
        $message[] = 'Incorrect email or password!';
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include'Components/user_header.php';?>

<!-- user login section starts -->
<section class="form-container">

    <form action="" method="POST">
    
        <h3>Login Now</h3>
        <input type="email" name="email" maxlength="50" placeholder="enter your email" class="box" oninput="this.value = this.value.replace(/\s/g, '')"  required>
        <input type="password" name="pass" maxlength="20" placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')"  required>
        <input type="submit" value="Login now" class="btn" name="submit">
        <p>Don't have an account ?</p>
        <a href="user_register.php" class="option-btn">Register now</a>

    </form>
</section>
<!-- user login section ends -->









<?php include'Components/footer.php';?>
<!-- custom js file link -->
<script src="js/script.js"></script>
</body>
</html>