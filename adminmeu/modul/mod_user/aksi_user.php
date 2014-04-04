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
if ($module=='user' AND $act=='hapus'){
  mysql_query("DELETE FROM user WHERE uId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='user' AND $act=='input'){
		$uNama=$_POST['uNama'];
		$uLevel=$_POST['uLevel'];
		$uUsername=$_POST['uUsername'];
		$uPassword=$_POST['uPassword'];
		$uPasswordU=$_POST['uPasswordU'];

		$uPass=md5($uPassword);
		$sqlUp = mysql_query("insert into user (uNama, uLevel, uUsername, uPassword) VALUES ('$uNama', '$uLevel', '$uUsername', '$uPass')");
	if ($sqlUp)
		{
			echo "<script>alert ('Data User berhasil disimpan');</script>";
		}
	else
		{
			echo "<script>alert ('Data User gagal disimpan');</script>";
		}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='user' AND $act=='update'){
		$uNama=$_POST['uNama'];
		$uLevel=$_POST['uLevel'];
		$uUsername=$_POST['uUsername'];
		$uPassword=$_POST['uPassword'];
		$uPasswordU=$_POST['uPasswordU'];
		$uId=$_POST['uId'];

If(($uPassword=="") or ($uPassword==""))
	{
		$sqlUp = mysql_query("UPDATE user SET uNama='$uNama', uLevel='$uLevel', uUsername='$uUsername' WHERE uId='$uId'");
	}
	else
	{
		$uPass=md5($uPassword);
		$sqlUp = mysql_query("UPDATE user SET uNama='$uNama', uLevel='$uLevel', uUsername='$uUsername', uPassword='$uPass' WHERE uId='$uId'");
	}
	if ($sqlUp)
		{
			echo "<script>alert ('Data user berhasil diubah');</script>";
		}
	else
		{
			echo "<script>alert ('Data user gagal diubah');</script>";
		} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>