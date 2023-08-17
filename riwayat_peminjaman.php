<?php
// Memeriksa apakah pengguna sudah login sebagai anggota
// Jika tidak, redirect ke halaman login
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'member') {
  header("Location: login.php");
  exit();
}

include 'koneksi.php';

// Mendapatkan ID anggota dari session
$anggotaId = $_SESSION['id'];

// Mendapatkan data riwayat peminjaman buku oleh anggota
$query = "SELECT * FROM peminjaman WHERE id_anggota = :id_anggota ORDER BY tanggal_peminjaman DESC";
$stmt = $conn->prepare($query);
$stmt->bindValue(':id_anggota', $anggotaId, PDO::PARAM_INT);
$stmt->execute();
$riwayatPeminjaman = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Riwayat Peminjaman</h1>

    <?php if (count($riwayatPeminjaman) > 0) { ?>
      <table class="table is-fullwidth">
        <thead>
          <tr>
            <th>Tanggal Peminjaman</th>
            <th>Buku</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($riwayatPeminjaman as $riwayat) { ?>
            <tr>
              <td><?php echo $riwayat['judul_buku']; ?></td>
              <td><?php echo $riwayat['tanggal_peminjaman']; ?></td>
              <td><?php echo $riwayat['tanggal_pengembalian']; ?></td>
              <!-- <td><?php echo $riwayat['status']; ?></td> -->
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>Tidak ada riwayat peminjaman buku.</p>
    <?php } ?>
  </div>
</section>

<?php include 'footer.php'; ?>
