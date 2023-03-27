<?php
// memulai session
session_start();

// menghapus semua variabel session
session_unset();

// berhenti session
session_destroy();

// redirect ke halaman login
header("location: login.php");