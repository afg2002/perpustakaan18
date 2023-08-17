<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'member') {
  // Jika pengguna belum login atau bukan anggota, redirect ke halaman login
  header("Location: index.php");
  exit();
}

// Menggunakan koneksi ke database
include 'koneksi.php';

// Memeriksa apakah parameter pencarian telah diberikan
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  // Query untuk mencari buku berdasarkan judul atau penulis
  $query = "SELECT * FROM buku WHERE judul LIKE '%$search%' OR penulis LIKE '%$search%'";
} else {
  // Query untuk mengambil semua data buku
  $query = "SELECT * FROM buku";
}

// Menentukan jumlah buku per halaman
$jumlah_per_halaman = 12;

// Menentukan halaman saat ini berdasarkan parameter GET atau default ke halaman 1
$halaman_sekarang = isset($_GET['page']) ? $_GET['page'] : 1;

// Menghitung offset berdasarkan halaman saat ini
$offset = ($halaman_sekarang - 1) * $jumlah_per_halaman;

// Query untuk mengambil data buku dengan batasan per halaman
$query .= " LIMIT $offset, $jumlah_per_halaman";

$result = mysqli_query($conn, $query);

// Mendapatkan jumlah total buku
$query_total_buku = "SELECT COUNT(*) AS total_buku FROM buku";
$result_total_buku = mysqli_query($conn, $query_total_buku);
$data_total_buku = mysqli_fetch_assoc($result_total_buku);
$total_buku = $data_total_buku['total_buku'];

// Mendapatkan jumlah total halaman
$total_halaman = ceil($total_buku / $jumlah_per_halaman);

// Memeriksa jumlah buku yang telah dipinjam oleh anggota
$query_check_pinjam = "SELECT COUNT(*) AS jumlah_pinjam FROM peminjaman WHERE id_anggota = " . $_SESSION['id'];
$result_check_pinjam = mysqli_query($conn, $query_check_pinjam);
$data_pinjam = mysqli_fetch_assoc($result_check_pinjam);
$jumlah_pinjam = $data_pinjam['jumlah_pinjam'];

// Maksimal peminjaman buku oleh anggota
$batas_max_pinjam = 5;

include 'header.php';
?>
<section class="section">
  <div class="container">
    <h1 class="title">Dashboard Anggota</h1>
    
    <!-- Form pencarian buku -->
    <form method="GET" action="dashboard.php">
      <div class="field has-addons">
        <div class="control">
          <input class="input" type="text" placeholder="Cari buku" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        </div>
        <div class="control">
          <button type="submit" class="button is-primary">Cari</button>
        </div>
      </div>
    </form>
    <br>
    <div class="notification is-primary">
      <p>Di bawah ini adalah daftar buku yang tersedia. Anda dapat mencari buku berdasarkan judul atau penulis. Klik judul buku untuk melihat detailnya.</p>
    </div>
    <?php
    // Periksa apakah anggota telah mencapai batas maksimal peminjaman
    if ($jumlah_pinjam >= $batas_max_pinjam) {
      echo '<div class="notification is-danger">Anda telah mencapai batas maksimal peminjaman buku.</div>';
    }
    ?>

    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Tahun Terbit</th>
          <th>Stok</th>
          <th>Pinjam</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $judul = $row['judul'];
            $penulis = $row['penulis'];
            $penerbit = $row['penerbit'];
            $tahun_terbit = $row['tahun_terbit'];
            $stok = $row['stok'];

            $disabled = ($stok <= 0 || $jumlah_pinjam >= $batas_max_pinjam) ? 'disabled' : '';

            echo '<tr>';
            echo '<td><a href="detail_buku.php?id=' . $id . '">' . $judul . '</a></td>';
            echo '<td>' . $penulis . '</td>';
            echo '<td>' . $penerbit . '</td>';
            echo '<td>' . $tahun_terbit . '</td>';
            echo '<td><span id="stok-' . $id . '">' . $stok . '</span></td>';
            echo '<td><button class="button is-primary" onclick="showConfirmation(' . $id . ')" ' . $disabled . '>Pinjam Buku</button></td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="6">Tidak ada buku yang tersedia.</td></tr>';
        }
        ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
      <ul class="pagination-list">
        <?php
        // Tampilkan link ke halaman sebelumnya
        if ($halaman_sekarang > 1) {
          echo '<li><a class="pagination-link" href="dashboard.php?page=' . ($halaman_sekarang - 1) . '">Sebelumnya</a></li>';
        }

        // Tampilkan link halaman
        for ($i = 1; $i <= $total_halaman; $i++) {
          // Tandai halaman saat ini dengan class 'is-current'
          $class = ($i == $halaman_sekarang) ? 'is-current' : '';
          echo '<li><a class="pagination-link ' . $class . '" href="dashboard.php?page=' . $i . '">' . $i . '</a></li>';
        }

        // Tampilkan link ke halaman berikutnya
        if ($halaman_sekarang < $total_halaman) {
          echo '<li><a class="pagination-link" href="dashboard.php?page=' . ($halaman_sekarang + 1) . '">Berikutnya</a></li>';
        }
        ?>
      </ul>
    </nav>

  </div>
</section>

<!-- Modal untuk konfirmasi peminjaman -->
<div class="modal" id="confirmationModal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Konfirmasi Peminjaman</p>
      <button class="delete" aria-label="close" onclick="hideConfirmation()"></button>
    </header>
    <section class="modal-card-body">
      <p>Anda akan meminjam buku ini. Apakah Anda yakin?</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-primary" onclick="pinjamBuku()">Ya, Pinjam</button>
      <button class="button" onclick="hideConfirmation()">Batal</button>
    </footer>
  </div>
</div>

<!-- Modal untuk notifikasi berhasil pinjam -->
<div class="modal" id="successModal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Peminjaman Sukses</p>
      <button class="delete" aria-label="close" onclick="hideSuccess()"></button>
    </header>
    <section class="modal-card-body">
      <p>Anda telah berhasil melakukan peminjaman buku.</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-primary" onclick="hideSuccess()">Tutup</button>
    </footer>
  </div>
</div>

<script>
  var selectedBookId;
  var currentPinjam = <?php echo $jumlah_pinjam; ?>;


  function showConfirmation(bookId) {
  selectedBookId = bookId;
  var stokElement = document.getElementById('stok-' + selectedBookId);
  var stok = parseInt(stokElement.innerHTML);

  if (stok === 0) {
    // Jika stok sudah 0, nonaktifkan tombol "Pinjam"
    document.getElementById('pinjamBtn').disabled = true;
    document.getElementById('pinjamBtn').innerHTML = 'Stok Habis';
  } else {
    // Jika masih ada stok, tampilkan modal konfirmasi
    document.getElementById('confirmationModal').classList.add('is-active');
  }
}


  function hideConfirmation() {
    selectedBookId = null;
    document.getElementById('confirmationModal').classList.remove('is-active');
  }

  function pinjamBuku() {
    // Lakukan aksi peminjaman buku menggunakan AJAX
    var xhr = new XMLHttpRequest();

    // URL endpoint untuk melakukan peminjaman buku
    var url = "pinjam_buku.php";

    // Metode dan URL yang akan digunakan
    xhr.open("POST", url, true);

    // Set header yang diperlukan untuk mengirim data dengan metode POST
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Callback saat permintaan AJAX selesai
    // ...
xhr.onload = function () {
  if (xhr.status === 200) {
    var response = JSON.parse(xhr.response);
    if(response.success == false){
      // console.log(response);
      alert(response.message);
      document.getElementById('confirmationModal').classList.remove('is-active');
      return false;
    }

    
    // Peminjaman buku berhasil
    document.getElementById('confirmationModal').classList.remove('is-active');
    document.getElementById('successModal').classList.add('is-active');

    // Memperbarui stok pada card buku yang dipilih
    var stokElement = document.getElementById('stok-' + selectedBookId);
    if (stokElement) {
      var stok = parseInt(stokElement.innerHTML);
      stok--;
      stokElement.innerHTML = stok.toString();
    }

    currentPinjam++;
    if (currentPinjam == 6) {
      alert('Kamu sudah melebihi batas peminjaman buku.');
      // location.href = location.href;
      return false;
    }

    if(response.success){
      var peminjamanId = response.peminjamanId; // Mengambil ID peminjaman dari respons AJAX
      console.log(peminjamanId);
      location.href = 'peminjaman_sukses.php?id=' + peminjamanId;
    }
    
    
    // Mengarahkan pengguna ke halaman peminjaman_sukses.php dengan ID peminjaman
    
    // console.log(peminjamanId);
  } else {
    // Peminjaman buku gagal
    console.log("Error: " + xhr.status);
  }
};

    // Mengambil data buku yang akan dipinjam
    var bookId = selectedBookId;

    // Mengirim data buku yang akan dipinjam ke pinjam_buku.php
    var data = "bookId=" + encodeURIComponent(bookId);
    xhr.send(data);
  }

  function hideSuccess() {
    document.getElementById('successModal').classList.remove('is-active');
  }
</script>

