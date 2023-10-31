<?php
$hostname = "localhost"; // Ganti dengan nama host MySQL Anda
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$database = "hillchiper"; // Ganti dengan nama database Anda

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
