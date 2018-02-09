<?php
function connectDB() {
	$conn = pg_connect ("host=localhost dbname=muhammadfauzan54 user=postgres password=Yondu123");
		// Check connection
		if (!$conn) {
		die("Connection failed: " + pg_last_error());
		}
		return $conn;
}


function selectAllProdiS1() {
  $conn = connectDB();

  $query = "select nama,jenis_kelas from tk_basdat_a02.PROGRAM_STUDI where jenjang = 'S1' and  exists (select nomor_periode,tahun_periode,kode_prodi from tk_basdat_a02.PENERIMAAN_PRODI where exists (select tahun from tk_basdat_a02.periode_penerimaan where status_aktif = true))";

  if(!$result = pg_query($conn, $query)) {
    die("Error: $query");
  }
  pg_close($conn);
  return $result;
}




function selectKotaS1() {
    $conn = connectDB();
    $query = "select kota from tk_basdat_a02.lokasi_jadwal where jenjang = 'S1'";
    if(!$result = pg_query($conn, $query)) {
      die("Error: $query");
    }
      pg_close($conn);

    return $result;
}




// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// 	$jenjang = $_POST['jenjang'];
//
// 	if ($jenjang == 'S1') {
// 		header("location: formS1.php ");
// 	}
//
// }




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
  <body>
		 <div id="app">
			<div class="middle">
				<article class="card formS1">
					<header>
						<h3 align="center">FORM PENDAFTARAN SEMAS SARJANA</h3>
					</header>
					<footer>
						<form name="daftarS1" id="daftarS1" role="form" method="post" action="">
							<fieldset class="flex two">

                <label id="sekolah">
                  <h5>Asal Sekolah</h5>
                <input id="asalSekolah" type="text" placeholder="Asal Sekolah" required>

                </label>
                <p class="warning" id="asalSekolahError"></p>


								<label id="SMA">
									<h5>Jenis SMA</h5>
									<select id='jenisSMA' required>
										<option value="">Pilih Jenis</option>
										<option value="IPA">IPA</option>
										<option value="IPS">IPS</option>
                    <option value="Bahasa">Bahasa</option>

								</select>
                <label class="warning" id="jenisError"></label>
								</label>

                <label>
                  <h5>Alamat Sekolah</h5>
             <input id="alamatSekolah" type="text" placeholder="Alamat Sekolah" required>
                  <label class="warning" id="alamatError"></label>
                </label>

                <label for="nisn" >
                  <h5>NISN</h5>
     <input type="text" id="nisn" name="nisn" placeholder="NISN" required>
                  <label  class="warning" id="nisnError"></label>
                </label>


                <label>
                  <h5>Tanggal Lulus</h5>
                  <input id="tglLulus" type="date" placeholder="Tanggal Lulus" required>
                <label class="warning" id="tglError"></label>
                </label>

                <label >
                  <h5>Nilai UAN</h5>
               <input id="nilaiUAN" name="nilaiUAN" type="text" placeholder="Nilai UAN" required>
           <label class="warning" id="uanError"></label>
                </label>


                <label id="Prodi Pilihan 1">
                  <h5>Prodi Pilihan 1 (Wajib Diisi)</h5>
                  <select id="pilihan1" required>
                    <option  disabled selected value="-">Pilih Prodi</option>
                    <?php
                       $prodi = selectAllProdiS1();
                      while ($row = pg_fetch_array($prodi)) {
                        echo '<option value="'.$row[0].'-'.$row[1].'">'.$row[0].'-'.$row[1].'</option>';
                      }
                     ?>
                 </select>
                 <label class="warning" id="prodi1"></label>
                </label>

                <label id="Prodi Pilihan 2">
                  <h5>Prodi Pilihan 2</h5>
                  <select id="pilihan2" name="prodi2">
                    <option  disabled selected value="-">Pilih Prodi</option>
                    <?php
                       $prodi = selectAllProdiS1();
                      while ($row = pg_fetch_array($prodi)) {
                        echo '<option value="'.$row[0].'-'.$row[1].'">'.$row[0].'-'.$row[1].'</option>';
                      }
                     ?>
								</select>
                <label class="warning" id="prodi2"></label>
                </label>

                <label id="Prodi Pilihan 3">
                  <h5>Prodi Pilihan 3</h5>
                  <select id="pilihan3" name="prodi3">
                    <option disabled selected value="-">Pilih Prodi</option>
                    <?php
                       $prodi = selectAllProdiS1();
                      while ($row = pg_fetch_array($prodi)) {
                        echo '<option value="'.$row[0].'-'.$row[1].'">'.$row[0].'-'.$row[1].'</option>';
                      }
                     ?>
								</select>
                <label class="warning" id="prodi3"></label>
                </label>

                <label id="kotaUjian">
                  <h5>Lokasi Kota Ujian</h5>
                  <select id="pilihKota" required>
                    <option value="">Pilih Kota Ujian</option>
                    <?php
                       $kota = selectKotaS1();
                      while ($row = pg_fetch_array($kota)) {
                        // echo '<option value=$row>$row</option>';
                        echo "<option value='".$row[0]."'>$row[0]</option>";
                      }
                     ?>
								</select>
                 <label class="warning" id="kotaError"></label>
                </label>

                <label id="tempatUjian">
                  <h5>Lokasi Tempat Ujian</h5>
                  <select id="pilihTempat" required>
                    <option value="">Pilih Tempat Ujian</option>

                </select>
                <label class="warning" id="tempatError"></label>
                </label>
							</fieldset>
							<div class="flex two three-600">
								<button type="button" class="off-half off-two-third-600" id="simpanData">Simpan</button>
							</div>
						</form>
					</footer>
				</article>
			</div>
		 </div>


	<script src="../lib/umbrella.min.js"></script>
  <script src="../lib/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="formDaftar.js"></script>



  </body>
</html>
