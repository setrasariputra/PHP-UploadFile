<?php
class Db {
    function connect()
    {
        // konfigurasi database
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'monsgold';

        $conn = mysqli_connect($host, $user, $password, $database);

        return $conn;
    }
}