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

  // Query untuk mengambil data anggota berdasarkan id
  $query = "SELECT * FROM anggota WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Jika data anggota ditemukan, mengisi variabel dengan nilai dari database
    $row = mysqli_fetch_assoc($result);
    $nama = $row['nama'];
    $username = $row['username'];
    $alamat = $row['alamat'];
    $email = $row['email'];
    $role = $row['role'];
  } else {
    // Jika data anggota tidak ditemukan, redirect ke halaman data_anggota.php
    header("Location: data_anggota.php");
    exit();
  }
} else {
  // Jika parameter id tidak diberikan, redirect ke halaman data_anggota.php
  header("Location: data_anggota.php");
  exit();
}

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $alamat = $_POST['alamat'];
  $email = $_POST['email'];
  $role = 'member';
  $password = $_POST['password'];

  // Query untuk mengupdate data anggota berdasarkan id
  if (!empty($password)) {
    // Jika password diisi, hash password baru
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE anggota SET username='$username', nama = '$nama', alamat = '$alamat', email = '$email', password = '$hashedPassword', role = '$role' WHERE id = '$id'";
  } else {
    // Jika password dikosongkan, tidak mengubah password
    $query = "UPDATE anggota SET username='$username', nama = '$nama', alamat = '$alamat', email = '$email', role = '$role' WHERE id = '$id'";
  }

  $result = mysqli_query($conn, $query);

  if ($result) {
    // Jika berhasil mengupdate data anggota, redirect ke halaman data_anggota.php
    header("Location: data_anggota.php");
    exit();
  } else {
    // Jika gagal mengupdate data anggota, tampilkan pesan error
    $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
  }
}
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Edit Anggota</h1>

    <?php if (!empty($error)) : ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST">
      <div class="field">
        <label class="label">Nama</label>
        <div class="control">
          <input class="input" type="text" name="nama" value="<?php echo $nama; ?>" required>
        </div>
      </div>
      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input class="input" type="text" name="username" value="<?php echo $username; ?>" required>
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
        <label class="label">Password</label>
        <p>*kosong jika tidak ingin diubah.</p>
        <div class="control">
          <input class="input" type="password" name="password">
        </div>
        
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Simpan</button>
          <a class="button is-link" href="data_anggota.php">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</section>
