<?php

  include '../includes/db.php';

  session_start();

  if (isset($_SESSION['user'])) {
    if ($_SESSION['admin'] === true) {
      header('Location: ../admin/admin.html');
    } else {
      header('Location: ../dashboard/dashboard.html');
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $errors = [];
    $success = [];
    $conn = connectDB();
    $sql = "
      insert
      into tk_basdat_a02.akun
      (username, role, password)
      values ($1, 'f', $2)";
    $result = pg_prepare($conn, 'register_akun_query', $sql);
    $result = pg_execute($conn, 'register_akun_query', array($_POST['username'], $_POST['password']));

    if ($result != false) {
      $sql = "
        insert
        into tk_basdat_a02.pelamar
        (username, nama_lengkap, alamat, jenis_kelamin, tanggal_lahir, no_ktp, email)
        values ($1, $2, $3, $4, $5, $6, $7)";
      $result = pg_prepare($conn, 'register_pelamar_query', $sql);
      $result = pg_execute($conn, 'register_pelamar_query', array(
        $_POST['username'],
        $_POST['namaLengkap'],
        $_POST['alamat'],
        $_POST['gender'],
        $_POST['tanggalLahir'],
        $_POST['nomorId'],
        $_POST['email']
      ));

      $success = ['Berhasil mendaftar, silakan login'];
      header('refresh:1; url=../login/login.php');
    } else {
      $errors[] = 'Username sudah terdaftar.';
    }

  }

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Masuk</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./register.css">
  </head>
  <body>

    <div id="app">
      <div class="middle">
        <article class="card register-card">
          <header>
            <h3>Pendaftaran Pelamar</h3>
          </header>
          <footer>
            <form id="register-form" method="post">
              <fieldset class="flex">
                <label>
                  <h5>Username</h5>
                  <input type="text" name="username" placeholder="Username" required>
                </label>
                <label>
                  <h5>Password</h5>
                  <input type="password" name="password" placeholder="Password" required>
                </label>
                <label>
                  <h5>Ulangi Password</h5>
                  <input type="password" name="confirmPassword" placeholder="Ulangi Password" required>
                </label>
                <label>
                  <h5>Nama Lengkap</h5>
                  <input type="text" name="namaLengkap" placeholder="Nama Lengkap" required>
                </label>
                <label>
                  <h5>Nomor Identitas</h5>
                  <input type="text" name="nomorId" pattern="[0-9]{16}" placeholder="Nomor Identitas" required>
                </label>
                <label>
                  <h5>Jenis Kelamin</h5>
                  <select name="gender" required>
                    <option disabled selected value="-">Pilih Jenis Kelamin</option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </label>
                <label>
                  <h5>Tanggal Lahir</h5>
                  <input type="date" name="tanggalLahir" required>
                </label>
                <label>
                  <h5>Alamat</h5>
                  <textarea name="alamat" placeholder="Alamat" required></textarea>
                </label>
                <label>
                  <h5>Alamat Email</h5>
                  <input type="email" name="email" placeholder="Email" required>
                </label>
                <label>
                  <h5>Ulangi Alamat Email</h5>
                  <input type="email" name="confirmEmail" placeholder="Ulangi Email" required>
                </label>
              </fieldset>
              <div class="flex two three-600">
                <button type="submit" class="off-half off-two-third-600" id="register-button">Daftar</button>
              </div>
            </form>
          </footer>
        </article>
      </div>
    </div>

    <script src="../lib/umbrella.min.js"></script>
    <script src="../lib/sweetalert2.min.js"></script>
    <script src="../lib/get-form-data.min.js"></script>
    <script src="./register.js"></script>
    <?php if(!empty($errors)) { ?>
    <script>
      (function() {
        swal('Error!', '<?= implode('; ', $errors) ?>', 'error');
      })();
    </script>
    <?php } ?>
    <?php if(!empty($success)) { ?>
    <script>
      (function() {
        swal('Success!', '<?= implode('; ', $success) ?>', 'success');
      })();
    </script>
    <?php } ?>
  </body>
</html>