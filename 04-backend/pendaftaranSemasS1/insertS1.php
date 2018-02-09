<?php
include '../includes/db.php';
include '../includes/auth.php';

auth_guard();




 

$koneksi = connectDB();

  if(isset($_POST['asal'])) {
    $asal = $_POST['asal'];
  }
  if(isset($_POST['jenis_sma'])) {
    $jenis_sma = $_POST['jenis_sma'];
  }
  if(isset($_POST['alamat_sekolah'])) {
    $alamat_sekolah = $_POST['alamat_sekolah'];
  }
  if(isset($_POST['nisn'])) {
    $nisn = $_POST['nisn'];
  }
  if(isset($_POST['tanggal_lulus'])) {
    $tanggal_lulus = $_POST['tanggal_lulus'];
  }
  if(isset($_POST['uan'])) {
    $uan = $_POST['uan'];
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

  $queryset = "SET search_path to tk_basdat_a02";
  pg_query($koneksi , $queryset);
  $query = "SELECT nomor, tahun FROM tk_basdat_a02.PERIODE_PENERIMAAN WHERE status_aktif = 'true'";

  $result = pg_query($koneksi , $query);

  $row = pg_fetch_array($result);
  $nomorPeriodeAktif = $row['nomor'];
  $tahunPeriodeAktif = $row['tahun'];
  $namaUser = $_SESSION['user'];
  $resulPendaftaran = pg_query($koneksi , "SELECT * from tk_basdat_a02.PENDAFTARAN");
  $idDaftar = pg_num_rows($resulPendaftaran) + 1;

  $queryInsertPendaftaran =  ("INSERT INTO tk_basdat_a02.PENDAFTARAN(id, status_verifikasi, pelamar, nomor_periode, tahun_periode) VALUES ('$idDaftar', 'true', '$namaUser', '$nomorPeriodeAktif', '$tahunPeriodeAktif')");
  pg_query($koneksi, $queryInsertPendaftaran);

$queryInsertPendaftaranSemas =  ("INSERT INTO tk_basdat_a02.PENDAFTARAN_SEMAS(id_pendaftaran, lokasi_kota, lokasi_tempat) VALUES ('$idDaftar', '$kota', '$tempat')");
   pg_query($koneksi, $queryInsertPendaftaranSemas);

$queryInsertPendaftaranSemasSarjana = ("INSERT INTO tk_basdat_a02.PENDAFTARAN_SEMAS_SARJANA (id_pendaftaran, asal_sekolah, jenis_sma, alamat_sekolah, nisn, tgl_lulus, nilai_uan) VALUES ('$idDaftar', '$asal', '$jenis_sma', '$alamat_sekolah', '$nisn', '$tanggal_lulus', '$uan')");
    pg_query($koneksi, $queryInsertPendaftaranSemasSarjana);

    $queryInsertPendaftaranprodi1= ("INSERT INTO tk_basdat_a02.PENDAFTARAN_PRODI(id_pendaftaran,kode_prodi) VALUES('$idDaftar','$prodi1')");
    pg_query($koneksi, $queryInsertPendaftaranprodi1);



    if(isset($_POST['prodi2']) && $_POST['prodi2'] != '') {
      $prodi2 = $_POST['prodi2'];
      $queryInsertPendaftaranprodi2 = ("INSERT INTO tk_basdat_a02.PENDAFTARAN_PRODI(id_pendaftaran,kode_prodi) VALUES('$idDaftar','$prodi2')");
      pg_query($koneksi, $queryInsertPendaftaranprodi2);
    }


    if(isset($_POST['prodi3']) && $_POST['prodi3'] != '') {
      $prodi3 = $_POST['prodi3'];
      $queryInsertPendaftaranprodi3 = ("INSERT INTO tk_basdat_a02.PENDAFTARAN_PRODI(id_pendaftaran,kode_prodi) VALUES('$idDaftar','$prodi3')");
      pg_query($koneksi, $queryInsertPendaftaranprodi3);
    }

    echo $idDaftar;

 ?>
