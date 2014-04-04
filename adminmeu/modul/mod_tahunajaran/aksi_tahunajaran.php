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

if ($module=='tahunajaran' AND $act=='hapus'){
  mysql_query("DELETE FROM tahunajaran WHERE taId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
elseif ($module=='tahunajaran' AND $act=='a'){
  mysql_query("UPDATE tahunajaran SET taStatus='0'");
  mysql_query("UPDATE tahunajaran SET taStatus='1' WHERE taId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='tahunajaran' AND $act=='input'){
	  	$taNama=$_POST['taNama'];
		$taSemester=$_POST['taSemester'];
		
		$sqlUp = mysql_query("insert into tahunajaran (taNama, taSemester) VALUES ('$taNama', '$taSemester')");
	if ($sqlUp)
		{
			echo "<script>alert ('Data tahun ajaran berhasil disimpan');</script>";
		}
	else
		{
			echo "<script>alert ('Data tahun ajaran gagal disimpan');</script>";
		}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='tahunajaran' AND $act=='update'){
$taId=$_POST['taId'];
$taNama=$_POST['taNama'];
$taSemester=$_POST['taSemester'];

	$sqlUp = mysql_query("UPDATE tahunajaran SET taNama='$taNama', taSemester='$taSemester' WHERE taId='$taId'");
	
	if ($sqlUp)
		{
			echo "<script>alert ('Data tahun ajaran berhasil diubah');</script>";
		}
	else
		{
			echo "<script>alert ('Data tahun ajaran gagal diubah');</script>";
		} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>