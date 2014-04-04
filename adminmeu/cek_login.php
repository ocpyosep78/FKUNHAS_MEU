<?php
include "koneksi.php";
function antiinjection($data){
  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;
}

$username = antiinjection($_POST[username]);
$pass     = antiinjection($_POST[password]);

session_start();
$uPas=md5($pass);
$login=mysql_query("SELECT * FROM user WHERE uUsername='$username' AND uPassword='$uPas' ");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);
// Apabila username dan password ditemukan
if ($ketemu > 0){
	$time= date("H:i:s");
	//$time_log = mysql_query("Update user SET time_log='$time' WHERE user_id='$username' AND password='$pass' ");
  session_start();
  session_register("user_id");
  session_register("password");
  session_register("nama");
  session_register("level");

  $_SESSION[user_id]     = $r[uUsername];
  $_SESSION[password]  = $r[uPassword];
  $_SESSION[nama]     = $r[uNama];
  $_SESSION[level]    = $r[uLevel];
  $ta=mysql_query("select taId from tahunajaran WHERE taStatus='1'");
		$taSts=mysql_fetch_array($ta);
		$_SESSION[AtaId]=$taSts[taId];
  
  header('location:media.php?module=home');
}
else{
echo "<link href='css/screen.css' rel='stylesheet' type='text/css'><link href='css/reset.css' rel='stylesheet' type='text/css'>";
  echo "<center><br><br><br><br><br><br><b>LOGIN GAGAL! </b><br> 
        Username atau Password Anda tidak benar.<br>
        Atau account Anda sedang diblokir.<br><br>";
		echo "<div> <a href='beranda.html'><img src='images/seru.png'  height=147 width=176><br><br></a>
             </div>";
  echo "<input type=button class='tombol' value='ULANGI LAGI' onclick=self.history.back();></a></center>";

}
//header('location:media.php?module=home');
?>
