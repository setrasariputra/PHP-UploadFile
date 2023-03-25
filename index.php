<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('koneksi.php');
$db = new DB();
$conn = $db->connect();

include('upload.php');

// view user profilepict
$user_id = 1;
// select userpict
$file_name = '';
$sql = "SELECT * FROM tbl_profilepict WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

$num = mysqli_num_rows($result);
if($num > 0) {
    while($row = mysqli_fetch_assoc($result)) {
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
    <?php
    if(!empty($file_name)) {
        ?>
        <img width="200px" src="uploads/<?php echo $file_name;?>" />
        <?php
    }
    ?>
    <br /><br />
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="Upload Image">
    </form>
</body>
</html>


<?php
mysqli_close($conn);