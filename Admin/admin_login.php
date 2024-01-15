<?php
include '../Components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $user_name = $_POST['name'];
    $user_password = filter_var($user_name, FILTER_SANITIZE_STRING);
    $user_password = sha1($_POST['pass']);
    $user_password = filter_var($user_password, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin->execute([$user_name, $user_password]);
    

    if($select_admin->rowCount() > 0){
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id']=$fetch_admin_id['id'];
        header('location:dashboard.php');
    }else{
        $message[]='incorrect username or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- css custom -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


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

    <!-- admin login form section starts -->
    <section class="form-container">
        <form action="" method="post">
            <h3>Login Now</h3>
            <p>Default username = <span>admin</span> <br> Default password = <span>admin</span></p>
                <input type="text" name="name" maxlength="20" style="text-align: center;" 
                    required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                    <br>
                <input type="password" name="pass" maxlength="20" style="text-align: center;" 
                    required placeholder="enter your password" class="box"  oninput="this.value = this.value.replace(/\s/g, '')">
                    <br>
                <input type="submit" value="Login now" name="submit" class="btn">
        </form>
    </section>
    <!-- admin login form section ends -->
</body>
</html>