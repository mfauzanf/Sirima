<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard_admin();

function selectRekap($periode,$jenjang) {

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


	$sql = "SELECT P_S.nama, P_S.jenis_kelas, P_S.nama_fakultas,  P_P.kuota, P_P.jumlah_pelamar, P_P.jumlah_diterima
            FROM tk_basdat_a02.PROGRAM_STUDI AS P_S,tk_basdat_a02.PENERIMAAN_PRODI AS P_P
            WHERE P_S.jenjang = '$jenjang'
            AND P_S.kode IN (
                SELECT P_P.kode_prodi
                WHERE P_P.nomor_periode = '$nomor_periode'
                AND P_P.tahun_periode = '$tahun_periode'
            )
            OFFSET $start LIMIT $limit2show";


    $result = pg_query($conn, $sql);

    pg_close($conn);
	return $result;
}

//Untuk mengetahui jumlah data sebelum di pagination
//saya cari-cari cara supaya mengetahui jumlah total sebelum dilakukan operasi OFFSET .. LIMIT
//Namun tidak ada cara lain selain menggunakan 2 query
function selectRekapTotal($periode,$jenjang) {

    $conn = connectDB();
    $pieces = explode("-",$periode);
    $nomor_periode = $pieces[0];
    $tahun_periode = $pieces[1];

	$sql = "SELECT P_S.nama, P_S.jenis_kelas, P_S.nama_fakultas,  P_P.kuota, P_P.jumlah_pelamar, P_P.jumlah_diterima
            FROM tk_basdat_a02.PROGRAM_STUDI AS P_S,tk_basdat_a02.PENERIMAAN_PRODI AS P_P
            WHERE P_S.jenjang = '$jenjang'
            AND P_S.kode IN (
                SELECT P_P.kode_prodi
                WHERE P_P.nomor_periode = '$nomor_periode'
                AND P_P.tahun_periode = '$tahun_periode'
            )
            ";

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

    <title>SIRIMA &middot; Hasil Rekap Pendaftaran</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./rekap_pendaftaran.css">

    <!-- dapat dari w3school -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
    <div id="app">
        <div class="middle">
            <article class="card hasil-rekap-card">
                <header>
                    <h3>Hasil Rekap Pendaftaran</h3>
                    <br>
                    <h5>Periode:
                        <?php
                            echo '<label> '.$_GET['periode'].'</label>';
                        ?>
                    </h5>
                    <h5>Jenjang:
                        <?php
                            echo '<label> '.$_GET['jenjang'].'</label>';
                        ?>
                    </h5>
                </header>
                <footer>
                    <table class="table">
                        <tr>
                            <th>Nama Prodi</th>
                            <th>Jenis Kelas</th>
                            <th>Nama Fakultas</th>
                            <th>Kuota</th>
                            <th>Jumlah Pelamar</th>
                            <th>Jumlah Diterima</th>
                        </tr>
                        <tr>
                            <?php
                                $result = selectRekap($_GET['periode'], $_GET['jenjang']);

                                while ($row = pg_fetch_array($result)) {
                                    echo '<tr>';
                                    echo '<td>'.$row[0].'</td>';
                                    echo '<td>'.$row[1].'</td>';
                                    echo '<td>'.$row[2].'</td>';
                                    echo '<td>'.$row[3].'</td>';
                                    echo '<td>'.$row[4].'</td>';
                                    echo '<td>'.$row[5].'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tr>
                    </table>

                    <!-- Menggunakan pagination yang dipakai saat Tugas Akhir Mata Kuliah PPW, dengan penyesuaian-->
                    <!-- waktu itu Saya(Jeffry) sekelompok bersama Cindy Adelia -->
                    <ul class="pagination">
                        <?php
                            $result = selectRekapTotal($_GET['periode'],$_GET['jenjang']);
                            $totalRecords = pg_num_rows($result);

                            $totalPages = ceil($totalRecords / 10);
                            $flag = false;

                            $base = "hasil_rekap_pendaftaran.php?periode=".$_GET['periode']."&jenjang=".$_GET['jenjang']."";

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
                        <a class="off-half off-two-third-600 button" href="form_rekap_pendaftaran.php">Kembali ke Form</a>
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
