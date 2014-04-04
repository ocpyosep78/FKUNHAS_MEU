<?php
session_start();
date_default_timezone_set("Asia/Makassar");

if ($_SESSION[login]==1)
{  
	switch($_GET[a])
	{
		default :
		?>
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">Search (Info, Pengumuman, dan Panduan)</a>
					<form class="navbar-form pull-right" method='post' onsubmit='return cekKondisi(this);'>
						<input class="input-xlarge" type="text" name="qcari" placeholder="Cari Judul">
					<button class="btn btn-primary" type='submit' name='cari'><i class="icon-search icon-white"></i> Show</button>
					</form>
					<br>
				</div>
			</div><!--/navbar-inner--> 
		</div><!--/navbar-->
		<hr>
		<?php		
		if (!isset($_POST[cari])){
			echo "<h3>Info dan Pengumuman Terakhir</h3>";
			$qi = mysql_query("SELECT * FROM info ORDER by iId DESC LIMIT 20");
			while($i=mysql_fetch_array($qi)){
				echo "<blockquote>";
				if (empty($i[iFile])){
					echo "<p>$i[iJudul]</p>";
				}else{
					echo "<p><a href='fileinfo/$i[iFile]'>$i[iJudul]</a></p>";
				}
				if (!empty($i[iIsi])){
					echo "<small>$i[iIsi]</small>";
				}
				echo "</blockquote>";
			}			
		}else{
			$qi = mysql_query("SELECT * FROM info WHERE iJudul LIKE '%$_POST[qcari]%'");
			$jresult = mysql_num_rows($qi);
			if ($jresult>0){
				echo "<h3>Hasil Pencarian - \"$_POST[qcari]\" (Result $jresult)</h3>";
			}else{
				echo "<h3>Hasil Pencarian - \"$_POST[qcari]\" tidak ditemukan</h3>";
			}
			while($i=mysql_fetch_array($qi)){
				echo "<blockquote>";
				if (empty($i[iFile])){
					echo "<p>$i[iJudul]</p>";
				}else{
					echo "<p><a href='fileinfo/$i[iFile]'>$i[iJudul]</a></p>";
				}
				if (!empty($i[iIsi])){
					echo "<small>$i[iIsi]</small>";
				}
				echo "</blockquote>";
			}			
		}
		break;
	}
}else{
	?>
	<h3>Welcome</h3><hr>
	<p align="justify">
	Aplikasi khusus untuk mahasiswa Fakultas Kedokteran UNHAS yang digunakan untuk mendowload materi-materi perkuliahan, pengumuman, jadwal kuliah, serta mengisi kuesioner penilaian sebagai evaluasi terhadap Blok/Mata Kuliah. <br>Kuesioner yang mahasiswa isi tidak akan mempengaruhi nilai mahasiswa yang bersangkutan. Namun akan sangat membantu meningkatkan kualitas penyelenggaraan pendidikan di Fakultas Kedokteran UNHAS. Sehingga sangat diharapkan kepada mahasiswa untuk menjawab setiap pertanyaan kuesioner dengan sebetul-betulnya.
	</p>
	<?php
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