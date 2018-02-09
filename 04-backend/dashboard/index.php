<?php
    
    include '../includes/db.php';
    include '../includes/auth.php';
    auth_guard();

function getNama($username){

    $conn = connectDB();
    
    $sql = "SELECT nama_lengkap from tk_basdat_a02.pelamar where username = '$username'";

    $result = pg_query($conn, $sql);
    pg_close($conn);
    $return = pg_fetch_row($result)[0];
    return $return;
}
    
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Halaman Uama</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./dashboard.css">
</head>

<body>
    <div id="app">
        <div class="middle">
            <article class="card admin-card">
                <header>
                    <h3>Hi, <?= getNama($_SESSION['user']) ?></h3>
                </header>
                <footer>
                    <div class="card">
                        <a href="../pendaftaranSemasS1/daftar.php" class="button stack">MEMBUAT PENDAFTARAN</a>
                        <a href="../lihat_riwayat_pendaftaran/lihat_riwayat_pendaftaran.php" class="button stack">RIWAYAT PENDAFTARAN</a>
                        <a href="../lihat_kartu_ujian/form_lihat_kartu_ujian.php" class="button stack">MELIHAT KARTU UJIAN</a>
                        <a href="../lihat_hasil_seleksi/form_lihat_hasil_seleksi.php" class="button stack">MELIHAT HASIL SELEKSI</a>
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
</body>
</html>
