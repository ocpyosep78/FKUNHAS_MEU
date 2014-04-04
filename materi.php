<?php
session_start();
date_default_timezone_set("Asia/Makassar");

if ($_SESSION[login]==1)
{  
	include"config/koneksi.php";
	$jur = array(
		'reg'=>'Reguler',
		'int'=>'Internasional'
	);
	switch($_GET[a])
	{
		default :
		?>
		<h3>Download Materi</h3>
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
					<button class="btn btn-primary" type='submit' name='cari'><i class="icon-search icon-white"></i> Show</button>
					</form>
					<br>
				</div>
			</div><!--/navbar-inner--> 
		</div><!--/navbar-->
		<hr>
		<?php		
		
		if (!isset($_POST[cari])){
			$qc = mysql_query("SELECT a.*, b.mkNama FROM filemateri a
							   LEFT JOIN matakuliah b ON a.mkId=b.mkId
							  ORDER BY a.fId DESC LIMIT 10");
			echo "<h3>Materi Terbaru<br></h3>";
			while($d=mysql_fetch_array($qc)){
				$j = $d[fJur];
				echo "<blockquote>
						<p><a href='?p=materi&a=detail&id=$d[fId]'>$d[fJudul]</a></p>
						<small>
							Blok : $d[mkNama] | Kelas : $jur[$j]<br>
						</small>
					  </blockquote>";
			}
		}else{
			$mk = $_POST[mk];			
			$qc = mysql_query("SELECT a.*, b.mkNama FROM filemateri a
							   LEFT JOIN matakuliah b ON a.mkId=b.mkId
							   WHERE a.mkId=$mk");
			
			if (mysql_num_rows($qc)<=0){
				echo "<br><center><h1>Data Tidak Ditemukan </h1></center>";
			}else{
				while($d=mysql_fetch_array($qc)){
					$j = $d[fJur];
					echo "<blockquote>
							<p><a href='filemateri/$d[fFile]'>$d[fJudul]</a></p>
							<small>
								Blok : $d[mkNama] | Kelas : $jur[$j] <br>
							</small>
						  </blockquote>";
				}					 
			}			
		}
		break;
		case "detail":
		?>
			<h3>View Materi</h3>
			<hr>
		<?php
			$qd = mysql_query("SELECT a.*, b.mkNama FROM filemateri a
							   LEFT JOIN matakuliah b ON a.mkId=b.mkId
							   WHERE a.fId='$_GET[id]'");
			while($v=mysql_fetch_array($qd)){
				$j = $v[fJur];
				echo "<h4>$v[fJudul]</h4>";
				echo "<h5>$v[mkNama] - $jur[$j]</h5><br>"; //<a href='filemateri/$v[fFile]'>Download</a></h5><br>";
				echo "<object data='filemateri/$v[fFile]' type='application/pdf' width='100%' height='600px'></object>";
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
		alert("Pilih mata kuliah..!!");
		form.mk.focus();
		return (false);
	}
	return (true);
   }
</script>