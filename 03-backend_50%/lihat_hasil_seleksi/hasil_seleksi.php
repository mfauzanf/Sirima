<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard();

function getHasilSeleksi($idpeserta) {

    $conn = connectDB();

	$username = $_SESSION['user'];
	$result = 0;
    $cek = cekIdPeserta($idpeserta, $username, $conn);
    
    if(!$cek){
		$_SESSION['error_seleksi'] = true;    
	} else {
		$_SESSION['error_seleksi'] = false;    
			$sql = "SELECT distinct PD.id, PL.nama_lengkap, PP.status_lulus, PS.nama, PD.npm
				FROM tk_basdat_a02.pendaftaran AS PD,
				tk_basdat_a02.pelamar AS PL,
				tk_basdat_a02.pendaftaran_prodi AS PP,
				tk_basdat_a02.program_studi AS PS
				WHERE PD.id = '1' and
				PD.pelamar = PL.username and
				PP.kode_prodi = PS.kode and
				PP.id_pendaftaran = PD.id";
		$result = pg_query($conn, $sql);
	}
    pg_close($conn);
	return $result;
}

function cekIdPeserta($idpeserta, $username, $conn) {
	
	$sql = "SELECT 1
			FROM tk_basdat_a02.pendaftaran PD
			WHERE PD.id = '$idpeserta' and
			PD.pelamar = '$username'";
	$result = pg_query($conn, $sql);

	$row = array();
	try {
		$row = pg_fetch_array($result);
	} catch(Exception $e) {
		echo 'id yang dimasukkan salah';
	}

	if($row[0] == 1){
		return true;
	} else {
		return false;
	}
}

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Lihat Hasil Seleksi</title>
		  <link rel="stylesheet" href="pendaftaran.css">
    <link rel="stylesheet" href="../lib/picnic.min.css">
    <link rel="stylesheet" href="../lib/sweetalert2.min.css">
    <link rel="stylesheet" href="./lihat_hasil_seleksi.css">


  </head>
  <body>
		<div id="app">
			<div class="middle">
			<article class="card hasil_seleksi">
				<?php
				$result = getHasilSeleksi($_POST['id_pendaftar-seleksi']);

				if($_SESSION['error_seleksi']) {
					echo'
						<script>alert("id peserta yang anda masukkan salah")</script>
					';					
				} else {
				while ($row = pg_fetch_array($result)){
					echo'
				<table>
				  <tbody>
				    <tr>
				      <td><center>
						<h3 align="center">HASIL SELEKSI</h3>
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
				      <td>Status :'; 
				if($row[2] == 't'){
					echo 'LULUS</td>
				    </tr>
					<tr>
				      <td>Prodi : '.$row[3].'</td>
				    </tr>
					<tr>
				      <td>NPM : '.$row[4].'</td>
				    </tr>
				';
				break;
				} else if($row[2] == 'f'){
					echo 'TIDAK LULUS</td>
				    </tr>
				';} else {
					echo 'BELUM LULUS</td>
					</tr>
				';}
					echo '
				  </tbody>
				</table>
					';
				}
				};?>
			</article>
			</div>
		</div>


		<script src="../lib/umbrella.min.js"></script>
		<script src="../lib/sweetalert2.min.js"></script>
		<script src="../lib/get-form-data.min.js"></script>
  </body>
</html>
