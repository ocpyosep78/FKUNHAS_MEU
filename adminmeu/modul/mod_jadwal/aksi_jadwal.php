<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}else{
include "../../../config/koneksi.php";
include "../../../config/fungsi_thumb.php";

$module=$_GET[module];
$act=$_GET[act];

if ($module=='jadwal' AND $act=='hapus'){
  $f=mysql_fetch_array(mysql_query("SELECT jdFile FROM jadwal WHERE jdId='$_GET[id]'"));
  if ($f[jdFile]!=''){
	unlink("../../../filejadwal/$f[jdFile]");   
  }
  mysql_query("DELETE FROM jadwal WHERE jdId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='jadwal' AND $act=='input'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	
	UploadJadwal($nama_file_unik);
	
	$sqlUp = mysql_query("INSERT INTO jadwal (jdFile, jdJur, mkId, taId) VALUES (
						  '$nama_file_unik', '$_POST[jdJur]', '$_POST[mkId]', '$_POST[taId]')");
	if ($sqlUp){
		echo "<script>alert ('Data Jadwal disimpan');</script>";
	}else{
		echo "<script>alert ('Data Jadwal gagal disimpan');</script>";
	}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='jadwal' AND $act=='edit'){
	$sqlUp = mysql_query("UPDATE jadwal SET jdJur='$_POST[jdJur]',
											mkId='$_POST[mkId]', 
											taId='$_POST[taId]' WHERE jdId='$_GET[id]'");
	if ($sqlUp){
		echo "<script>alert ('Data Jadwal berhasil diubah');</script>";
	}else{
		echo "<script>alert ('Data Jadwal gagal diubah');</script>";
	} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>