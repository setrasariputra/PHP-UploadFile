<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['order'])) {
    $user_id = $_SESSION['login_user_id'];
    $product = $_POST['product'];
    $server = $_POST['server'];
    $grup = $_POST['grup'];

    echo $product.' '.$server.' '.$grup;
}