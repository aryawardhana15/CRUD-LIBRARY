<?php
$host = "localhost";
$username = "root";
$password = "hafiz1180";
$database = "crudproject";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>