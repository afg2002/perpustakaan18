<?php
include '../koneksi.php';

// Query untuk mengambil data peminjaman beserta informasi anggota dan buku
$query = "SELECT peminjaman.id, buku.judul AS judul_buku, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, anggota.nama AS nama_anggota
          FROM peminjaman
          INNER JOIN buku ON peminjaman.id_buku = buku.id
          INNER JOIN anggota ON peminjaman.id_anggota = anggota.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Data Peminjaman</title>
  <style>
    /* Gaya tampilan untuk cetak */
    body {
      font-family: Arial, sans-serif;
    }
    .container {
      margin: 20px auto;
      max-width: 800px;
      text-align: center;
    }
    .kop-surat {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }
    .logo {
      width: 80px;
      height: auto;
      margin-right: 20px;
    }
    .judul-alamat {
      text-align: center;
    }
    .judul {
      font-size: 24px;
      margin-bottom: 5px;
    }
    .alamat {
      font-size: 14px;
    }
    .garis {
      margin-top: 20px;
      border-top: 1px solid #000;
    }
    table {
      border-collapse: collapse;
      width: 90%;
      margin: 20px auto;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .tanda-tangan {
      text-align: right;
      margin-top: 50px;
      margin-right: 80px;
    }
    .ttd {
      margin-top: 20px;
      
    }
    .lokasi-tanggal {
      font-size: 14px;
      margin-top: 10px;
      margin-bottom: 100px;
    }
    @page {
      size: auto;
      margin: 0;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="kop-surat">
      <img src="../assets/icon.png" alt="Logo Perpustakaan" class="logo">
      <div class="judul-alamat">
        <h1 class="title judul">Perpustakaan Taman Matoa</h1>
        <p class="alamat">Jl. H. Masmun No.1, RT.1/RW.7, Jagakarsa, Kec. Jagakarsa, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12620</p>
      </div>
    </div>
    <div class="garis"></div>
    <h1 class="title judul mt-5">Data Peminjaman</h1>
    <table>
      <thead>
        <tr>
          <th>ID Peminjaman</th>
          <th>Judul Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Nama Anggota</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id_peminjaman = $row['id'];
            $judul_buku = $row['judul_buku'];
            $tanggal_pinjam = $row['tanggal_pinjam'];
            $tanggal_kembali = $row['tanggal_kembali'];
            $nama_anggota = $row['nama_anggota'];
            ?>
            <tr>
              <td><?php echo $id_peminjaman; ?></td>
              <td><?php echo $judul_buku; ?></td>
              <td><?php echo $tanggal_pinjam; ?></td>
              <td><?php echo $tanggal_kembali; ?></td>
              <td><?php echo $nama_anggota; ?></td>
            </tr>
          <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="5">Tidak ada data peminjaman.</td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <div class="tanda-tangan">
      <div class="lokasi-tanggal">
        <p>Jakarta, <?php echo date('d F Y'); ?></p>
      </div>
      <div class="ttd">
        <p>Admin</p>
      </div>
    </div>
  </div>
</body>
</html>

<script>window.print()</script>
