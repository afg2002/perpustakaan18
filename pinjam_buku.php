<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
  // Jika pengguna belum login atau bukan anggota, redirect ke halaman login
  header("Location: index.php");
  exit();
}

// Memeriksa apakah parameter bookId telah diberikan
if (!isset($_POST['bookId'])) {
  header("Location: dashboard.php");
  exit();
}

// Mengambil informasi buku yang akan dipinjam berdasarkan bookId
$bookId = $_POST['bookId'];

// Menggunakan koneksi ke database
include 'koneksi.php';

// Memeriksa apakah pengguna telah meminjam buku yang sama sebelumnya
$id_anggota = $_SESSION['id'];
$query_check_peminjaman = "SELECT * FROM peminjaman WHERE id_buku = $bookId AND id_anggota = $id_anggota";
$result_check_peminjaman = mysqli_query($conn, $query_check_peminjaman);

if (mysqli_num_rows($result_check_peminjaman) > 0) {
  // Jika pengguna telah meminjam buku yang sama sebelumnya, kembalikan respons error
  $response = array(
    'success' => false,
    'message' => 'Anda telah meminjam buku ini sebelumnya.'
  );

  // Mengembalikan respons dalam format JSON
  header('Content-Type: application/json');
  echo json_encode($response);
  exit();
}

// Query untuk mengambil informasi buku
$query = "SELECT * FROM buku WHERE id = $bookId";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  header("Location: dashboard.php");
  exit();
}

$data_buku = mysqli_fetch_assoc($result);
$currentStock = $data_buku['stok'];

// Menentukan tanggal pinjam
$tanggal_pinjam = date('Y-m-d');

// Menentukan tanggal pengembalian (7 hari setelah tanggal pinjam)
$tanggal_pengembalian = date('Y-m-d', strtotime($tanggal_pinjam . ' + 0 days'));

// Query untuk melakukan peminjaman buku
$query_pinjam = "INSERT INTO peminjaman (id_buku, id_anggota, tanggal_pinjam, tanggal_kembali) VALUES ($bookId, $id_anggota, '$tanggal_pinjam', '$tanggal_pengembalian')";
$result_pinjam = mysqli_query($conn, $query_pinjam);

if ($result_pinjam) {
  // Mengambil ID peminjaman yang baru di-insert
  $peminjamanId = mysqli_insert_id($conn);

  // Peminjaman buku berhasil
  // Mengupdate stok buku
  $newStock = $currentStock - 1;
  $query_update_stok = "UPDATE buku SET stok = $newStock WHERE id = $bookId";
  $result_update_stok = mysqli_query($conn, $query_update_stok);

  if ($result_update_stok) {
    $response = array(
      'success' => true,
      'message' => 'Peminjaman buku berhasil.',
      'newStock' => $newStock,
      'peminjamanId' => $peminjamanId
    );
  } else {
    $response = array(
      'success' => false,
      'message' => 'Peminjaman buku berhasil, tetapi gagal mengupdate stok buku.',
      'peminjamanId' => $peminjamanId
    );
  }
} else {
  // Peminjaman buku gagal
  $response = array(
    'success' => false,
    'message' => 'Peminjaman buku gagal.' . mysqli_error($conn),
    'peminjamanId' => null
  );
}

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
