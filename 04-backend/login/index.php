<?php

  include '../includes/db.php';
  include '../includes/auth.php';

  redirect_if_logged_in();


  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $conn = connectDB();
    $sql = "
      select *
      from tk_basdat_a02.akun
      where username=$1 and password=$2";
    $result = pg_prepare($conn, 'login_query', $sql);
    $result = pg_execute($conn, 'login_query', array($_POST['username'], $_POST['password']));
    $result = pg_fetch_assoc($result);

    if (!$result) {
      $errors = ['Username atau password salah'];
    } else {
      $success = ['Berhasil login!'];

      $_SESSION['user'] = $result['username'];

      if ($result['role'] === 't') {
        $_SESSION['admin'] = true;
        header('refresh:1; url=../admin/');
      } else {
        $_SESSION['admin'] = false;
        header('refresh:1; url=../dashboard/');
      }
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
    <link rel="stylesheet" href="./login.css">
  </head>
  <body>

    <div id="app">
      <div class="middle">
        <article class="card login-card">
          <header>
            <h3>Masuk ke SIRIMA</h3>
          </header>
          <footer>
            <form id="login-form" method="post">
              <fieldset class="flex">
                <label>
                  <input type="text" name="username" placeholder="Username">
                </label>
                <label>
                  <input type="password" name="password" placeholder="Password">
                </label>
              </fieldset>
              <div class="actions">
                <div><a class="button" href="../register/">Daftar</a></div>
                <div><button type="submit" id="login-button">Masuk</button></div>
              </div>
            </form>
          </footer>
        </article>
      </div>
    </div>

    <script src="../lib/sweetalert2.min.js"></script>
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
