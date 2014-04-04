<?php
session_start();
date_default_timezone_set("Asia/Makassar");

if ($_SESSION[login]==1)
{  
	include"config/koneksi.php";
	switch($_GET[a])
	{
		default : 
		?>
			<h3>Daftar Kuesioner</h3>
			<hr>
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="#">Pilih Mata Kuliah Untuk Di Evaluasi</a>
						<form class="navbar-form pull-right" method='post'  onsubmit="return cek(this);" action="?p=kuesioner&a=start">
							<select name="mk" id='mk'>
								<option value="">---Pilih Mata Kuliah---</option>
								<?php
									$mk=mysql_query("SELECT * FROM matakuliah  
													WHERE mkId NOT IN (SELECT mkId FROM hasil 
													WHERE taId='$_SESSION[taId]' and mNim='$_SESSION[issss]')");
									while($dmk=mysql_fetch_array($mk))
									{
										echo "<option value='$dmk[mkId]'>$dmk[mkNama]</option>";
									}
								?>
							</select>
							<button class="btn btn-primary" type='submit' name='proses'><i class="icon-search icon-white"></i> Pilih</button>
						</form><br>
					</div>
				</div><!--/navbar-inner--> 
			</div><!--/navbar-->
			<hr>
			<p class="text-info">
				<marquee behavior="scroll">
				<span class="label label-important">Untuk mencetak bukti pengisiian form evaluasi, anda minimal harus mengisi 5 (lima) 	Mata kuliah</span>
				</marquee>
			</p>
			<hr>
			<?php
				$sql = mysql_query("SELECT b.mkNama 
									FROM hasil a 
									LEFT JOIN matakuliah b ON a.mkId=b.mkId 
									WHERE a.taId='$_SESSION[taId]' and a.mNim='$_SESSION[issss]'");
			?>
			<table class="table table-bordered table-hover" width="80%" align="center">
			<thead>
				<tr>
					<th align="center">No</th>
					<th align="center">Blok/Mata Kuliah</th>
				</tr>
			</thead>
			<?php
				if (mysql_num_rows($sql)<=0){
					echo "<tr class='error'>
							<td colspan='3'>
								<marquee behavior='alternate'>
								<font color='red'>Anda belum mengisi Kuesioner Semester ini </font>
								</marquee>
							</td>
						  </tr>";
				}else{
					while ($l=mysql_fetch_array($sql)){
						$no++;
						echo "<tr>
								<td>$no</td>
								<td>$l[mkNama]</td>
							</tr>";
					}
				}
			?>				   
			</table>
			<?php
				if (mysql_num_rows($sql)>=5){
					echo "<br>
							<center>
								<a href='cetakhasil.php' target='_blank' class='button'>
									<img src='asset/img/cetak.png' title='Cetak Bukti Pengisian Kuesioner'>
								</a>
							</center>
						  <br>";
				}
			break;	
		case "start" : 
		?>	
			<form method='POST' action='?p=kuesioner&a=finish' onSubmit='return cekKui(this);'>
			<div class="navbar navbar-inverse">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="#"> Soal Evaluasi</a>
					</div>
				</div><!--/navbar-inner--> 
			</div><!--/navbar-->
			<hr>
			<?php
				$mkId=$_POST['mk'];
				echo "<input type='hidden' name='mkId' value='$mkId'>";
				$ssoal = mysql_query("SELECT mkId, mkNama FROM matakuliah WHERE mkId='$mkId'");
				$datasoal=mysql_fetch_array($ssoal);
				?>
				<input type="text" class="input-block-level" name="mk" value="<?php echo "$datasoal[mkNama]"; ?>" disabled>
				<hr>
				<table class="table table-hover">
				<?php
					/*$ssoal=mysql_query("select a.*, b.dNama, c.mkNama from jadwalmengajar a 
					LEFT JOIN dosen b ON a.dId=b.dId LEFT JOIN matakuliah c ON a.mkId=c.mkId 
					WHERE a.mkId='$mkId' and a.dId='$dId' and a.taId='$_SESSION[taId]'");*/
					$sql = mysql_query("SELECT * FROM soal");
					$no=0;
					while ($l=mysql_fetch_array($sql)){
						$no++;
					?>
						<tr class="success">
							<td colspan="2"><?php echo "$no. $l[sSoal]";?></td>
						</tr>
						<tr>
							<td colspan="2">
							<?php					
								$sJenis = $l['sJenis'];
								$aa=$l['sId'];
								if ($sJenis!="C"){
									$sql1=mysql_query("SELECT * FROM jawaban WHERE jJenis='$sJenis'");
									while($s=mysql_fetch_array($sql1)){								
										echo "<label class='radio'>
												<input type='radio' name='data[$aa]' value='$s[jId]'>$s[jJawaban]
											  </label>";
									}
								}else{
									echo "<textarea name='data[$aa]' style='width: 95%; height: 134px;'></textarea>";
								}
					}
					?>
							</td>
						</tr>
						<tr class="info">
							<td colspan="2">Komentar/Saran<br><br><textarea name ="hKomentar" style="width: 95%; height: 134px;"></textarea></td>
						</tr>
						<tr class="info">
							<td colspan="2">
								<p><input type="checkbox" name='setuju' value='setuju'>&nbsp;&nbsp;
								Silahkan cek kembali jawaban yang anda pilih. Seteleh menekan tombol simpan, anda tidak dapat lagi mengubah jawabn anda. <strong>Anda setuju?</strong></p>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<button class="btn btn-large btn-block btn-primary" name="simpan" type="submit">Simpan</button>
								<button class="btn btn-large btn-block" type="reset">Batal</button>
							</td>
						</tr>
				</table>
			</form>
			<?php					
		break;		
		case "finish" :
			if(isset($_POST['simpan'])){
				$jId=$_POST[data];
				$mkId=$_POST['mkId'];
				$hKomentar=$_POST['hKomentar'];
				$sekarang=date("Y-m-d H:i:s");
		
				$sqlH=mysql_query("INSERT INTO hasil(
												mNim, 
												mkId, 
												h1, h2, h3, h4, h5, 
												h6, h7, h8, h9, h10, 
												h11, h12, h13, h14, h15, 
												h16, h17, h18, h19, 
												taId, 
												hKomentar, hTanggal 
												)VALUES(
												'$_SESSION[issss]', 
												'$mkId', 
												'$jId[1]', '$jId[2]', '$jId[3]', '$jId[4]', '$jId[5]', 
												'$jId[6]', '$jId[7]', '$jId[8]', '$jId[9]', '$jId[10]', 
												'$jId[11]', '$jId[12]', '$jId[13]', '$jId[14]', '$jId[15]',
												'$jId[16]', '$jId[17]', '$jId[18]', '$jId[19]',
												'$_SESSION[taId]', 
												'$hKomentar', '$sekarang')");
										
				if ($sqlH){
					echo "<script>alert ('Data Jawaban Evaluasi Telah Tersimpan');</script>";
				}else{
					echo "<script>alert ('Data Jawaban Evaluasi Gagal Tersimpan..!!!');</script>";
				}
				echo"<script>parent.location='?p=kuesioner';</script>";
			}
			break; 
	}
}else{
	echo"<script>parent.location ='index.php';</script>";
}
?>

<script type="text/javascript">  
   function cekKui(form){ 
	if (form.setuju.checked==false){
		alert("Silahkan centang setuju terlebih dahulu!!!");
		return (false);
	}
	return (true);
   }
</script>