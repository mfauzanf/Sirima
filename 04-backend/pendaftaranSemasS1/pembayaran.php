<?php
include '../includes/db.php';
include '../includes/auth.php';

auth_guard();

$idDaftar = $_GET['id'];
$_SESSION['postIDdaftar'] = $idDaftar ;
$date = date('Y-m-d H:i:s');
  

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIRIMA &middot; Pendaftaran S1</title>
		<link rel="stylesheet" href="pendaftaran.css">
    <link rel="stylesheet" href="../lib/picnic.min.css">
    <!-- <script type="text/javascript" src="formS1.js"></script> -->

  </head>
  <body id="pembayaran">

		 <div id="app">
			<div class="middle">
				<article class="card formS1">
					<header>
						<h3 align="center">FORM PEMBAYARAN</h3>
					</header>
					<footer>
						<form name="daftarS1" id="daftarS1" role="form" method="POST" action="bayarSukses.php">
							<fieldset class="flex two">
               <p>ID Pendaftaran : <?= $idDaftar ?>  </p>
               <p>Biaya pendaftaran : Rp. 500.000</p>
							</fieldset>
							<div class="flex two three-600">
								<button  class="off-half off-two-third-600" id="Bayar">Bayar</button>
							</div>
						</form>
					</footer>
				</article>
			</div>
		 </div>


		<script src="../lib/umbrella.min.js"></script>
  </body>
</html>
