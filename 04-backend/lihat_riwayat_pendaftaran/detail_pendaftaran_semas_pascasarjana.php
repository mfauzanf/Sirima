<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard();

function getDetailS2($idpeserta){

	$conn = connectDB();

	$username = $_SESSION['user'];


	$sql = "SELECT P.id, P.nomor_periode, P.tahun_periode, SEMASS2.jenjang, SEMAS.no_kartu_ujian, SEMASS2.nilai_tpa, SEMASS2.nilai_toefl, SEMASS2.jenjang_terakhir, SEMASS2.asal_univ, SEMASS2.alamat_univ	, SEMASS2.prodi_terakhir, SEMASS2.nilai_ipk, SEMASS2.tgl_lulus, Prodi.nama, SEMASS2.nama_rekomender, SEMASS2.prop_penelitian, SEMAS.lokasi_kota, SEMAS.lokasi_tempat
		FROM tk_basdat_a02.PENDAFTARAN as P, 
		tk_basdat_a02.PENDAFTARAN_SEMAS as SEMAS, 
		tk_basdat_a02.PENDAFTARAN_PRODI as PP, 
		tk_basdat_a02.PENDAFTARAN_SEMAS_PASCASARJANA as SEMASS2, 
		tk_basdat_a02.PROGRAM_STUDI as Prodi
		WHERE P.id = $idpeserta AND P.id = SEMAS.id_pendaftaran AND P.id = SEMASS2.id_pendaftaran AND P.id = PP.id_pendaftaran AND PP.kode_prodi = Prodi.kode";

	$result = pg_query($sql);
    pg_close($conn);
	return $result;
}

function getProdi($idpeserta){

    $conn = connectDB();
	$username = $_SESSION['user'];
	$sql = "SELECT P.nama
			FROM tk_basdat_a02.PENDAFTARAN_PRODI as PP, tk_basdat_a02.PROGRAM_STUDI as P
			WHERE PP.id_pendaftaran = $idpeserta AND 
			PP.kode_prodi = P.kode";	
	$result = pg_query($sql);
    pg_close($conn);
	return $result;
}

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Pendaftaran S1</title>
		  <link rel="stylesheet" href="pendaftaran.css">
    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./lihat_riwayat_pendaftaran.css">


  </head>
  <body>
		<div id="app">
			<div class="middle">
				<article class="card lihat_riwayat_pendaftaran">
				<article class="card riwayat_pendaftaran">
				<table>
				  <tbody>
				    <tr>
				      <td><h3>DETAIL PENDAFTARAN SEMAS PASCASARJANA</h3></td>
				    </tr>
				<?php
				$current_id = $_REQUEST["id"];
				$result = getDetailS2($current_id);
				while ($row = pg_fetch_assoc($result)) {
					echo "<tr><td>Id Pendaftaran :".$row['id']."</td></tr>";
					echo "<tr><td>Periode :".$row['nomor_periode']."-".$row['tahun_periode']."</td></tr>";
					echo "<tr><td>Jenjang Dipilih :".$row['jenjang']."</td></tr>";
					echo "<tr><td>No Kartu Ujian :".$row['no_kartu_ujian']."</td></tr>";
					echo "<tr><td>Nilai TPA :".$row['nilai_tpa']."</td></tr>";
					echo "<tr><td>Nilai TOEFL :".$row['nilai_toefl']."</td></tr>";
					echo "<tr><td>Jenjang Terakhir :".$row['jenjang_terakhir']."</td></tr>";
					echo "<tr><td>Asal Universitas :".$row['asal_univ']."</td></tr>";
					echo "<tr><td>Alamat Universitas :".$row['alamat_univ']."</td></tr>";
					echo "<tr><td>Prodi Terakhir :".$row['prodi_terakhir']."</td></tr>";
					echo "<tr><td>Nilai IPK :".$row['nilai_ipk']."</td></tr>";
					echo "<tr><td>Tanggal lulus :".$row['tgl_lulus']."</td></tr>";
					echo "<tr><td>Prodi pilihan :".$row['nama']."</td></tr>";
					if($row['jenjang'] === "S3"){
						echo "<tr><td>Nama Rekomender :".$row['nama_rekomender']."</td></tr>";
						echo "<tr><td>Proposal penelitian :".$row['prop_penelitian']."</td></tr>";
					}
					echo "<tr><td>Lokasi kota ujian :".$row['lokasi_kota']."</td></tr>";
					echo "<tr><td>Lokasi tempat ujian :".$row['lokasi_tempat']."</td></tr>";		
				}?>				  
				</tbody>
				</table>
					<center><a href="lihat_riwayat_pendaftaran.php" align="center" id="kembali">KEMBALI</a></center>
				</article>
				</article>
			</div>
		</div>


		<script src="../lib/umbrella.min.js"></script>
		<script src="../lib/sweetalert2.min.js"></script>
		<script src="../lib/get-form-data.min.js"></script>
  </body>
</html>
