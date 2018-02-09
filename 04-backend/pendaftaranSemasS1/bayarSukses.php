<?php

include '../includes/db.php';
include '../includes/auth.php';

auth_guard();

$koneksi = connectDB();

 

 	$result = pg_query($koneksi , "SELECT * FROM tk_basdat_a02.PEMBAYARAN");
 	$row = pg_num_rows($result);
 	$idBayar = $row + 1;
 	$IDpendaftaran = $_SESSION['postIDdaftar'];
 	$date = date('Y-m-d H:i:s');
  
 	$noKartu = $IDpendaftaran  + 1434343565;
  $queryBayar = "INSERT INTO tk_basdat_a02.PEMBAYARAN(id, waktu_bayar, jumlah_bayar, id_pendaftaran)VALUES($idBayar,'$date','500000', $IDpendaftaran)";

 	pg_query($koneksi, $queryBayar);
  $queryUpdatePendaftaran = "UPDATE tk_basdat_a02.PENDAFTARAN_SEMAS SET no_kartu_ujian=$noKartu WHERE id_pendaftaran=$IDpendaftaran";

 	pg_query($koneksi, $queryUpdatePendaftaran);


 ?>


 <!DOCTYPE html>
 <html lang="id">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>SIRIMA &middot; PEMBAYARAN</title>
 		<link rel="stylesheet" href="pendaftaran.css">
     <link rel="stylesheet" href="../lib/picnic.min.css">
     <!-- <script type="text/javascript" src="formS1.js"></script> -->

   </head>
   <body id="pembayaran">

 		 <div id="app">
 			<div class="middle">
 				<article class="card formS1">
 					<header>
 						<h3 align="center">Selamat Pembayaran Berhasil Dilakukan</h3>
 					</header>
 					<footer>
 						<form name="daftarS1" id="daftarS1" role="form" method="" action="">
 							<fieldset class="flex two">
                <p>ID Pendaftaran : <?= $IDpendaftaran  ?>  </p>
                <p>ID Pembayaran :<?= $idBayar ?></p>
                <p>No Kartu Ujian :<?= $noKartu ?></p>
 							</fieldset>
 							<div class="flex two three-600">
 							</div>
 						</form>
 					</footer>
 				</article>
 			</div>
 		 </div>


 		<script src="../lib/umbrella.min.js"></script>
   </body>
 </html>
