<?php
include '../includes/db.php';
include '../includes/auth.php';

auth_guard();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$jenjang = $_POST['jenjang'];

	if ($jenjang == 'S1') {
		header("location: formS1.php ");
	}

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
  </head>
  <body class="pendaftaranS1">

  <nav class="demo">
    <div class="menu">
    <a href="#" id="daftar" class="pseudo button icon-picture">Membuat Pendaftaran</a>
  </div>

  </nav>
		<div id="app">
			<div class="middle">
				<article id="formS1" class="card pendaftaran">
					<header>
						<h3 align="center">FORM PEMILIHAN JENJANG UNTUK PENDAFTARAN S1</h3>
					</header>
					<footer>
						<form id="pelamar-diterima-form" role="form" method="post" action="daftar.php">
							<fieldset class="flex">
								<label>
									<h5>JENJANG</h5>
									<select name="jenjang"  >
										<option value="">Pilih Jenjang</option>
										<option value="S1">S1</option>
										<option value="S2">S2</option>
										<option value="S3">S3</option>
								</select>
								</label>
								<label>
							</fieldset>
							<div class="flex two three-600">
								<button type="submit"  class="off-half off-two-third-600" id="pilihJenjang">Pilih</button>
							</div>
						</form>
					</footer>
				</article>

			</div>
		</div>

	<script src="../lib/umbrella.min.js"></script>
  <script src="../lib/jquery-3.2.1.min.js"></script>
  <script src="formDaftar.js"></script>



  </body>
</html>
