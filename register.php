<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Perpustakaan Sederhana - Registrasi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <style>
    .register-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 40px;
      margin-top: 100px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <section class="section">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-half">
          <div class="register-container">
            <h1 class="title has-text-centered">Registrasi</h1>
            <form action="process_register.php" method="POST">
              <div class="field">
                <label class="label">Username</label>
                <div class="control">
                  <input class="input" type="text" name="username" placeholder="Masukkan username" required>
                </div>
              </div>
              <div class="field">
                <label class="label">Password</label>
                <div class="control">
                  <input class="input" type="password" name="password" placeholder="Masukkan password" required>
                </div>
              </div>
              <div class="field">
                <label class="label">Nama</label>
                <div class="control">
                  <input class="input" type="text" name="nama" placeholder="Masukkan nama" required>
                </div>
              </div>
              <div class="field">
                <label class="label">Alamat</label>
                <div class="control">
                  <input class="input" type="text" name="alamat" placeholder="Masukkan alamat" required>
                </div>
              </div>
              <div class="field">
                <label class="label">Email</label>
                <div class="control">
                  <input class="input" type="email" name="email" placeholder="Masukkan email" required>
                </div>
              </div>
              <!-- <div class="field">
                <label class="label">Role</label>
                <div class="control">
                  <div class="select">
                    <select name="role" required>
                      <option value="member">Member</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
                </div>
              </div> -->
              <div class="field is-grouped is-grouped-centered">
                <div class="control">
                  <button class="button is-primary" type="submit">Register</button>
                </div>
                <div class="control">
                  <a class="button is-link" href="./">Login</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>
