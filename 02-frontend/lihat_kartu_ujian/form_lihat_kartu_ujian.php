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
				<header>
					<center>
					<h3 align="center">FORM LIHAT KARTU UJIAN</h3>
					</center>
				</header>
				<footer>
					<form id="id-pendaftaran-form" role="form" method="post" action="form_lihat_kartu_ujian.php">
						<fieldset class="flex">
							<label>
							<h5>ID PENDAFTARAN</h5>
								<input type="text" name="id-pendaftar" value="">
							</label>
						</fieldset>
						<div class="flex two three-600">
							<a href="kartu_ujian.php" type="submit" class="off-half off-two-third-600" id="lihatid">LIHAT</a>
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
