<?php 
session_start();
include 'header.php' ?>

  <section class="section">
    <div class="container">
      <h1 class="title">Dashboard Admin</h1>

      <div class="columns">
        <div class="column is-half">
          <div class="card">
            <div class="card-content">
              <div class="content">
                <h2 class="title is-5">Jumlah Anggota</h2>
                <p class="subtitle is-4">
                  <?php
                  // Menggunakan koneksi ke database
                  include 'koneksi.php';

                  // Query untuk menghitung jumlah anggota dengan role 'member'
                  $query = "SELECT COUNT(*) AS total_anggota FROM anggota";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['total_anggota'];
                  ?>
                </p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="content">
                <h2 class="title is-5">Jumlah Admin</h2>
                <p class="subtitle is-4">
                  <?php
                  // Menggunakan koneksi ke database
                  include 'koneksi.php';

                  // Query untuk menghitung jumlah anggota dengan role 'member'
                  $query = "SELECT COUNT(*) AS total_admin FROM admin WHERE role = 'admin'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['total_admin'];
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="column is-half">
          <div class="card">
            <div class="card-content">
              <div class="content">
                <h2 class="title is-5">Jumlah Buku</h2>
                <p class="subtitle is-4">
                  <?php
                  // Query untuk menghitung jumlah buku
                  $query = "SELECT COUNT(*) AS total_buku FROM buku";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);
                  echo $row['total_buku'];
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>
