<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_FILES['image'])) {
    // execution upload image
    // ambil dari data session
    $user_id = $_SESSION['login_user_id'];

    // check insert or update
    $sql = "SELECT * FROM tbl_profilepict WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);

    $action = 'insert';
    if ($num > 0) {
        $action = 'update';
    }


    // get file upload
    $file_name = $_FILES['image']['name'];
    $file_name = str_replace(' ', '_', $file_name);
    $file_name = time() . '-' . $file_name;

    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $expl = explode('.', $file_name);
    $file_ext = strtolower(end($expl));

    // validasi type
    $extensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $extensions) === false) {
        echo 'Extension not allowed, please choose a JPG, PNG file';
        exit();
    }

    // validasi size
    if ($file_size > 2000000) {
        echo 'File size must be less than 2 MB';
        exit();
    }

    // uploading file
    move_uploaded_file($file_tmp, "uploads/" . $file_name);

    // insert or update profilepict
    if ($action == 'insert') {
        $sql = "INSERT INTO tbl_profilepict (user_id, file_name, file_size, file_type) VALUES ('$user_id','$file_name','$file_size','$file_type')";
    } else
    if ($action == 'update') {
        $sql = "UPDATE tbl_profilepict SET file_name='$file_name', file_size='$file_size', file_type='$file_type' WHERE user_id='$user_id'";
    }

    if (mysqli_query($conn, $sql)) {
        
    } else {
        echo 'Error: ' . $sql . '<br />' . mysqli_error($conn);
    }
}
