<?php
session_start();
include "../../koneksi.php";
include"../../../config/library.php";
include"../../../config/fungsi_indotgl.php";  

if ($_SESSION['level']=='admin')
{
	date_default_timezone_set("Asia/Makassar");
	$taId=$_GET['t'];
	$mkId=$_GET['m'];
?>

<script type="text/javascript">
window.print() 
</script>

<style type="text/css">
#print {
	margin:auto;
	border:1px solid #2A9FAA;
	text-align:center;
	font-family:"Courier New", Courier, monospace;
	width:900px;
	font-size:14px;
}
#print .title {
	margin:auto;
	text-align:right;
	font-family:"Courier New", Courier, monospace;
	font-size:12px;
}
#print span {
	text-align:center;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;	
	font-size:18px;
}
#print table {
	border-collapse:collapse;
	width:95%;
	margin:20px;
}
#print .table1 {
	border-collapse:collapse;
	width:100%;
	text-align:center;
}
#print .table2 {
	margin:20px;
	border-collapse:collapse;;
	width:auto;
}
#print table hr {
	border:1px dashed #A0A0A4;	
}
#print .ttd {
	margin-right:500px;
}
#print table th {
	background:#A0A0A4;
	color:#000;
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	font:normal;
	text-transform:uppercase;
	height:30px;
}

#print .grand {
	width:700px;
	padding:10px;
	text-align:left;	
}
#print .grand table {
	margin-left:-90px;	
}
#logo{
	width:111px;
	height:90px;
	padding-top:10px;	
	margin-left:10px;
}
</style>

<title>Kuesioner Online Fakultas Kedokteran Universitas Hasanuddin</title>
<?php

	$tanggal = tgl_indo(date("Y-m-d"));
	$jam     = date("H:i:s");
	$hari_ini = $seminggu[$hari];
	
?>
	<div id="print">
		<table class='table1'>
		<tr>
			<td><img src='../../../images/unhas.png'></td>
			<td valign='middle'>
            	<H2>FAKULTAS KEDOKTERAN UNIVERSITAS HASANUDDIN</H2>
				<H3>EVALUASI MATA KULIAH / BLOK OLEH MAHASISWA</H3>
            </td>
		</tr>
        <table>		
			<hr><strong>Fakultas Kedokteran Universitas Hasanuddin Makassar, Sulawesi Selatan</strong><hr>
            	<?php
				echo "<div align='right'>Makassar, $hari_ini $tanggal</div>";
				echo "<h3>Rekapitulasi Hasil Evaluasi</h3>";
				$mKul = mysql_fetch_array(mysql_query("SELECT mkNama FROM matakuliah WHERE mkId=$mkId"));
				$prd = mysql_fetch_array(mysql_query("SELECT taNama, taSemester FROM tahunajaran WHERE taId=$taId"));
				$jhasil = mysql_num_rows(mysql_query("SELECT * FROM hasil WHERE taId=$taId AND mkId=$mkId"));

				if ($prd['taSemester']%2==0){
					$sms = "Genap";
				}else{
					$sms = "Ganjil";
				}
				?>

		<table border='0' class='table2'>
			<tr>
            	<td width='300px'>Nama Mata Kuliah / Blok</td>
            	<td width='30px'>:</td>
                <td><?php echo "$mKul[mkNama]";?></td>
            </tr>
            <tr>
            	<td width='300px'>Periode</td>
                <td width='30px'>:</td>
                <td><?php echo "$prd[taNama]";?></td>
            </tr>
			<tr>
            	<td>Semester</td>
                <td>:</td>
                <td><?php echo "$sms";?></td>
            </tr>
			<tr>
            	<td>Jumlah Dievaluasi</td>
                <td>:</td>
                <td><?php echo "$jhasil";?></td>
            </tr>
		</table>
<?php		
			
			//batas tampilkan soal jenis a dan jawaban jenis a
			echo "<table border='1'>
			<tr>
            	<th align='center'>No</td>
				<th align='center' width='500px'>Soal</td>";
				$qa=mysql_query("SELECT jId,jJawaban FROM jawaban WHERE jJenis='A'");
				while($a=mysql_fetch_array($qa))
				{
					echo "<th align='center'>$a[jJawaban]</td>";
				}
			echo "</tr>";	
			
			
			//not a spaghetti code (doh) for soal a (1-3)
 			for ($i=1;$i<=3;$i++){
				$x[$i]="h".$i;
			}
			
			while (list($sId,$fld)=each($x)){
				$qh=mysql_query("SELECT sId, sSoal, 
								(SELECT COUNT($fld) FROM hasil WHERE $fld=6 AND mkId=$mkId AND taId=$taId) AS A,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=7 AND mkId=$mkId AND taId=$taId) AS B,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=8 AND mkId=$mkId AND taId=$taId) AS C,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=9 AND mkId=$mkId AND taId=$taId) AS D
								 FROM soal WHERE sId=$sId");
				$dh=mysql_fetch_array($qh);
				echo "
					<tr align='center'>
				   	  <td>$dh[sId]</td>
					  <td align='justify'>$dh[sSoal]</td>
					  <td>$dh[A]</td>
					  <td>$dh[B]</td>
					  <td>$dh[C]</td>
					  <td>$dh[D]</td>
					</tr>";
			}
			//not spaghetti code (doh)
				  
				  
			echo "</table>";
			//batas tampilkan soal jenis a dan jawaban jenis a
			
			
			//batas tampilkan soal jenis b dan jawaban jenis b
			echo "<table border='1'>
			<tr>
            	<th align='center'>No</td>
				<th align='center' width='500px'>Soal</td>";
				$qa=mysql_query("SELECT jJawaban FROM jawaban WHERE jJenis='B'");
				while($a=mysql_fetch_array($qa))
				{
					echo "<th align='center'>$a[jJawaban]</td>";
				}
			echo "</tr>";			
			
			//not a spaghetti code (doh) for soal b (4-18)
 			for ($i=4;$i<=18;$i++){
				$x[$i]="h".$i;
			}
			
			while (list($sId,$fld)=each($x)){
				$qh=mysql_query("SELECT sId, sSoal, 
								(SELECT COUNT($fld) FROM hasil WHERE $fld=1 AND mkId=$mkId AND taId=$taId) AS A,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=2 AND mkId=$mkId AND taId=$taId) AS B,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=3 AND mkId=$mkId AND taId=$taId) AS C,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=4 AND mkId=$mkId AND taId=$taId) AS D,
								(SELECT COUNT($fld) FROM hasil WHERE $fld=5 AND mkId=$mkId AND taId=$taId) AS E
								 FROM soal WHERE sId=$sId");
				$dh=mysql_fetch_array($qh);
				echo "
					<tr align='center'>
				   	  <td>$dh[sId]</td>
					  <td align='justify'>$dh[sSoal]</td>
					  <td>$dh[A]</td>
					  <td>$dh[B]</td>
					  <td>$dh[C]</td>
					  <td>$dh[D]</td>
					  <td>$dh[E]</td>
					</tr>";
			}
			//not spaghetti code (doh)
			echo "</table><br>";
			//batas tampilkan soal jenis b dan jawaban jenis b
}
else
{
	exit;
}
?>