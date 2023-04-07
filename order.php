<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('koneksi.php');
$db = new DB();
$conn = $db->connect();

if (isset($_SESSION['login_user_id'])) {
    $user_id = $_SESSION['login_user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>

<body>
    <?php
    $email = '';
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
    ?>
    <h1>Verifikasi Order</h1>
    <?php
    // tangkap data dari form
    $product_id = '';
    $product_name = '';
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $sql = "SELECT * FROM tbl_product WHERE id = '$product_id'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_name = $row['product_name'];
            }
        }
    }
    $server_id = '';
    $server_name = '';
    if (isset($_POST['server_id'])) {
        $server_id = $_POST['server_id'];
        $sql = "SELECT * FROM tbl_server WHERE id = '$server_id'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $server_name = $row['server_name'];
            }
        }
    }
    $grup_id = '';
    $grup_name = '';
    if (isset($_POST['server_id'])) {
        $grup_id = $_POST['grup_id'];
        $sql = "SELECT * FROM tbl_grup WHERE id = '$grup_id'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $grup_name = $row['grup_name'];
            }
        }
    }

    $price = '';
    if (!empty($product_id) && !empty($server_id) && !empty($grup_id)) {
        $sql = "SELECT * FROM tbl_price WHERE product_id = '$product_id' AND server_id = '$server_id' AND grup_id = '$grup_id'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row['price'];
            }
        }
    }

    $qty = '';
    $grandtotal = 0;
    if (isset($_POST['qty'])) {
        $qty = $_POST['qty'];
        if (!empty($qty) && !empty($price)) {
            $grandtotal = $qty * $price;
        }
    }
    ?>
    <div>
        <table border="0" width="100%">
            <tr>
                <td width="100px">Email Order</td>
                <td>:</td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td>Produk</td>
                <td width="5px">:</td>
                <td><?php echo $product_name; ?></td>
            </tr>
            <tr>
                <td>Server</td>
                <td>:</td>
                <td><?php echo $server_name; ?></td>
            </tr>
            <tr>
                <td>Grup</td>
                <td>:</td>
                <td><?php echo $grup_name; ?></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($price); ?> /1k gold</td>
            </tr>
            <tr>
                <td>Jumlah Order</td>
                <td>:</td>
                <td><?php echo $qty; ?>k</td>
            </tr>
            <tr>
                <td>Grandtotal</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($grandtotal); ?></td>
            </tr>
        </table>
        <br />
        <div>
            <input type="submit" value="Create Order" /> | 
            <a href="dashboard.php">Ulangi pesanan
        </div>
</body>

</html>