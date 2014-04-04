<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/fungsi_thumb.php";

$module=$_GET[module];
$act=$_GET[act];
if ($module=='soal' AND $act=='hapus'){
  mysql_query("DELETE FROM soal WHERE sId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='soal' AND $act=='input'){
	  	$sSoal=$_POST['sSoal'];
		$sJenis=$_POST['sJenis'];
		
		$sqlUp = mysql_query("insert into soal (sSoal, sJenis) VALUES ('$sSoal', '$sJenis')");
	if ($sqlUp)
		{
			echo "<script>alert ('Data soal berhasil disimpan');</script>";
		}
	else
		{
			echo "<script>alert ('Data soal gagal disimpan');</script>";
		}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='soal' AND $act=='update'){
$sId=$_POST['sId'];
$sSoal=$_POST['sSoal'];
$sJenis=$_POST['sJenis'];

	$sqlUp = mysql_query("UPDATE soal SET sSoal='$sSoal', sJenis='$sJenis' WHERE sId='$sId'");
	
	if ($sqlUp)
		{
			echo "<script>alert ('Data soal berhasil diubah');</script>";
		}
	else
		{
			echo "<script>alert ('Data soal gagal diubah');</script>";
		} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>