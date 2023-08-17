<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  // Jika pengguna belum login atau bukan admin, redirect ke halaman login
  header("Location: index.php");
  exit();
}

// Menggunakan koneksi ke database
include 'koneksi.php';

// Pengaturan pagination
$results_per_page = 5; // Jumlah data per halaman
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
$start_index = ($current_page - 1) * $results_per_page; // Indeks awal data

// Query untuk mendapatkan data peminjaman dengan informasi buku dan anggota
$query = "SELECT peminjaman.id, buku.judul, anggota.nama, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali
          FROM peminjaman
          INNER JOIN buku ON peminjaman.id_buku = buku.id
          INNER JOIN anggota ON peminjaman.id_anggota = anggota.id
          LIMIT $start_index, $results_per_page";

$result = mysqli_query($conn, $query);

// Query untuk menghitung jumlah total data peminjaman
$total_results = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman");
$total_results = mysqli_fetch_assoc($total_results)['total'];

$total_pages = ceil($total_results / $results_per_page); // Jumlah total halaman

include 'header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Data Peminjaman</h1>

    <!-- Form pencarian -->
    <form action="data_peminjam.php" method="GET" class="mb-3 mt-5">
      <div class="field has-addons">
        <div class="control">
          <input class="input" type="text" name="search" placeholder="Cari judul buku atau nama anggota">
        </div>
        <div class="control">
          <button class="button is-info" type="submit">Cari</button>
        </div>
      </div>
    </form>

    <?php
    // Periksa apakah ada data peminjaman
    if (mysqli_num_rows($result) > 0) {
      echo '<table class="table is-striped is-fullwidth">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>ID</th>';
      echo '<th>Judul Buku</th>';
      echo '<th>Nama Anggota</th>';
      echo '<th>Tanggal Pinjam</th>';
      echo '<th>Tanggal Kembali</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Tampilkan data peminjaman
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['judul'] . '</td>';
        echo '<td>' . $row['nama'] . '</td>';
        echo '<td>' . $row['tanggal_pinjam'] . '</td>';
        echo '<td>' . $row['tanggal_kembali'] . '</td>';
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';

      // Navigasi halaman
      echo '<nav class="pagination is-centered" role="navigation" aria-label="pagination">';
      echo '<ul class="pagination-list">';
      for ($page = 1; $page <= $total_pages; $page++) {
        echo '<li>';
        echo '<a href="data_peminjaman.php?page=' . $page . '" class="pagination-link ' . ($page === $current_page ? 'is-current' : '') . '">' . $page . '</a>';
        echo '</li>';
      }
      echo '</ul>';
      echo '</nav>';
    } else {
      // Jika tidak ada data peminjaman
      echo '<p>Tidak ada data peminjaman.</p>';
    }
    ?>
  </div>
</section>
