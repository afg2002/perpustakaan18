<?php

// Menggunakan koneksi ke database
include 'koneksi.php';
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
  // Jika pengguna belum login atau bukan anggota, redirect ke halaman login
  $response = array(
    'status' => 'error',
    'message' => 'Unauthorized access'
  );
  echo json_encode($response);
  exit();
}

// Memeriksa apakah parameter id buku dikirim melalui URL
if (!isset($_POST['id'])) {
  $response = array(
    'status' => 'error',
    'message' => 'Invalid request'
  );
  echo json_encode($response);
  exit();
}

// Mendapatkan ID buku dari parameter URL
$id_buku = $_POST['id'];

// Mendapatkan ID anggota dari sesi
$id_anggota = $_SESSION['id'];

// Query untuk memeriksa apakah buku dengan ID dan anggota tertentu sedang dipinjam
$query = "SELECT * FROM peminjaman WHERE id_buku = $id_buku AND id_anggota = $id_anggota";
$result = mysqli_query($conn, $query);

// Jika buku ditemukan
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);

  // Mendapatkan tanggal kembali dari data peminjaman
  $tanggal_kembali = $row['tanggal_kembali'];

  // Mendapatkan tanggal sekarang
  $tanggal_sekarang = date('Y-m-d');

  // Menghitung selisih hari antara tanggal kembali dengan tanggal sekarang
  $selisih_hari = strtotime($tanggal_sekarang) - strtotime($tanggal_kembali);
  $selisih_hari = floor($selisih_hari / (60 * 60 * 24));

  // Jika terlambat mengembalikan
  if ($selisih_hari > 0) {
    // Hitung denda
    $denda = $selisih_hari * 10000;

    // Tampilkan pesan terlambat mengembalikan dan denda
    $response = array(
      'status' => 'error',
      'message' => "Anda terlambat mengembalikan buku ini selama $selisih_hari hari. Denda yang harus dibayarkan: Rp$denda."
    );
    echo json_encode($response);
  } else {
    // Jika tepat waktu mengembalikan
    $response = array(
      'status' => 'success',
      'message' => 'Buku berhasil dikembalikan.'
    );
    echo json_encode($response);

    // Update stok buku di tabel buku
    $updateQuery = "UPDATE buku SET stok = stok + 1 WHERE id = $id_buku";
    mysqli_query($conn, $updateQuery);
  }

  // Hapus data peminjaman buku dari database
  $deleteQuery = "DELETE FROM peminjaman WHERE id_buku = $id_buku AND id_anggota = $id_anggota";
  mysqli_query($conn, $deleteQuery);
} else {
  // Jika buku tidak ditemukan
  $response = array(
    'status' => 'error',
    'message' => 'Buku tidak ditemukan.'
  );
  echo json_encode($response);
}

?>
