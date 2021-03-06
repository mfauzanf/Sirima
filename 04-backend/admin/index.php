<?php

    include '../includes/auth.php';
    auth_guard_admin();


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Halaman Admin</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./admin.css">
</head>

<body>
    <div id="app">
        <div class="middle">
            <article class="card admin-card">
                <header>
                    <h3>Hi, <?= $_SESSION['user'] ?></h3>
                </header>
                <footer>
                    <div class="card">
                        <a href="../rekap_pendaftaran/form_rekap_pendaftaran.php" class="button stack">MELIHAT REKAP PENDAFTARAN</a>
                        <a href="../daftar_pelamar/form_daftar_pelamar.php" class="button stack">MELIHAT DAFTAR PELAMAR DITERIMA</a>
                    </div>
                    <div class="card">
                        <a href="../login/logout.php" class="button stack error">LOGOUT</a>
                    </div>
                </footer>
            </article>
        </div>
    </div>

    <script src="../lib/umbrella.min.js"></script>
    <script src="../lib/sweetalert2.min.js"></script>
    <script src="../lib/get-form-data.min.js"></script>
</body>
</html>
