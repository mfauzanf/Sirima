<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard();

function getDetailUUI($idpeserta){

	$conn = connectDB();

	$username = $_SESSION['user'];


	$sql = "SELECT P.id, P.nomor_periode, P.tahun_periode, 
		U.rapot, U.surat_rekomendasi, U.asal_sekolah, 
		U.jenis_sma, U.alamat_sekolah, U.nisn, U.tgl_lulus, 
		U.nilai_uan, Prodi.nama
		FROM tk_basdat_a02.PENDAFTARAN as P, 
		tk_basdat_a02.PENDAFTARAN_UUI as U, 
		tk_basdat_a02.PENDAFTARAN_PRODI as PP, 
		tk_basdat_a02.PROGRAM_STUDI as Prodi
		WHERE P.id = $idpeserta AND 
		P.id = U.id_pendaftaran AND 
		P.id = PP.id_pendaftaran AND 
		PP.kode_prodi = Prodi.kode";

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
				    <tr><td>
				      <h3>DETAIL PENDAFTARAN UUI</h3>
				    </td></tr>
				    <?php
				$current_id = $_REQUEST["id"];
				$result = getDetailUUI($current_id);
				$row = pg_fetch_assoc($result);
					echo "<tr><td>Id Pendaftaran :".$row['id']."</td></tr>";
					echo "<tr><td>Periode :".$row['nomor_periode']."-".$row['tahun_periode']."</td></tr>";
					echo "<tr><td>Rapot : ".$row['rapot']." </td></tr>";
					echo "<tr><td>Surat Rekomendasi : ".$row['surat_rekomendasi']." </td></tr>";
					echo "<tr><td>Asal Sekolah : ".$row['asal_sekolah']." </td></tr>";
					echo "<tr><td>Jenis SMA : ".$row['jenis_sma']." </td></tr>";
					echo "<tr><td>Alamat Sekolah : ".$row['alamat_sekolah']." </td></tr>";
					echo "<tr><td>NISN : ".$row['nisn']." </td></tr>";
					echo "<tr><td>Tanggal Lulus :".$row['tgl_lulus']." </td></tr>";
					echo "<tr><td>Nilai UAN : ".$row['nilai_uan']." </td></tr>";
					$prodi = getProdi($row['id']);
						$sum_prodi = "0";
						while ($nama_prodi = pg_fetch_assoc($prodi)) {
							++$sum_prodi;
							echo '<tr><td>Prodi pilihan '.$sum_prodi.": ".$nama_prodi['nama'].'</td></tr>';
						}
						if($sum_prodi == 1){
							echo "<tr><td>Prodi pilihan 2: Kosong</td></tr>";
						}	
					?>
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
