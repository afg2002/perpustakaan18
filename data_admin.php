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

// Query untuk mengambil data admin dengan pagination
$query = "SELECT * FROM admin LIMIT $start_index, $results_per_page";
$result = mysqli_query($conn, $query);

// Query untuk menghitung jumlah total data admin
$total_results = mysqli_query($conn, "SELECT COUNT(*) as total FROM admin");
$total_results = mysqli_fetch_assoc($total_results)['total'];

$total_pages = ceil($total_results / $results_per_page); // Jumlah total halaman

// Search
$search = ''; // Inisialisasi variabel pencarian
if (isset($_GET['search'])) {
  $search = $_GET['search']; // Mengambil data pencarian dari URL
}

// Query untuk mengambil data admin dengan pencarian dan pagination
$query = "SELECT * FROM admin
          WHERE username LIKE '%$search%'
          LIMIT $start_index, $results_per_page";
$result = mysqli_query($conn, $query);
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Data Admin</h1>
    <a class="button is-primary" href="tambah_admin.php">Tambah Admin</a>

    <!-- Form pencarian -->
    <form action="data_admin.php" method="GET" class="mb-3 mt-5">
      <div class="field has-addons">
        <div class="control">
          <input class="input" type="text" name="search" placeholder="Cari username admin">
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
          <th>Username</th>
          <th>Password</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Memeriksa apakah data admin ditemukan
        if (mysqli_num_rows($result) > 0) {
          // Mengambil data admin
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $username = $row['username'];
            $password = $row['password'];
            ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $username; ?></td>
              <td><?php echo $password; ?></td>
              <td>
                <a href="edit_admin.php?id=<?php echo $id; ?>" class="button is-primary is-small">Edit</a>
                <a href="hapus_admin.php?id=<?php echo $id; ?>" class="button is-danger is-small" onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">Hapus</a>
              </td>
            </tr>
          <?php
          }
        } else {
          // Jika data admin tidak ditemukan
          ?>
          <tr>
            <td colspan="4">Tidak ada data admin.</td>
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
          <a href="data_admin.php?page=<?php echo $page; ?>"
            class="pagination-link <?php echo $page === $current_page ? 'is-current' : ''; ?>"><?php echo $page; ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>

  </div>
</section>
