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

// Memeriksa apakah parameter id telah diberikan
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Query untuk mengambil data admin berdasarkan id
  $query = "SELECT * FROM admin WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Jika data admin ditemukan, mengisi variabel dengan nilai dari database
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $password = $row['password'];
  } else {
    // Jika data admin tidak ditemukan, redirect ke halaman data_admin.php
    header("Location: data_admin.php");
    exit();
  }
} else {
  // Jika parameter id tidak diberikan, redirect ke halaman data_admin.php
  header("Location: data_admin.php");
  exit();
}

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query untuk mengupdate data admin berdasarkan id
  if (!empty($password)) {
    // Jika password diisi, hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE admin SET username='$username', password='$hashedPassword' WHERE id = '$id'";
  } else {
    // Jika password dikosongkan, tidak mengubah password
    $query = "UPDATE admin SET username='$username' WHERE id = '$id'";
  }

  $result = mysqli_query($conn, $query);

  if ($result) {
    // Jika berhasil mengupdate data admin, redirect ke halaman data_admin.php
    header("Location: data_admin.php");
    exit();
  } else {
    // Jika gagal mengupdate data admin, tampilkan pesan error
    $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
  }
}
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Edit Admin</h1>

    <?php if (!empty($error)) : ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST">
      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input class="input" type="text" name="username" value="<?php echo $username; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Password</label>
        <p>*kosong jika tidak ingin diubah.</p>
        <div class="control">
          <input class="input" type="password" name="password">
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Simpan</button>
          <a class="button is-link" href="data_admin.php">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</section>
