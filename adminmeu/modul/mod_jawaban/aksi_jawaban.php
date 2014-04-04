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
if ($module=='jawaban' AND $act=='hapus'){
  mysql_query("DELETE FROM jawaban WHERE jId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='jawaban' AND $act=='input'){
	  	$jJawaban=$_POST['jJawaban'];
		$jJenis=$_POST['jJenis'];
		
		$sqlUp = mysql_query("insert into jawaban (jJawaban, jJenis) VALUES ('$jJawaban','$jJenis')");
	if ($sqlUp)
		{
			echo "<script>alert ('Data jawaban berhasil disimpan');</script>";
		}
	else
		{
			echo "<script>alert ('Data jawaban gagal disimpan');</script>";
		}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='jawaban' AND $act=='update'){
$jId=$_POST['jId'];
$jJawaban=$_POST['jJawaban'];
$jJenis=$_POST['jJenis'];

	$sqlUp = mysql_query("UPDATE jawaban SET jJawaban='$jJawaban', jJenis='$jJenis' WHERE jId='$jId'");
	
	if ($sqlUp)
		{
			echo "<script>alert ('Data jawaban berhasil diubah');</script>";
		}
	else
		{
			echo "<script>alert ('Data jawaban gagal diubah');</script>";
		} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>