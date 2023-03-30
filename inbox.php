<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('koneksi.php');
$db = new DB();
$conn = $db->connect();

$user_id = $_SESSION['login_user_id'];

$sql = "SELECT * FROM tbl_messages WHERE destination_user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

$num = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
</head>

<body>
    <h1>INBOX (<?php echo $num;?>)</h1>
    <?php
    if ($num > 0) {
        ?><ul><?php
        while($row = mysqli_fetch_assoc($result)) {
            ?><li>
                <?php
                    if($row['view'] == 1) {
                        ?><b><?php echo $row['message'];?></b><?php
                    }else{
                        echo $row['message'];
                    }
                ?>
            </li><?php
        }
    }
    ?>
</body>

</html>