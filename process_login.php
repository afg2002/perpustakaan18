<?php
session_start();

// Menggunakan koneksi ke database
include 'koneksi.php';

// Memeriksa apakah form login telah dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data yang dikirimkan melalui form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query untuk mendapatkan data pengguna berdasarkan username
  $query = "SELECT * FROM anggota WHERE username = '$username'";
  $result = mysqli_query($conn, $query);
  

  // Memeriksa apakah pengguna ditemukan
  if (mysqli_num_rows($result) > 0) {
    // Mendapatkan data pengguna dari hasil query
    $user = mysqli_fetch_assoc($result);

    // Memeriksa apakah password yang diinputkan cocok dengan password yang di-hash
    if (password_verify($password, $user['password'])) {
      // Password cocok, simpan informasi pengguna di session
      $_SESSION['username'] = $username;
      $_SESSION['id'] = $user['id'];
      $_SESSION['role'] = $user['role'];
      header('location:dashboard.php');
    }else{
      header("Location: index.php?error=invalid_credentials");
    }
  }else{
    // Pengguna tidak ditemukan atau password tidak cocok, redirect kembali ke halaman login dengan pesan error
    header("Location: index.php?error=invalid_credentials");
  }

  exit();
} else {
  // Jika form login tidak dikirimkan, redirect kembali ke halaman login
  header("Location: index.php");
  exit();
}
?>
