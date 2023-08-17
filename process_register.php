<?php
// Menggunakan koneksi ke database
include 'koneksi.php';

// Memeriksa apakah form registrasi telah dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data yang dikirimkan melalui form
  $username = $_POST['username'];
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $email = $_POST['email'];
  $role = 'member'; // Memaksa role menjadi "member"

  // Query untuk memeriksa keberadaan pengguna dengan username yang sama
  $query = "SELECT * FROM anggota WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  // Memeriksa apakah username sudah digunakan
  if (mysqli_num_rows($result) > 0) {
    // Username sudah digunakan, redirect kembali ke halaman registrasi dengan pesan error
    header("Location: register.php?error=username_exists");
    exit();
  } else {
    // Username belum digunakan, insert data registrasi pengguna ke dalam tabel anggota
    $insertQuery = "INSERT INTO anggota (username, password, nama, alamat, email, role) VALUES ('$username', '$hashedPassword', '$nama', '$alamat', '$email', '$role')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
      // Registrasi berhasil, redirect ke halaman login dengan pesan sukses
      header("Location: index.php?success=registration_completed");
      exit();
    } else {
      // Registrasi gagal, redirect kembali ke halaman registrasi dengan pesan error
      header("Location: register.php?error=registration_failed");
      exit();
    }
  }
} else {
  // Jika form registrasi tidak dikirimkan, redirect kembali ke halaman registrasi
  header("Location: register.php");
  exit();
}
?>
