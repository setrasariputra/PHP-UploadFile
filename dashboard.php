<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('koneksi.php');
$db = new DB();
$conn = $db->connect();

if (isset($_SESSION['login_user_email'])) {
    $email = $_SESSION['login_user_email'];
?>
    <p>Selamat datang, <b><?php echo $email; ?></b></p>
    <a href="logout.php">Logout</a>
<?php
} else {
?>
    <h3>Anda belum login, silahkan login dahulu</h3>
    <a href="login.php">Login</a>
<?php
    exit();
}


include('upload.php');

// view user profilepict
$user_id = $_SESSION['login_user_id'];
// select userpict
$file_name = '';
$sql = "SELECT * FROM tbl_profilepict WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $file_name = $row['file_name'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Profile Pict</title>
</head>

<body>
    <h1>Dashboard</h1>
    <h2>Profile Pict</h2>
    <?php
    if (!empty($file_name)) {
    ?>
        <img width="200px" src="uploads/<?php echo $file_name; ?>" />
    <?php
    }
    ?>
    <br /><br />
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="Upload Image">
    </form>
    <br /><br />
    <?php
    $display_total_inbox = "";

    // query messages
    $sql = "SELECT * FROM tbl_messages WHERE destination_user_id = '$user_id' AND view = '0'";
    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);
    $total_inbox = $num;

    if (!empty($total_inbox)) {
        $display_total_inbox = "(" . $total_inbox . ")";
    }
    ?>
    <h2>Messages</h2>
    <ul>
        <li><a href="inbox.php">INBOX <?php echo $display_total_inbox; ?></a></li>
        <li><a href="sent_message.php">SENT MESSAGES</a></li>
    </ul>
</body>

</html>