<?php 
include '../Components/connect.php';

session_start();
session_unset();
session_destroy();

header('location:../Admin/admin_login.php');
?>