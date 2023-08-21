<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Data buku</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
  <style>
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
      width: 80%;
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
      margin-right: 80px; /* Tambahkan margin kanan pada tanda tangan */
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
    <h1 class="title judul mt-5">Data buku</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Alamat</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include '../koneksi.php';

        // Query untuk mengambil data admin
        $query = "SELECT * FROM buku";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $judul = $row['judul'];
            $penulis = $row['penulis'];
            $penerbit = $row['penerbit'];
            $tahun_terbit = $row['tahun_terbit'];
            $sinopsis = $row['sinopsis'];
            ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $judul; ?></td>
              <td><?php echo $penulis; ?></td>
              <td><?php echo $penerbit; ?></td>
              <td><?php echo $tahun_terbit; ?></td>
              <td><?php echo $sinopsis; ?></td>
            </tr>
          <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="6">Tidak ada data buku.</td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <div class="tanda-tangan">
      <div class="lokasi-tanggal">
        
        <p>Jakarta,<?php echo date('d F Y'); ?></p>
      </div>
      <div class="ttd">
        <p>Admin</p>
      </div>
    </div>
  </div>
</body>
</html>

<script>window.print()</script>