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


include('create_order.php');

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
    <hr />
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

    <hr />


    <h2>Order Produk</h2>
    <?php
    $sql = "SELECT * FROM tbl_product";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
    ?><ul><?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?><li><a href="dashboard.php?product_id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a></li><?php
                        }
                         ?></ul>
        <br /><br />
        <?php
        $product_id = '';
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
        }
        ?>
        <div>
        <label>Pilih Produk</label>
        <select id="select-product">
            <option value="">..Pilih Product..</option>
            <?php
            $sql2 = "SELECT * FROM tbl_product";
            $result2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $selected = '';
                if($row2['id'] == $product_id) {
                    $selected = 'selected';
                }
                ?>
                <option value="<?php echo $row2['id']; ?>" <?php echo $selected;?>><?php echo $row2['product_name']; ?></option>
                <?php
            }
            ?>
        </select>
        </div>
        <?php

        // check product_id
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            if (!empty($product_id)) {
        ?>
                <form method="POST" action="order.php">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                    <table border="0" width="100%">
                    <?php
                    // show server
                    $sql = "SELECT * FROM tbl_server WHERE product_id = '$product_id'";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    if ($num > 0) {
                    ?>
                        <tr>
                            <td width="100px">Pilih Server</td>
                            <td width="5px">:</td>
                            <td>
                            <select name="server_id"><?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['server_name']; ?></option>
                                <?php
                                                    }
                                ?>
                            </select>
                        </td>
                        </tr>
                    <?php
                    }

                    // show group
                    $sql = "SELECT * FROM tbl_grup WHERE product_id = '$product_id'";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    if ($num > 0) {
                    ?>
                        <tr>
                            <td>Pilih Grup</td>
                            <td>:</td>
                            <td>
                            <select name="grup_id"><?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['grup_name']; ?></option>
                                <?php
                                                }
                                ?>
                            </select>
                                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Pesanan</td>
                            <td>:</td>
                            <td>
                            <input type="number" name="qty" min="1" style="width:50px;" /> k
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3">
                            <input type="submit" name="order" value="Request Order"></td>
                    </tr>
                    </table>
                </form>
    <?php
            }
        }else{
            ?>
            <div>
                <label>Pilih Server</label>
                <select disabled>
                    <option>...............</option>
                </select>
            </div>
            <div>
                <label>Pilih Grup</label>
                <select disabled>
                    <option>...............</option>
                </select>
            </div>
            <?php
        }
    }
    ?>


<script>
    const selectProduct = document.querySelector("#select-product");
    selectProduct.addEventListener("change", function() {
        const selectValue = selectProduct.value;
        let redirectURL = "dashboard.php";
        if(selectValue != '') {
            redirectURL = "dashboard.php?product_id="+selectValue;
        }

        window.location.href = redirectURL;
    });
</script>
</body>

</html>