<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard_admin();

function select_daftar_pelamar_diterima($periode,$prodi) {

    $conn = connectDB();
    $pieces = explode("-",$periode);
    $nomor_periode = $pieces[0];
    $tahun_periode = $pieces[1];

    $limit2show = 10;

    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $start = ($page - 1) * $limit2show;


    $sql = "SELECT Pen.id, Pel.nama_lengkap, Pel.alamat, Pel.jenis_kelamin, Pel.tanggal_lahir, Pel.no_ktp, Pel.email
            FROM tk_basdat_a02.PENDAFTARAN AS Pen, tk_basdat_a02.PELAMAR AS Pel
            WHERE Pen.status_lulus
            AND Pen.nomor_periode = '$nomor_periode'
            AND Pen.tahun_periode = '$tahun_periode'
            AND Pen.pelamar = Pel.username
            AND Pen.id IN (
                SELECT Pen_Pro.id_pendaftaran
                FROM tk_basdat_a02.PENDAFTARAN_PRODI AS Pen_Pro
                WHERE Pen_Pro.kode_prodi = '$prodi'
                AND Pen_Pro.status_lulus
            )
            OFFSET $start LIMIT $limit2show";

    $result = pg_query($conn, $sql);

    pg_close($conn);
    return $result;
}



//Untuk mengetahui jumlah data sebelum di pagination
//saya cari-cari cara supaya mengetahui jumlah total sebelum dilakukan operasi OFFSET .. LIMIT
//Namun tidak ada cara lain selain menggunakan 2 query
function select_daftar_pelamar_diterima_total($periode,$prodi) {

    $conn = connectDB();
    $pieces = explode("-",$periode);
    $nomor_periode = $pieces[0];
    $tahun_periode = $pieces[1];

    $sql = "SELECT Pen.id, Pel.nama_lengkap, Pel.alamat, Pel.jenis_kelamin, Pel.tanggal_lahir, Pel.no_ktp, Pel.email
            FROM tk_basdat_a02.PENDAFTARAN AS Pen, tk_basdat_a02.PELAMAR AS Pel
            WHERE Pen.status_lulus
            AND Pen.nomor_periode = '$nomor_periode'
            AND Pen.tahun_periode = '$tahun_periode'
            AND Pen.pelamar = Pel.username
            AND Pen.id IN (
                SELECT Pen_Pro.id_pendaftaran
                FROM tk_basdat_a02.PENDAFTARAN_PRODI AS Pen_Pro
                WHERE Pen_Pro.kode_prodi = '$prodi'
                AND Pen_Pro.status_lulus
            )";

    $result = pg_query($conn, $sql);

    pg_close($conn);
    return $result;
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Hasil Daftar Pelamar Diterima</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./daftar_pelamar.css">

    <!-- dapat dari w3school -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
    <div id="app">
        <div class="middle">
            <article class="card hasil-pelamar-diterima-card">
                <header>
                    <h3>Hasil Daftar Pelamar Diterima</h3>
                    <br>
                    <h5>Periode:
                        <?php
                            echo '<label> '.$_GET['periode'].'</label>';
                        ?>
                    </h5>
                    <h5>Prodi:
                        <?php
                            $pieces = explode("-",$_GET['prodi']);
                            echo '<label> '.$pieces[0].' kode: '.$pieces[1].'</label>';
                        ?>
                    </h5>
                </header>
                <footer>
                    <table class="table">
                        <tr>
                            <th>Id Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>No KTP</th>
                            <th>Email</th>
                        </tr>
                        <?php
                            $pieces = explode("-",$_GET['prodi']);
                            $result = select_daftar_pelamar_diterima($_GET['periode'], $pieces[1]);

                            while ($row = pg_fetch_array($result)) {
                                echo '<tr>';
                                echo '<td>'.$row[0].'</td>';
                                echo '<td>'.$row[1].'</td>';
                                echo '<td>'.$row[2].'</td>';
                                echo '<td>'.$row[3].'</td>';
                                echo '<td>'.$row[4].'</td>';
                                echo '<td>'.$row[5].'</td>';
                                echo '<td>'.$row[6].'</td>';
                                echo '</tr>';
                            }

                        ?>
                    </table>

                    <!-- Menggunakan pagination yang dipakai saat Tugas Akhir Mata Kuliah PPW, dengan penyesuaian-->
                    <!-- waktu itu Saya(Jeffry) sekelompok bersama Cindy Adelia -->
                    <ul class="pagination">
                        <?php
                            $pieces = explode("-",$_GET['prodi']);
                            $result = select_daftar_pelamar_diterima_total($_GET['periode'],$pieces[1]);
                            $totalRecords = pg_num_rows($result);

                            $totalPages = ceil($totalRecords / 10);
                            $flag = false;

                            $base = "hasil_daftar_pelamar.php?periode=".$_GET['periode']."&prodi=".$_GET['prodi']."";

                            echo "<li><a class='page-scroll' href='".$base."&page=1'>«</a></li>";
                            if(!isset($_GET["page"])) {
                                echo "<li><a class='active page-scroll' href='".$base."&page=1'>1</a></li>";
                                $flag = true;
                            }

                            for ($i = 1; $i <= $totalPages; $i++) {
                                if(!$flag) {
                                    if(isset($_GET["page"]) && $i == $_GET["page"]) {
                                        echo "<li><a class='active page-scroll' href='".$base."&page=".$i."'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li><a href='".$base."&page=".$i."'>" . $i . "</a></li>";
                                    }
                                } else {
                                    $flag = false;
                                }
                            }
                            echo "<li><a href='".$base."&page=".$totalPages."'>»</a></li>";
                        ?>
                    </ul>

                    <div class="flex two three-600">
                        <a class="off-half off-two-third-600 button" href="form_daftar_pelamar.php">Kembali ke Form</a>
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
