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

  // Query untuk mengambil data anggota berdasarkan id
  $query = "SELECT * FROM anggota WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Jika data anggota ditemukan, mengisi variabel dengan nilai dari database
    $row = mysqli_fetch_assoc($result);
    $nama = $row['nama'];

    // Memeriksa apakah pengguna mencoba menghapus dirinya sendiri
    if ($id == $_SESSION['id']) {
      // Jika ya, redirect ke halaman data_anggota.php dengan pesan error
      // echo '<script>alert("Tidak bisa menghapus diri sendiri.")</script>';
      header("Location: data_anggota.php?error=delete_self");
      exit();
    }

    // Query untuk menghapus anggota berdasarkan id
    $query = "DELETE FROM anggota WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      // Jika berhasil menghapus anggota, redirect ke halaman data_anggota.php
      header("Location: data_anggota.php");
      exit();
    } else {
      // Jika gagal menghapus anggota, tampilkan pesan error
      $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
    }
  } else {
    // Jika data anggota tidak ditemukan, redirect ke halaman data_anggota.php
    header("Location: data_anggota.php");
    exit();
  }
} else {
  // Jika parameter id tidak diberikan, redirect ke halaman data_anggota.php
  header("Location: data_anggota.php");
  exit();
}
?>
