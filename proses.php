<?php
    include 'koneksi.php';
    session_start();
    
    $username = $_POST['username']; 
    $password = md5($_POST['password']);

    $query = "SELECT username, password from users WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) >0){
        $_SESSION["name"] = $_POST['username'];
        $_SESSION["username"] = true;
        // var_dump($_SESSION);
        header("Location: layouts/home.php");

    }else{
        header("Location: login.php");
    }  
?>