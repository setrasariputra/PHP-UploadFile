<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('koneksi.php');
$db = new Db();
$conn = $db->connect();

include('loginauth.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h4><?php echo $error;?></h4>
    <form method="POST" action="">
        <div>
            <label>Username</label>
            <input type="email" name="email" />
        </div>
        <div>
            <label>password</label>
            <input type="password" name="password" />
        </div>
        <div>
            <input type="submit" name="submit" value="Login" />
        </div>
    </form>
</body>
</html>

<?php
mysqli_close($conn);