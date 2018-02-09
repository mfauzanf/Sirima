<?php

include '../includes/db.php';

function getKartuUjian($idpeserta) {

    $conn = connectDB();

		$sql = "SELECT distinct PD.id, PL.nama_lengkap, PS.no_kartu_ujian, PS.lokasi_tempat, PS.lokasi_kota, JP.waktu_mulai, JP.waktu_selesai
			FROM tk_basdat_a02.pendaftaran AS PD,
			tk_basdat_a02.pelamar AS PL,
			tk_basdat_a02.pendaftaran_semas AS PS,
			tk_basdat_a02.jadwal_penting AS JP
			WHERE PD.id = $idpeserta and 
			PD.pelamar = PL.username and 
			PD.id = PS.id_pendaftaran and
			JP.nomor = PD.nomor_periode and
			JP.tahun = PD.tahun_periode and
			JP.deskripsi = 'Ujian Saringan Masuk'";
	
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

    <title>SIRIMA &middot; Pendaftaran S1</title>
		  <link rel="stylesheet" href="pendaftaran.css">
    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./lihat_kartu_ujian.css">


  </head>
  <body>
		<div id="app">
			<div class="middle">
				<article class="card lihat_kartu_ujian">
				<article class="card kartu_ujian">
					<?php
					$result = getKartuUjian($_POST['id_pendaftar-kartu']);
                    $row = pg_fetch_array($result);     
					echo'
				<table>
				  <tbody>
				    <tr>
				      <td><center>
						<h3 align="center">KARTU UJIAN</h3>
						</center>
					  </td>
				    </tr>
				    <tr>
				      <td>Id pendaftaran : '.$row[0].'</td>
				    </tr>
					<tr>
				      <td>Nama lengkap : '.$row[1].'</td>
				    </tr>
					<tr>
				      <td>Nomor kartu ujian : '.$row[2].'</td>
				    </tr>
					<tr>
				      <td>Lokasi ujian : '.$row[3].', '.$row[4].'</td>
				    </tr>
					<tr>
				      <td>Waktu ujian : '.$row[5].' - '.$row[6].'</td>
				    </tr>
				  </tbody>
				</table>
					';?>
				</article>
				</article>
			</div>
		</div>


		<script src="../lib/umbrella.min.js"></script>
		<script src="../lib/sweetalert2.min.js"></script>
		<script src="../lib/get-form-data.min.js"></script>
  </body>
</html>
