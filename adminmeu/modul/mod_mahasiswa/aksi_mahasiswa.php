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
if ($module=='mahasiswa' AND $act=='hapus'){
  mysql_query("DELETE FROM mahasiswa WHERE mNim='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input menu utama
elseif ($module=='mahasiswa' AND $act=='input'){
	  	$mNim=$_POST['mNim'];
		$mNama=$_POST['mNama'];
		$mJurusan=$_POST['mJur'];
		$mAngkatan=$_POST['mAngkatan'];
		$mTlahir = $_POST['mThn']."-".$_POST['mBln']."-".$_POST['mTgl'];
		$mAlamat=$_POST['mAlamat'];
		$mHp=$_POST['mHp'];
		$mEmail=$_POST['mEmail'];
		$mUsername=$_POST['mUsername'];
		$mPassword=$_POST['mPassword'];
		$mPasswordU=$_POST['mPasswordU'];

		$mPass=md5($mPassword);
		$sqlUp = mysql_query("insert into mahasiswa (mNim, mNama, mJurusan, mAngkatan, mTlahir, mAlamat, mHp, mEmail, mUsername, mPassword)
							  VALUES ('$mNim', '$mNama', '$mJurusan', '$mAngkatan', '$mTlahir', '$mAlamat', '$mHp', '$mEmail', '$mUsername', '$mPass')");
	if ($sqlUp)
		{
			echo "<script>alert ('Data Mahasiswa berhasil disimpan');</script>";
		}
	else
		{
			echo "<script>alert ('Data Mahasiswa gagal disimpan');</script>";
		}
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
// Update menu utama
elseif ($module=='mahasiswa' AND $act=='update'){
	$mNim=$_POST['mNim'];
	$mNama=$_POST['mNama'];
	$mJurusan=$_POST['mJur'];
	$mAngkatan=$_POST['mAngkatan'];
	$mTlahir = $_POST['mThn']."-".$_POST['mBln']."-".$_POST['mTgl'];
	$mAlamat=$_POST['mAlamat'];
	$mHp=$_POST['mHp'];
	$mEmail=$_POST['mEmail'];
	$mUsername=$_POST['mUsername'];
	$mPassword=$_POST['mPassword'];
	$mPasswordU=$_POST['mPasswordU'];

If(($mPassword=="") or ($mPassword==""))
	{
		$sqlUp = mysql_query("UPDATE mahasiswa SET 
								mNama='$mNama', 
								mJurusan='$mJurusan',
								mAngkatan='$mAngkatan',
								mTlahir='$mTlahir',
								mAlamat='$mAlamat', 
								mHp='$mHp', 
								mEmail='$mEmail', 
								mUsername='$mUsername' WHERE mNim='$mNim'");
	}
	else
	{
		$mPass=md5($mPassword);
		$sqlUp = mysql_query("UPDATE mahasiswa SET 
								mNama='$mNama', 
								mJurusan='$mJurusan', 
								mAngkatan='$mAngkatan',
								mTlahir='$mTlahir',
								mAlamat='$mAlamat', 
								mHP='$mHp', 
								mEmail='$mEmail', 
								mUsername='$mUsername', 
								mPassword='$mPass' WHERE mNim='$mNim'");
	}
	if ($sqlUp)
		{
			echo "<script>alert ('Data Mahasiswa berhasil diubah');</script>";
		}
	else
		{
			echo "<script>alert ('Data Mahasiswa gagal diubah');</script>";
		} 
	echo"<script> parent.location = \"../../media.php?module=$module\";</script>";
}
}
?>