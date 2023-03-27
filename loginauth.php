<?php
session_start();
$error = '';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // validasi input kosong
    if(empty($email) || empty($password)) {
        $error = "Username atau password tidak valid";
    }

    // validasi sql injection
    $email = stripslashes($email);
    $password = stripslashes($password);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // md5 password
    $password = md5($password);

    // query untuk mencari user pada database 
    $query = "SELECT * FROM tbl_users WHERE email='$email' AND password='$password'";
    $result =  mysqli_query($conn, $query);

    $rows = mysqli_num_rows($result);
    if($rows == 1) {
        $user_id = '';
        while($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['id'];
        }

        // memulai session dan redirect ke halaman dashboard
        $_SESSION['login_user_email'] = $email;
        $_SESSION['login_user_id'] = $user_id;

        header("location: dashboard.php");
    }else{
        $error = "Username atau password tidak cocok.";
    }

}