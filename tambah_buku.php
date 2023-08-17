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

// Inisialisasi variabel
$judul = $penulis = $penerbit = $tahun_terbit = $sinopsis = $stok = '';
$error = '';

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mengambil data dari form
  $judul = $_POST['judul'];
  $penulis = $_POST['penulis'];
  $penerbit = $_POST['penerbit'];
  $tahun_terbit = $_POST['tahun_terbit'];
  $sinopsis = $_POST['sinopsis'];
  $stok = $_POST['stok'];

  // Validasi form
  if (empty($judul) || empty($penulis) || empty($penerbit) || empty($tahun_terbit) || empty($stok)) {
    $error = "Harap isi semua kolom yang diperlukan.";
  } else {
    // Query untuk menambahkan buku ke database
    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, sinopsis, stok) VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$sinopsis', '$stok')";
    $result = mysqli_query($conn, $query);

    if ($result) {
      // Jika berhasil menambahkan buku, redirect ke halaman data_buku.php
      header("Location: data_buku.php");
      exit();
    } else {
      // Jika gagal menambahkan buku, tampilkan pesan error
      $error = "Terjadi kesalahan. Silakan coba lagi." . mysqli_error($conn);
    }
  }
}
?>

<?php include 'header.php'; ?>

<section class="section">
  <div class="container">
    <h1 class="title">Tambah Buku</h1>

    <?php if (!empty($error)) : ?>
      <div class="notification is-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
          <textarea class="textarea" name="sinopsis"><?php echo $sinopsis; ?></textarea>
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
          <button class="button is-primary" type="submit">Tambah</button>
        </div>
      </div>
    </form>
  </div>
</section>
