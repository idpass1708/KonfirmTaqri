<?php
$host = "localhost";
$user = "root";  // Ubah jika berbeda
$password = "";  // Sesuaikan dengan password MySQL
$database = "taqri_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
