<?php
$server = "localhost"; // Ganti "nama_host_database" dengan nama host database Anda
$username = "root"; // Ganti "nama_pengguna" dengan nama pengguna database Anda
$password = ""; // Ganti "kata_sandi" dengan kata sandi database Anda
$database = "perpus18"; // Ganti "perpus18" dengan nama database Anda

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
