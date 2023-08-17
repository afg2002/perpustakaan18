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
$nama = '';
$alamat = '';
$email = '';
$username = '';
$password = '';
$role = ''; // Menambahkan variabel $role
$error = '';

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role = 'member'; // Mendapatkan data role dari form

  // Hash password sebelum disimpan ke database
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Query untuk menyimpan data anggota baru ke database
  $query = "INSERT INTO anggota (nama, alamat, email, username, password, role) VALUES ('$nama', '$alamat', '$email', '$username', '$hashedPassword', '$role')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Jika berhasil menambahkan anggota, redirect ke halaman data_anggota.php
    header("Location: data_anggota.php");
    exit();
  } else {
    // Jika gagal menambahkan anggota, tampilkan pesan error
    $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
  }
}
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Tambah Anggota</h1>

    <?php if (!empty($error)) : ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="field">
        <label class="label">Nama</label>
        <div class="control">
          <input class="input" type="text" name="nama" value="<?php echo $nama; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Alamat</label>
        <div class="control">
          <input class="input" type="text" name="alamat" value="<?php echo $alamat; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Email</label>
        <div class="control">
          <input class="input" type="email" name="email" value="<?php echo $email; ?>" required>
        </div>
      </div>

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
          <a class="button is-link" href="data_anggota.php">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</section>
