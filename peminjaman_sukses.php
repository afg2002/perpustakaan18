<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
  // Jika pengguna belum login atau bukan anggota, redirect ke halaman login
  header("Location: index.php");
  exit();
}

// Memeriksa apakah parameter id peminjaman telah diberikan
if (!isset($_GET['id'])) {
  header("Location: dashboard.php");
  exit();
}

// Menggunakan koneksi ke database
include 'koneksi.php';

// Mengambil informasi peminjaman berdasarkan id
$id_peminjaman = $_GET['id'];
$query = "SELECT * FROM peminjaman WHERE id = $id_peminjaman";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  header("Location: dashboard.php");
  exit();
}

$data_peminjaman = mysqli_fetch_assoc($result);

// Mengambil informasi buku yang dipinjam
$id_buku = $data_peminjaman['id_buku'];
$query_buku = "SELECT * FROM buku WHERE id = $id_buku";
$result_buku = mysqli_query($conn, $query_buku);

if (!$result_buku || mysqli_num_rows($result_buku) === 0) {
  header("Location: dashboard.php");
  exit();
}

$data_buku = mysqli_fetch_assoc($result_buku);
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Peminjaman Sukses</h1>

    <div class="content">
      <p>Anda telah berhasil melakukan peminjaman buku. Berikut adalah detail peminjaman:</p>

      <h2 class="subtitle">Informasi Buku</h2>
      <ul>
        <li>Judul: <?php echo $data_buku['judul']; ?></li>
        <li>Penulis: <?php echo $data_buku['penulis']; ?></li>
        <li>Penerbit: <?php echo $data_buku['penerbit']; ?></li>
        <li>Tahun Terbit: <?php echo $data_buku['tahun_terbit']; ?></li>
      </ul>

      <h2 class="subtitle">Informasi Peminjaman</h2>
      <ul>
        <li>Tanggal Pinjam: <?php echo $data_peminjaman['tanggal_pinjam']; ?></li>
        <li>Tanggal Pengembalian: <?php echo $data_peminjaman['tanggal_kembali']; ?></li>
      </ul>
    </div>

    <a class="button is-primary" href="dashboard.php">Kembali ke Dashboard</a>
  </div>
</section>

