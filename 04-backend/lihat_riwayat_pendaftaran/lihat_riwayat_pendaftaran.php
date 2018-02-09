<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard();

function getRiwayatPendaftaranSemas() {

    $conn = connectDB();

	$username = $_SESSION['user'];

	$sql = "SELECT P.id, P.nomor_periode, 
	P.tahun_periode, SEMAS.no_kartu_ujian
	FROM tk_basdat_a02.PENDAFTARAN as P, 
	tk_basdat_a02.PENDAFTARAN_SEMAS as SEMAS, 
	tk_basdat_a02.PENDAFTARAN_SEMAS_SARJANA as SEMASS1
	WHERE P.pelamar = '$username' AND 
	P.id = SEMAS.id_pendaftaran AND 
	P.id = SEMASS1.id_pendaftaran";

	$result = pg_query($sql);
    pg_close($conn);
	return $result;
}

function getRiwayatPendaftaranSemasS2() {

    $conn = connectDB();

	$username = $_SESSION['user'];

	$sql = "SELECT P.id, P.nomor_periode, 
		P.tahun_periode, SEMAS.no_kartu_ujian
		FROM tk_basdat_a02.PENDAFTARAN as P, 
		tk_basdat_a02.PENDAFTARAN_SEMAS as SEMAS,
		tk_basdat_a02.PENDAFTARAN_SEMAS_PASCASARJANA as SEMASS2
		WHERE P.pelamar = '$username' AND 
		P.id = SEMAS.id_pendaftaran AND 
		P.id = SEMASS2.id_pendaftaran;";

	$result = pg_query($sql);
    pg_close($conn);
	return $result;
}

function getRiwayatPendaftaranUUI() {

    $conn = connectDB();

	$username = $_SESSION['user'];

	$sql = "SELECT P.id, P.nomor_periode, P.tahun_periode
			FROM tk_basdat_a02.PENDAFTARAN as P,
			tk_basdat_a02.PENDAFTARAN_UUI U
			WHERE P.pelamar = '$username' AND 
			P.id = U.id_pendaftaran";

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
	return $result;
}

function getNama(){
    
    $conn = connectDB();
	$username = $_SESSION['user'];

	$sql = "SELECT PL.nama_lengkap
			FROM tk_basdat_a02.pelamar as PL
			WHERE PL.username = '$username'";

	$result = pg_query($sql);
	$row = pg_fetch_array($result);
	return $row[0];
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
				<header>
					<center>
					<h3 align="center">LIHAT RIWAYAT PENDAFTARAN</h3>
					</center>
					Nama Lengkap : 
					<?php echo getNama();?>
				</header>
				<footer>
					<table class="primary">
					  <thead>
					    <tr>
					      <th>Id Pendaftaran</th>
					      <th>Nomor periode</th>
					      <th>Tahun periode</th>
					      <th>No Kartu Ujian</th>
					      <th>Jalur</th>
					      <th>Prodi 1</th>
					      <th>Prodi 2</th>
					      <th>Prodi 3</th>
					    </tr>
					  </thead>
					  <tbody>
					  <?php
					  $result = getRiwayatPendaftaranUUI();
					  $id = '0';
					  while($row = pg_fetch_assoc($result)){
				  		echo "<tr>";
				  		$id = $row['id'];
						echo '<td><a href="detail_pendaftaran_uui.php?id='.$row['id'].'">'.$row['id'].'</a></td>';;
						echo '<td>'.$row['nomor_periode'].'</td>';
						echo '<td>'.$row['tahun_periode'].'</td>';
						echo '<td>KOSONG</td>';
						echo '<td>UUI</td>';
						$prodi = getProdi($row['id']);
						$sum_prodi = "0";
						while ($nama_prodi = pg_fetch_assoc($prodi)) {
							echo '<td>'.$nama_prodi['nama'].'</td>';
							$sum_prodi++;
						}
						if($sum_prodi == 1){
							echo '<td>KOSONG</td>';
							echo '<td>KOSONG</td>';
						} else if($sum_prodi == 2){
							echo '<td>KOSONG</td>';
						}
						echo "</tr>";}

					  $result = getRiwayatPendaftaranSemas();
					  $id = '0';
					  while($row = pg_fetch_assoc($result)){
				  		echo "<tr>";
				  		$id = $row['id'];
						echo '<td><a href="detail_pendaftaran_semas_sarjana.php?id='.$row['id'].'">'.$row['id'].'</a></td>';;
						echo '<td>'.$row['nomor_periode'].'</td>';
						echo '<td>'.$row['tahun_periode'].'</td>';
						echo '<td>'.$row['no_kartu_ujian'].'</td>';
						echo '<td>SEMAS SARJANA</td>';
						$prodi = getProdi($row['id']);
						$sum_prodi = "0";
						while ($nama_prodi = pg_fetch_assoc($prodi)) {
							echo '<td>'.$nama_prodi['nama'].'</td>';
							$sum_prodi++;
						}
						if($sum_prodi == 1){
							echo '<td>KOSONG</td>';
							echo '<td>KOSONG</td>';
						} else if($sum_prodi == 2){
							echo '<td>KOSONG</td>';
						}
						echo "</tr>";}

						$result = getRiwayatPendaftaranSemasS2();
					  $id = '0';
					  while($row = pg_fetch_assoc($result)){
				  		echo "<tr>";
				  		$id = $row['id'];
						echo '<td><a href="detail_pendaftaran_semas_pascasarjana.php?id='.$row['id'].'">'.$row['id'].'</a></td>';;
						echo '<td>'.$row['nomor_periode'].'</td>';
						echo '<td>'.$row['tahun_periode'].'</td>';
						echo '<td>'.$row['no_kartu_ujian'].'</td>';
						echo '<td>SEMAS PASCASARJANA</td>';
						$prodi = getProdi($row['id']);
						$sum_prodi = "0";
						while ($nama_prodi = pg_fetch_assoc($prodi)) {
							echo '<td>'.$nama_prodi['nama'].'</td>';
							$sum_prodi++;
						}
						if($sum_prodi == 1){
							echo '<td>KOSONG</td>';
							echo '<td>KOSONG</td>';
						} else if($sum_prodi == 2){
							echo '<td>KOSONG</td>';
						}
						echo "</tr>";}
					  ?>
					  </tbody>
					</table>
					<a id="tombol" class="off-half off-two-third-600 button" href="../dashboard/">BACK</a>
				</footer>
				</article>
			</div>
		</div>


		<script src="../lib/umbrella.min.js"></script>
		<script src="../lib/sweetalert2.min.js"></script>
		<script src="../lib/get-form-data.min.js"></script>
  </body>
</html>
