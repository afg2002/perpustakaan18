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

  // Query untuk mengambil data admin berdasarkan id
  $query = "SELECT * FROM admin WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Jika data admin ditemukan, mengisi variabel dengan nilai dari database
    $row = mysqli_fetch_assoc($result);

    // Memeriksa apakah pengguna mencoba menghapus dirinya sendiri
    if ($id == $_SESSION['id']) {
      // Jika ya, redirect ke halaman data_admin.php dengan pesan error
      // echo '<script>alert("Tidak bisa menghapus diri sendiri.")</script>';
      header("Location: data_admin.php?error=delete_self");
      exit();
    }

    // Query untuk menghapus admin berdasarkan id
    $query = "DELETE FROM admin WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      // Jika berhasil menghapus admin, redirect ke halaman data_admin.php
      header("Location: data_admin.php");
      exit();
    } else {
      // Jika gagal menghapus admin, tampilkan pesan error
      $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
    }
  } else {
    // Jika data admin tidak ditemukan, redirect ke halaman data_admin.php
    header("Location: data_admin.php");
    exit();
  }
} else {
  // Jika parameter id tidak diberikan, redirect ke halaman data_admin.php
  header("Location: data_admin.php");
  exit();
}
?>
