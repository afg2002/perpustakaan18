<?php
// Menggunakan koneksi ke database
include 'koneksi.php';
session_start();

// Memeriksa apakah pengguna memiliki peran admin
if ($_SESSION['role'] != 'admin') {
// Jika bukan admin, redirect ke halaman lain atau tampilkan pesan error
header("Location: index.php?error=unauthorized");
exit();
}

// Pengaturan pagination
$results_per_page = 5; // Jumlah data per halaman
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
$start_index = ($current_page - 1) * $results_per_page; // Indeks awal data

// Query untuk mengambil data buku dengan pagination
$query = "SELECT * FROM buku LIMIT $start_index, $results_per_page";
$result = mysqli_query($conn, $query);

// Query untuk menghitung jumlah total data buku
$total_results = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
$total_results = mysqli_fetch_assoc($total_results)['total'];

$total_pages = ceil($total_results / $results_per_page); // Jumlah total halaman


// Search
$search = ''; // Inisialisasi variabel pencarian
if (isset($_GET['search'])) {
  $search = $_GET['search']; // Mengambil data pencarian dari URL
}

// Query untuk mengambil data buku dengan pencarian dan pagination
$query = "SELECT * FROM buku
          WHERE judul LIKE '%$search%'
          LIMIT $start_index, $results_per_page";
$result = mysqli_query($conn, $query);
?>


<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Data Buku</h1>
    <a class="button is-primary" href="tambah_buku.php">Tambah Buku</a>

    

    <!-- Form pencarian -->
    <form action="data_buku.php" method="GET" class="mb-3 mt-5">
      <div class="field has-addons">
        <div class="control">
          <input class="input" type="text" name="search" placeholder="Cari judul buku">
        </div>
        <div class="control">
          <button class="button is-info" type="submit">Cari</button>
        </div>
      </div>
    </form>

    <table class="table is-striped is-hoverable" style="width:100%;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Tahun Terbit</th>
          <th>Sinopsis</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
  // Memeriksa apakah data buku ditemukan
  if (mysqli_num_rows($result) > 0) {
    // Mengambil data buku
    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $judul = $row['judul'];
      $penulis = $row['penulis'];
      $penerbit = $row['penerbit'];
      $tahun_terbit = $row['tahun_terbit'];
      $sinopsis = $row['sinopsis'];

      
      $stok = $row['stok']; // Memotong sinopsis jika lebih panjang dari 100 karakter
      $sinopsis_potong = strlen($sinopsis) > 200 ? substr($sinopsis, 0, 200) . '...' : $sinopsis;
     
      ?>
        <tr>
          <td><?php echo $id; ?></td>
          <td><?php echo $judul; ?></td>
          <td><?php echo $penulis; ?></td>
          <td><?php echo $penerbit; ?></td>
          <td><?php echo $tahun_terbit; ?></td>
          <td><?php echo $sinopsis_potong; ?></td>
          <td><?php echo $stok; ?></td>
          <td>
            <a href="edit_buku.php?id=<?php echo $id; ?>" class="button is-primary is-small" style="width:100%">Edit</a>
            <a href="hapus_buku.php?id=<?php echo $id; ?>" class="button is-danger is-small"
              onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" style="width:100%">Hapus</a>
          </td>
        </tr>
        <?php
    }
  } else {
    // Jika data buku tidak ditemukan
    ?>
        <tr>
          <td colspan="8">Tidak ada data buku.</td>
        </tr>
        <?php
  }
  ?>
      </tbody>
    </table>

    <!-- Navigasi halaman -->
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
      <ul class="pagination-list">
        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
        <li>
          <a href="data_buku.php?page=<?php echo $page; ?>"
            class="pagination-link <?php echo $page === $current_page ? 'is-current' : ''; ?>"><?php echo $page; ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>

  </div>
</section>