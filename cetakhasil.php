<?php
session_start();
include "config/koneksi.php";
$sqlJ = mysql_query("SELECT b.mkNama 
					FROM hasil a 
					LEFT JOIN matakuliah b ON a.mkId=b.mkId 
					WHERE a.taId='$_SESSION[taId]' and a.mNim='$_SESSION[issss]'");

if (($_SESSION['login']==1) and (mysql_num_rows($sqlJ)>=5))
{
date_default_timezone_set("Asia/Makassar");
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

<title>Fakultas Kedokteran Universitas Hasanuddin Makassar</title>
<?php
	include"config/library.php";
	include"config/fungsi_indotgl.php";  

	$tanggal = tgl_indo(date("Y-m-d"));
	$jam     = date("H:i:s");
	$hari_ini = $seminggu[$hari];
?>
	<div id="print">
		<table class='table1'>
		<tr>
			<td><img src='asset/img/unhas.png'></td>
			<td valign='middle'>
            	<H2>FAKULTAS KEDOKTERAN UNIVERSITAS HASANUDDIN</H2>
				<H3>EVALUASI MATA KULIAH (BLOK) OLEH MAHASISWA</H3>
            </td>
            <td>&nbsp;</td>
		</tr>
        <table>		
			<hr><strong>Fakultas Kedokteran Universitas Hasanuddin Makassar, Sulawesi Selatan</strong><hr>
			<br>
            	<?php
				echo "<div class='title>Makassar $hari_ini, $tanggal Jam: $jam</div><br>";
				echo "<h3>Bukti Hasil Evaluasi dosen Oleh Mahasiswa</h3>";
				$mahasiswa=mysql_query("SELECT * FROM mahasiswa WHERE mNim='$_SESSION[issss]'");
				$mhs=mysql_fetch_array($mahasiswa);
				if ($mhs[mJurusan]=="reg"){
					$jur="Regular";
				}else{
					$jur="Internasional";
				}
				?>

		<table border='0' class='table2'>
			<tr>
            	<td width='100px'>NIM</td>
            	<td width='30px'>:</td>
                <td><?php echo "$mhs[mNim]";?></td>
            </tr>
            <tr>
            	<td width='100px'>Nama</td>
                <td width='30px'>:</td>
                <td><?php echo "$mhs[mNama]";?></td>
            </tr>
			<tr>
            	<td>Jurusan</td>
                <td>:</td>
                <td><?php echo "$jur";?></td>
            </tr>
			<tr>
            	<td>Alamat</td>
                <td>:</td>
                <td><?php echo "$mhs[mAlamat]";?></td>
            </tr>
			<tr>
            	<td>No. HP</td>
                <td>:</td>
                <td><?php echo "$mhs[mHp]";?></td>
            </tr>
		</table>

	<table border='1'>
		<tr>
        	<th>No</th>
			<th>Nama Mata Kuliah/Blok Yang Telah Dievaluasi</th>
        </tr>
		<?php
			$sql=mysql_query("SELECT b.mkNama FROM hasil a 
							  LEFT JOIN matakuliah b ON a.mkId=b.mkId 
							  WHERE a.taId='$_SESSION[taId]' and a.mNim='$_SESSION[issss]'");
			while ($data=mysql_fetch_array($sql))
			{
				$no++;
		echo "
		<tr>
			<td align='right'>$no</td>
			<td>$data[mkNama]</td>
		</tr>";
			}
echo "</table>";
echo "<br>";

echo"<div class='ttd'>&nbsp;Hormat Kami,<br><br><br><br><strong>( ..................... ) </strong><br><br><br></div>";
echo"</div>";
}
else
{
	exit;
}
?>