<?php
// Menggunakan koneksi ke database
include 'koneksi.php';
session_start();
// Memeriksa apakah parameter ID buku telah diberikan
if (isset($_GET['id'])) {
  // Mengambil ID buku dari parameter
  $id = $_GET['id'];

  // Query untuk mengambil data buku berdasarkan ID
  $query = "SELECT * FROM buku WHERE id = $id";
  $result = mysqli_query($conn, $query);

  // Memeriksa apakah buku ditemukan
  if (mysqli_num_rows($result) > 0) {
    // Mengambil data buku
    $row = mysqli_fetch_assoc($result);
    $judul = $row['judul'];
    $penulis = $row['penulis'];
    $penerbit = $row['penerbit'];
    $tahun_terbit = $row['tahun_terbit'];
    $sinopsis = $row['sinopsis'];
    $stok = $row['stok'];
  } else {
    // Jika buku tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
    header("Location: index.php?error=buku_not_found");
    exit();
  }
} else {
  // Jika parameter ID buku tidak diberikan, redirect ke halaman lain atau tampilkan pesan error
  header("Location: index.php?error=invalid_request");
  exit();
}
?>

<?php include 'header.php' ?>

<section class="section">
  <div class="container">
    <h1 class="title">Detail Buku</h1>
    <div class="box">
      <h2 class="subtitle"><?php echo $judul; ?></h2>
      <p><strong>Penulis:</strong> <?php echo $penulis; ?></p>
      <p><strong>Penerbit:</strong> <?php echo $penerbit; ?></p>
      <p><strong>Tahun Terbit:</strong> <?php echo $tahun_terbit; ?></p>
      <p><strong>Stok:</strong> <?php echo $stok; ?></p>
      <p><strong>Sinopsis:</strong></p>
      <p><?php echo $sinopsis; ?></p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="title">Daftar Peminjam</h2>
    <div class="box">
    <?php
$queryPeminjam = "SELECT anggota.nama, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali FROM peminjaman INNER JOIN anggota ON peminjaman.id_anggota = anggota.id WHERE peminjaman.id_buku = $id";
$resultPeminjam = mysqli_query($conn, $queryPeminjam);

// Memeriksa apakah ada peminjam buku
if (mysqli_num_rows($resultPeminjam) > 0) {
  echo '<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">';
  echo '<thead align="center"><tr><th>No.</th><th>Nama</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th></tr></thead>';
  echo '<tbody align="center">';
  $counter = 1;
  while ($rowPeminjam = mysqli_fetch_assoc($resultPeminjam)) {
    $namaPeminjam = $rowPeminjam['nama'];
    $tanggalPinjam = $rowPeminjam['tanggal_pinjam'];
    $tanggalKembali = $rowPeminjam['tanggal_kembali'];
    echo '<tr>';
    echo '<td>' . $counter . '</td>';
    echo '<td>' . $namaPeminjam . '</td>';
    echo '<td>' . $tanggalPinjam . '</td>';
    echo '<td>' . $tanggalKembali . '</td>';
    echo '</tr>';
    $counter++;
  }
  echo '</tbody>';
  echo '</table>';
} else {
  echo '<p>Tidak ada peminjam untuk buku ini</p>';
}
?>



    </div>
  </div>
</section>


