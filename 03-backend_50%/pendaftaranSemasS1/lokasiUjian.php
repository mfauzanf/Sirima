<?php

function connectDB() {
	$conn = pg_connect ("host=localhost dbname=muhammadfauzan54 user=postgres password=Yondu123");
		// Check connection
		if (!$conn) {
		die("Connection failed: " + pg_last_error());
		}
		return $conn;
}

if(isset($_POST['val'])) {
  $conn = connectDB();
		$kota = $_POST['val'];
		$result = pg_query($conn , "SELECT DISTINCT TEMPAT FROM tk_basdat_a02.LOKASI_UJIAN WHERE KOTA = '$kota'");
		echo "<option value=''>Pilih Tempat Ujian</option>";
		while($row = pg_fetch_array($result)){
			$tempat = $row['tempat'];
			echo "<option value='$tempat'>$tempat</option>";
		}
	}




 ?>
