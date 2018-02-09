<?php

include '../includes/db.php';

function select_PERIODE_PENERIMAAN() {
    $conn = connectDB();

    $sql = "SELECT nomor, tahun FROM tk_basdat_a02.PERIODE_PENERIMAAN";
    $result = pg_query($conn, $sql);
    pg_close($conn);
    return $result;
}

function select_JENJANG() {
    $conn = connectDB();

    $sql = "SELECT nama FROM tk_basdat_a02.JENJANG";
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

    <title>SIRIMA &middot; Form Rekap Pendaftaran</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./rekap_pendaftaran.css">
</head>

<body>
    <div id="app">
        <div class="middle">
            <article class="card form-rekap-card">
                <header>
                    <h3>Form Rekap Pendaftaran</h3>
                </header>
                <footer>
                    <form id="prodi-jenjang-form" method="get" action='hasil_rekap_pendaftaran.php'>
                        <fieldset class="flex">
                            <label>
                                <h5>Periode</h5>
                                <select name="periode">
                                    <?php
                                        $result = select_PERIODE_PENERIMAAN();
                                        while ($row = pg_fetch_array($result)) {
                                            echo '
                                            <option value="'.$row[0].'-'.$row[1].'">'.$row[0].'-'.$row[1].'</option>
                                            ';
                                        }
                                    ?>
                                </select>
                            </label>
                            <label>
                                <h5>Jenjang</h5>
                                <select name="jenjang">
                                    <?php
                                        $result = select_JENJANG();
                                        while ($row = pg_fetch_array($result)) {
                                            echo '
                                            <option value="'.$row[0].'">'.$row[0].'</option>
                                            ';
                                        }
                                    ?>
                                </select>
                            </label>
                        </fieldset>
                        <div class="flex two three-600">
                            <button type="submit" class="off-half off-two-third-600" id="lihat-rekap-pendaftaran-button">LIHAT</button>
                            <a class="off-half off-two-third-600 button" href="../admin/admin.html">BACK</a>

                        </div>
                    </form>
                </footer>
            </article>
        </div>
    </div>

    <script src="../lib/umbrella.min.js"></script>
    <script src="../lib/sweetalert2.min.js"></script>
    <script src="../lib/get-form-data.min.js"></script>
</body>
</html>
