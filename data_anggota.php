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

// Query untuk mengambil data anggota dengan pagination
$query = "SELECT * FROM anggota LIMIT $start_index, $results_per_page";
$result = mysqli_query($conn, $query);

// Query untuk menghitung jumlah total data anggota
$total_results = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
$total_results = mysqli_fetch_assoc($total_results)['total'];

$total_pages = ceil($total_results / $results_per_page); // Jumlah total halaman

// Search
$search = ''; // Inisialisasi variabel pencarian
if (isset($_GET['search'])) {
  $search = $_GET['search']; // Mengambil data pencarian dari URL
}

// Query untuk mengambil data anggota dengan pencarian dan pagination
$query = "SELECT * FROM anggota
          WHERE nama LIKE '%$search%'
          LIMIT $start_index, $results_per_page";
$result = mysqli_query($conn, $query);
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Data Anggota</h1>
    <a class="button is-primary" href="tambah_anggota.php">Tambah Anggota</a>

    <div class="level">
      <div class="level-left">
        <div class="level-item">
          <!-- Form pencarian -->
          <form action="data_anggota.php" method="GET" class="mb-3 mt-5">
            <div class="field has-addons">
              <div class="control">
                <input class="input" type="text" name="search" placeholder="Cari nama anggota">
              </div>
              <div class="control">
                <button class="button is-info" type="submit">Cari</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <!-- Tombol Print -->
          <a class="button is-info" href="./laporan/laporan_DataAnggota.php" target="_blank">Print Data Anggota</a>
        </div>
      </div>
    </div>



    <table class="table is-striped is-hoverable" style="width:100%;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Alamat</th>
          <th>Email</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Memeriksa apakah data anggota ditemukan
        if (mysqli_num_rows($result) > 0) {
          // Mengambil data anggota
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $nama = $row['nama'];
            $username = $row['username'];
            $alamat = $row['alamat'];
            $email = $row['email'];
            $role = $row['role'];
            ?>
        <tr>
          <td><?php echo $id; ?></td>
          <td><?php echo $nama; ?></td>
          <td><?php echo $username; ?></td>
          <td><?php echo $alamat; ?></td>
          <td><?php echo $email; ?></td>
          <td><?php echo $role; ?></td>
          <td>
            <a href="edit_anggota.php?id=<?php echo $id; ?>" class="button is-primary is-small">Edit</a>
            <a href="hapus_anggota.php?id=<?php echo $id; ?>" class="button is-danger is-small"
              onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">Hapus</a>
          </td>
        </tr>
        <?php
          }
        } else {
          // Jika data anggota tidak ditemukan
          ?>
        <tr>
          <td colspan="7">Tidak ada data anggota.</td>
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
          <a href="data_anggota.php?page=<?php echo $page; ?>"
            class="pagination-link <?php echo $page === $current_page ? 'is-current' : ''; ?>"><?php echo $page; ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>

  </div>
</section>