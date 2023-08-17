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

  // Query untuk mengambil data buku berdasarkan id
  $query = "SELECT * FROM buku WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Jika data buku ditemukan, mengisi variabel dengan nilai dari database
    $row = mysqli_fetch_assoc($result);
    $judul = $row['judul'];
    $penulis = $row['penulis'];
    $penerbit = $row['penerbit'];
    $tahun_terbit = $row['tahun_terbit'];
    $sinopsis = $row['sinopsis'];
    $stok = $row['stok'];
  } else {
    // Jika data buku tidak ditemukan, redirect ke halaman data_buku.php
    header("Location: data_buku.php");
    exit();
  }
} else {
  // Jika parameter id tidak diberikan, redirect ke halaman data_buku.php
  header("Location: data_buku.php");
  exit();
}

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = $_POST['tahun_terbit'];
    $sinopsis = mysqli_real_escape_string($conn, $_POST['sinopsis']);
    $stok = $_POST['stok'];


  // Query untuk mengupdate data buku berdasarkan id
  $query = "UPDATE buku SET judul = '$judul', penulis = '$penulis', penerbit = '$penerbit', tahun_terbit = '$tahun_terbit', sinopsis = '$sinopsis', stok = '$stok' WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Jika berhasil mengupdate data buku, redirect ke halaman data_buku.php
    header("Location: data_buku.php");
    exit();
  } else {
    // Jika gagal mengupdate data buku, tampilkan pesan error
    $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
  }
}
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Edit Buku</h1>

    <?php if (!empty($error)) : ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST">
      <div class="field">
        <label class="label">Judul</label>
        <div class="control">
          <input class="input" type="text" name="judul" value="<?php echo $judul; ?>" required>
        </div>
      </div>
      <div class="field">
        <label class="label">Penulis</label>
        <div class="control">
          <input class="input" type="text" name="penulis" value="<?php echo $penulis; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Penerbit</label>
        <div class="control">
          <input class="input" type="text" name="penerbit" value="<?php echo $penerbit; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Tahun Terbit</label>
        <div class="control">
          <input class="input" type="number" name="tahun_terbit" value="<?php echo $tahun_terbit; ?>" required>
        </div>
      </div>

      <div class="field">
        <label class="label">Sinopsis</label>
        <div class="control">
          <textarea class="textarea" name="sinopsis" required><?php echo $sinopsis; ?></textarea>
        </div>
      </div>

      <div class="field">
        <label class="label">Stok</label>
        <div class="control">
          <input class="input" type="number" name="stok" value="<?php echo $stok; ?>" required>
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Simpan</button>
          <a class="button is-link" href="data_buku.php">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</section>
