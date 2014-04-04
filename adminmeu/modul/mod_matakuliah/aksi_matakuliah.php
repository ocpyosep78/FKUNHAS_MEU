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
if ($module=='matakuliah' AND $act=='hapus'){
  mysql_query("DELETE FROM matakuliah WHERE mkId=$_GET[id]");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='matakuliah' AND $act=='input'){
	  	$
		$mkNama=$_POST['mkNama'];
		
		$sqlUp = mysql_query("INSERT into matakuliah (mkNama) VALUES ('$_POST[mkNama]')");
	if ($sqlUp)
		{
			echo "<script>alert ('Data Matakuliah berhasil disimpan');</script>";
		}
	else
		{
			echo "<script>alert ('Data Matakuliah gagal disimpan');</script>";
		}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='matakuliah' AND $act=='update'){
$mkId=$_POST['mkId'];
$mkNama=$_POST['mkNama'];

	$sqlUp = mysql_query("UPDATE matakuliah SET mkNama='$mkNama' WHERE mkId='$mkId'");
	
	if ($sqlUp)
		{
			echo "<script>alert ('Data Matakuliah berhasil diubah');</script>";
		}
	else
		{
			echo "<script>alert ('Data matakuliah gagal diubah');</script>";
		} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>