<?php
session_start();
date_default_timezone_set("Asia/Makassar");

if ($_SESSION[login]==1)
{  
	include"config/koneksi.php";
	$sms = array(
		'1'=>'Ganjil',
		'2'=>'Genap'
	);
	$jur = array(
		'reg'=>'Reguler',
		'int'=>'Internasional'
	);
	switch($_GET[a])
	{
		default :
		?>
		<h3>Jadwal</h3>
		<hr>
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">Search</a>
					<form class="navbar-form pull-right" method='post' onsubmit='return cekKondisi(this);'>
						<select name="mk" id='mk'>
							<option value="">---Pilih Mata Kuliah---</option>
							<?php
								$qmk=mysql_query("SELECT * FROM matakuliah");
								while($dmk=mysql_fetch_array($qmk))
								{
									echo "<option value='$dmk[mkId]'>$dmk[mkNama]</option>";
								}
							?>
						</select>
						<select name="ta" id='ta'>
							<option value="">---Pilih Tahun Ajaran---</option>
							<?php
								$qta=mysql_query("SELECT * FROM tahunajaran");
								while($dta=mysql_fetch_array($qta))
								{
									$s=$dta[taSemester];
									echo "<option value='$dta[taId]'>$dta[taNama] - $sms[$s]</option>";
								}
							?>
						</select>
					<button class="btn btn-primary" type='submit' name='cari'><i class="icon-search icon-white"></i> Show</button>
					</form>
					<br>
				</div>
			</div><!--/navbar-inner--> 
		</div><!--/navbar-->
		<hr>
		<?php		
		
		if (!isset($_POST[cari])){
			$qc = mysql_query("SELECT a.*, b.mkNama, c.taNama, c.taSemester FROM jadwal a
							   LEFT JOIN matakuliah b ON a.mkId=b.mkId
							   LEFT JOIN tahunajaran c ON a.taId=c.taId
							  ORDER BY a.jdId DESC LIMIT 10");
			while($d=mysql_fetch_array($qc)){
				$s = $d[taSemester];
				$j = $d[jdJur];
				echo "<blockquote>
						<p><a href='filejadwal/$d[jdFile]'>$d[mkNama] - $jur[$j] - $d[taNama] ($sms[$s])</a></p>
					  </blockquote>";
			}
		}else{
			$mk = $_POST[mk];
			$ta = $_POST[ta];
			$qc = mysql_query("SELECT a.*, b.mkNama, c.taNama, c.taSemester FROM jadwal a
							   LEFT JOIN matakuliah b ON a.mkId=b.mkId
							   LEFT JOIN tahunajaran c ON a.taId=c.taId
							   WHERE a.mkId=$mk AND a.taId=$ta");
			
			if (mysql_num_rows($qc)<=0){
				echo "<br><center><h1>Jadwal Belum Ada </h1></center>";
			}else{
				while($d=mysql_fetch_array($qc)){
					$s = $d[taSemester];
					$j = $d[jdJur];
					echo "<blockquote>
						<p><a href='filejadwal/$d[jdFile]'>$d[mkNama] - $jur[$j] - $d[taNama] ($sms[$s])</a></p>
					  </blockquote>";
				}					 
			}			
		}
		break;
	}
}else{
	echo"<script>parent.location ='index.php';</script>";
}
?>

<script type="text/javascript">  
   function cekKondisi(form){ 
	if (form.mk.value == ""){
		alert("Blok/Mata Kuliah belum dipilih..!");
		form.mk.focus();
		return (false);
	}
	if (form.ta.value == ""){
		alert("Tahun Ajaran belum dipilih..!!");
		return (false);
		form.ta.focus();
	}
	return (true);
   }
</script>