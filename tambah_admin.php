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

// Inisialisasi variabel dengan nilai default
$username = '';
$password = '';
$error = '';

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Hash password sebelum disimpan ke database
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Query untuk menyimpan data admin baru ke database
  $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashedPassword')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Jika berhasil menambahkan admin, redirect ke halaman data_admin.php
    header("Location: data_admin.php");
    exit();
  } else {
    // Jika gagal menambahkan admin, tampilkan pesan error
    $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
  }
}
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Tambah Admin</h1>

    <?php if (!empty($error)) : ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input class="input" type="text" name="username" value="<?php echo $username; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <div class="control">
          <input class="input" type="password" name="password" required>
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Tambah</button>
          <a class="button is-link" href="data_admin.php">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</section>
