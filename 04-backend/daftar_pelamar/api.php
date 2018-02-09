<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard_admin();

$conn = connectDB();
$q = $_GET['q'];

$pieces = explode("-",$q);
$nomor_periode = $pieces[0];
$tahun_periode = $pieces[1];

$sql = "SELECT P_S.jenjang, P_S.nama, P_S.jenis_kelas, P_S.kode
        FROM tk_basdat_a02.PROGRAM_STUDI AS P_S,tk_basdat_a02.PENERIMAAN_PRODI AS P_P
        WHERE P_S.kode IN (
            SELECT P_P.kode_prodi
            WHERE P_P.nomor_periode = '$nomor_periode'
            AND P_P.tahun_periode = '$tahun_periode'
        )";

$result = pg_query($conn, $sql);

echo "<select name='prodi'>";
while ($row = pg_fetch_array($result)) {
    echo '<option value="'.$row[0].' '.$row[1].' '.$row[2].'-'.$row[3].'">'.$row[0].' '.$row[1].' '.$row[2].' kode: '.$row[3].'</option>';
}
echo '</select>';

pg_close($conn);
?>
