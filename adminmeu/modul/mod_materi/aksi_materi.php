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

if ($module=='materi' AND $act=='hapus'){
  $f=mysql_fetch_array(mysql_query("SELECT fFile FROM filemateri WHERE fId='$_GET[id]'"));
  if ($f[fFile]!=''){
	unlink("../../../filemateri/$f[fFile]");   
  }
  mysql_query("DELETE FROM filemateri WHERE fId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='materi' AND $act=='input'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	
	UploadFile($nama_file_unik);
	
	$sqlUp = mysql_query("INSERT INTO filemateri (fJudul, fFile, fJur, mkId) VALUES (
						  '$_POST[fJudul]', '$nama_file_unik', '$_POST[fJur]', '$_POST[mkId]')");
	if ($sqlUp){
		echo "<script>alert ('Data File Materi disimpan');</script>";
	}else{
		echo "<script>alert ('Data File Materi gagal disimpan');</script>";
	}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='materi' AND $act=='edit'){
	$sqlUp = mysql_query("UPDATE filemateri SET fJudul='$_POST[fJudul]', 
										       fJur='$_POST[fJur]',
											   mkId='$_POST[mkId]' WHERE fId='$_GET[id]'");
	if ($sqlUp){
		echo "<script>alert ('Data File Materi berhasil diubah');</script>";
	}else{
		echo "<script>alert ('Data File Materi gagal diubah');</script>";
	} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>