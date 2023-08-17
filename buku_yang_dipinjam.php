<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'member') {
  // Jika pengguna belum login atau bukan anggota, redirect ke halaman login
  header("Location: index.php");
  exit();
}

// Menggunakan koneksi ke database
include 'koneksi.php';

// Mendapatkan ID anggota dari sesi
$id_anggota = $_SESSION['id'];

// Query untuk mendapatkan buku yang dipinjam oleh anggota beserta tanggal pinjam dan tanggal kembali
$query = "SELECT peminjaman.id, peminjaman.id_buku, buku.judul, buku.penulis, buku.penerbit, buku.tahun_terbit, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali
          FROM peminjaman 
          INNER JOIN buku ON peminjaman.id_buku = buku.id 
          WHERE peminjaman.id_anggota = $id_anggota";

$result = mysqli_query($conn, $query);

include 'header.php';
?>

<section class="section">
  <div class="container">
    <h1 class="title">Buku yang Dipinjam</h1>

    <?php
    // Periksa apakah ada buku yang dipinjam oleh anggota
    if (mysqli_num_rows($result) > 0) {
      echo '<table class="table is-striped is-fullwidth">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Judul</th>';
      echo '<th>Penulis</th>';
      echo '<th>Penerbit</th>';
      echo '<th>Tahun Terbit</th>';
      echo '<th>Tanggal Pinjam</th>';
      echo '<th>Tanggal Kembali</th>';
      echo '<th>Aksi</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Tampilkan buku yang dipinjam
      while ($row = mysqli_fetch_assoc($result)) {
        // Mendapatkan tanggal sekarang
        $tanggal_sekarang = date('Y-m-d');
        // Menghitung selisih hari antara tanggal kembali dengan tanggal sekarang
        $selisih_hari = strtotime($tanggal_sekarang) - strtotime($row['tanggal_kembali']);
        $selisih_hari = floor($selisih_hari / (60 * 60 * 24));

        echo '<tr>';
        echo '<td>' . $row['judul'] . '</td>';
        echo '<td>' . $row['penulis'] . '</td>';
        echo '<td>' . $row['penerbit'] . '</td>';
        echo '<td>' . $row['tahun_terbit'] . '</td>';
        echo '<td>' . $row['tanggal_pinjam'] . '</td>';
        if ($selisih_hari > 0) {
          // Jika tanggal kembali melewati hari ini, beri warna kuning pada td
          echo '<td class="warna-kuning">' . $row['tanggal_kembali'] . '</td>';
          // Hitung denda jika terlambat mengembalikan selama 1 hari (denda per hari 10.000)
          $denda = $selisih_hari * 10000;
          echo '<td><button class="is-success" onclick="konfirmasiKembalikan(' . $row['id_buku'] . ', ' . $denda . ')">Kembalikan</button> (Denda: Rp' . $denda . ')</td>';
        } else {
          echo '<td>' . $row['tanggal_kembali'] . '</td>';
          echo '<td><button class="is-success" onclick="konfirmasiKembalikan(' . $row['id_buku'] . ', 0)">Kembalikan</button></td>';
        }
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
    } else {
      // Jika tidak ada buku yang dipinjam
      echo '<p>Belum ada buku yang dipinjam.</p>';
    }
    ?>

    <script>
      function konfirmasiKembalikan(idBuku, denda) {
        var konfirmasi = confirm("Anda yakin ingin mengembalikan buku ini?");

        if (konfirmasi) {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'kembalikan.php', true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = function() {
            var response = JSON.parse(xhr.responseText);
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Respon sukses dari kembalikan.php
              alert(response.message);
              window.location.reload(); // Refresh halaman setelah mengembalikan buku
            }
          };
          xhr.send('id=' + idBuku);
        } else {
          alert(response.message);
          alert("Pengembalian buku dibatalkan.");
        }
      }
    </script>
  </div>
</section>
