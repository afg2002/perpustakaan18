<?php
// Menggunakan koneksi ke database
include 'koneksi.php';
session_start();

// Memeriksa apakah pengguna memiliki peran admin
if ($_SESSION['role'] != 'admin') {
  // Jika bukan admin, redirect ke halaman lain atau tampilkan pesan error
  header("Location: index.php?error=unauthorized");
  exit();
}

// Memeriksa apakah parameter id telah diberikan
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Query untuk menghapus buku berdasarkan id
  $query = "DELETE FROM buku WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Jika berhasil menghapus buku, redirect ke halaman data_buku.php
    header("Location: data_buku.php");
    exit();
  } else {
    // Jika gagal menghapus buku, tampilkan pesan error
    $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
  }
} else {
  // Jika parameter id tidak diberikan, redirect ke halaman data_buku.php
  header("Location: data_buku.php");
  exit();
}
?>
