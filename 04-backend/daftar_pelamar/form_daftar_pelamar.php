<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard_admin();

function select_PERIODE_PENERIMAAN() {
    $conn = connectDB();

    $sql = "SELECT nomor, tahun FROM tk_basdat_a02.PERIODE_PENERIMAAN";
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
    <title>SIRIMA &middot; Form Daftar Pelamar Diterima</title>

    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./daftar_pelamar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        function showProdi(str){
            var tmp = document.getElementById("periodeSelector");
            var periode = tmp[tmp.selectedIndex].value

            if (periode == "") {
                document.getElementById("div_prodi").innerHTML ="<select name='prodi'><option value=''>PILIH PERIODE DULU</option></select>";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("div_prodi").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","api.php?q="+periode,true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>
    <div id="app">
        <div class="middle">
            <article class="card form-pelamar-diterima-card">
                <header>
                    <h3>Form Daftar Pelamar Diterima</h3>
                </header>
                <footer>
                    <form id="pelamar-diterima-form" method="get" action="hasil_daftar_pelamar.php">
                        <fieldset class="flex">
                            <label>
                                <h5>Periode</h5>
                                <select name="periode" id='periodeSelector' onchange="showProdi(this.value)" required>
                                    <?php
                                        echo '
                                        <option value="">PILIH PERIODE</option>
                                        ';
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
                                <h5>Prodi</h5>
                                <div id="div_prodi">
                                    <select name="prodi" required>
                                        <option value="">PILIH PERIODE DULU</option>
                                    </select>
                                </div>
                            </label>
                        </fieldset>
                        <div class="flex two three-600">
                            <button type="submit" class="off-half off-two-third-600" id="lihat-daftar-pelamar-button">Lihat</button>
                            <a class="off-half off-two-third-600 button" href="../admin/">BACK</a>
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
