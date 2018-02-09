<?php
session_start();
function connectDB() {
	$conn = pg_connect ("host=localhost dbname=muhammadfauzan54 user=postgres password=Yondu123");

		if (!$conn) {
		die("Connection failed: " + pg_last_error());
		}
		return $conn;
}

  if(isset($_POST['asal'])) {
    $asal = $_POST['asalSekolah'];
  }
	if(isset($_POST['jenis_sma'])) {
    $jenis_sma = $_POST['jenisSMA'];
  }
	if(isset($_POST['alamat_sekolah'])) {
    $alamat_sekolah = $_POST['alamatSekolah'];
  }
	if(isset($_POST['nisn'])) {
    $nisn = $_POST['nisn'];
  }
	if(isset($_POST['tanggal_lulus'])) {
    $tanggal_lulus = $_POST['tglLulus'];
  }
	if(isset($_POST['uan'])) {
    $uan = $_POST['nilaiUAN'];
  }
	if(isset($_POST['prodi1'])) {
    $prodi1 = $_POST['prodi1'];
  }

  if(isset($_POST['prodi2'])) {
    $prodi2 = $_POST['prodi2'];
  }

  if(isset($_POST['prodi3'])) {
    $prodi3 = $_POST['prodi3'];
  }
	if(isset($_POST['kota'])) {
    $kota = $_POST['kota'];
  }
	if(isset($_POST['tempat'])) {
    $tempat = $_POST['tempat'];
  }


  $query = "select nomer,tahun from tk_basdat_a02.periode_penerimaan where status_aktif = true";
  $result = pg_query($connection , $query);
	$row = pg_fetch_array($result);
	$nomorPeriodeAktif = $row['nomor'];
	$tahunPeriodeAktif = $row['tahun'];
  $nama = $_SESSION['user'];
  $result = pg_query($conn , "SELECT * from tk_basdat_a02.pendaftaran");
  $idDaftar = pg_num_rows($result) +1;
  $queryInsertPendaftaran = " insert INTO tk_basdat_a02.PENDAFTARAN (id,status_lulus,status_verifikasi,pelamar,nomor_periode,tahun_periode) VALUES ($idDaftar, false,TRUE,$nama,$nomorPeriodeAktif,$tahunPeriodeAktif')";
  $queryInsertPendaftaranSemas = "insert into tk_basdat_a02.PENDAFTARAN_SEMAS(id_pendaftaran,status_hadir,nilai_ujian,no_kartu_ujian,lokasi_kota,lokasi_tempat) VALUES ($idDaftar,false,$uan,$npm,$kota,$tempat)";
$queryInsertPendaftaranSemasSarjana = "insert into tk_basdat_a02.PENDAFTARAN_SEMAS_SARJANA (id_pendaftaran,asal_sekolah,jenis_sma,alamat_sekolah,nisn,tgl_lulus,nilai_uan) VALUES ($idDaftar,$asal,$jenis_sma,$alamat_sekolah,$nisn,$tanggal_lulus,$uan)";
  $queryInsertPendaftaranprodi1 = "insert into tk_basdat_a02.PENDAFTARAN_PRODI(id_pendaftaran,kode_prodi)VALUES($idDaftar,prodi1)";
  $queryInsertPendaftaranprodi2 = "insert into tk_basdat_a02.PENDAFTARAN_PRODI(id_pendaftaran,kode_prodi)VALUES($idDaftar,prodi2)";
  $queryInsertPendaftaranprodi3 = "insert into tk_basdat_a02.PENDAFTARAN_PRODI(id_pendaftaran,kode_prodi)VALUES($idDaftar,prodi3)";


 ?>
