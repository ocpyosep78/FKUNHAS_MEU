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

if ($module=='info' AND $act=='hapus'){
  $f=mysql_fetch_array(mysql_query("SELECT iFile FROM info WHERE iId='$_GET[id]'"));
  if ($f[iFile]!=''){
	unlink("../../../fileinfo/$f[iFile]");   
  }
  mysql_query("DELETE FROM info WHERE iId='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

elseif ($module=='info' AND $act=='input'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	if (!empty($lokasi_file)){
		UploadInfo($nama_file_unik);
		$sqlUp = mysql_query("INSERT INTO info (iJudul, iFile, iIsi) VALUES (
						  '$_POST[iJudul]','$nama_file_unik','$_POST[iIsi]')");
	}else{
		$sqlUp = mysql_query("INSERT INTO info (iJudul, iIsi) VALUES (
						  '$_POST[iJudul]','$_POST[iIsi]')");
	}
	
	if ($sqlUp){
		echo "<script>alert ('Data Info disimpan');</script>";
	}else{
		echo "<script>alert ('Data Info gagal disimpan');</script>";
	}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}

elseif ($module=='info' AND $act=='edit'){
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	$tipe_file      = $_FILES['fupload']['type'];
	$nama_file      = $_FILES['fupload']['name'];
	$acak           = rand(1,99);
	$nama_file_unik = $acak.$nama_file; 
	
	if (!empty($lokasi_file)){
		$f=mysql_fetch_array(mysql_query("SELECT iFile FROM info WHERE iId='$_GET[id]'"));
		if ($f[iFile]!=''){
			unlink("../../../fileinfo/$f[iFile]");   
		}
		
		UploadInfo($nama_file_unik);
		$sqlUp = mysql_query("UPDATE info SET iJudul='$_POST[iJudul]', 
											  iFile='$nama_file_unik',
											  iIsi='$_POST[iIsi]'
											  WHERE iId='$_GET[id]'");
	}else{
		$sqlUp = mysql_query("UPDATE info SET iJudul='$_POST[iJudul]', 
											  iIsi='$_POST[iIsi]'
											  WHERE iId='$_GET[id]'");
	}
	if ($sqlUp){
		echo "<script>alert ('Data Info berhasil diubah');</script>";
	}else{
		echo "<script>alert ('Data Info gagal diubah');</script>";
	} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>