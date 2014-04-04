<?php 
	session_start();
	//date_default_timezone_set('Asia/Jakarta');
 	include "config/koneksi.php";
	$username = htmlentities($_POST[user]);
	$password = md5(htmlentities($_POST[pass]));
	$login = mysql_query("select * from mahasiswa WHERE mUsername='$username' and mPassword='$password'");
	$cek = mysql_num_rows($login);
	$sess = mysql_fetch_array($login);
	
	if($cek>0){
		$_SESSION[login]=1;
		$_SESSION[issss]=$sess[mNim];
		$_SESSION[user_id]=$sess[mUsername];
		$_SESSION[nama]=$sess[mNama];
		$_SESSION[jurusan]=$sess[mJurusan];
		$ta=mysql_query("select taId from tahunajaran WHERE taStatus='1'");
		$taSts=mysql_fetch_array($ta);
		$_SESSION[taId]=$taSts[taId];
		echo "<script>
			alert('Selamat Datang $_SESSION[user_id]');
			parent.location = 'index.php?pages=home&act=kuesioner';
			</script>";
			
	}else{
		echo "<script>
			alert('Maaf Username dan Password Salah');
			parent.location='index.php';
			</script>";	
	}
?>
