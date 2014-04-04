<?php
session_start();
if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}else{
switch($_GET[act]){
	default:
	?>
<h2>Rekap Evaluasi</h2>
              <form method=POST action='?module=rekaphasil&act=view' onSubmit="return cekIsi(this);">
          		<table>
		  			<tr>
		  				<td width="150px">Mata Kuliah/Blok</td>     
					  	<td>
                        	<select name="mkul" id='mkul'>
                				<option value="">---Pilih Matakuliah---</option>
                    			<?php
									$mk=mysql_query("SELECT * FROM matakuliah ");
									while($dmk=mysql_fetch_array($mk))
									{
										echo "<option value='$dmk[mkId]'>$dmk[mkNama]</option>";
									}
								?>
                			</select>
                        </td>
		  			</tr>
			        <tr>
					  	<td>Periode</td>     
		  				<td>
                        	<select name="mperiode" id='mperiode'>
                				<option value="">---Pilih Periode---</option>
                    			<?php
									$pd=mysql_query("SELECT * FROM tahunajaran");
									while($dpd=mysql_fetch_array($pd))
									{
										if ($dpd['taSemester']%2==1){
											$sms = "Ganjil";
										}else{
											$sms = "Genap";
										}
										echo "<option value='$dpd[taId]'>$dpd[taNama] ($sms)</option>";
									}
								?>
                			</select>
                        </td>
		  			</tr>
			        <tr>
                    	<td colspan=2 align="center">
                        	<input type=submit class='button' value=View>
                        	<input type=button class='button' value=Kembali onclick=self.history.back()>
                        </td>
                    </tr>
          		</table>
                </form>
    <?php
	break ;
case "view":
$mkId = $_POST['mkul'];
$taId = $_POST['mperiode'];

$mKul = mysql_fetch_array(mysql_query("SELECT mkNama FROM matakuliah WHERE mkId=$mkId"));
$prd = mysql_fetch_array(mysql_query("SELECT taNama, taSemester FROM tahunajaran WHERE taId=$taId"));
$jhasil = mysql_num_rows(mysql_query("SELECT * FROM hasil WHERE taId=$taId AND mkId=$mkId"));

if ($prd['taSemester']%2==0){
	$sms = "Genap";
}else{
	$sms = "Ganjil";
}

echo "<h2>Rekap Hasil Evaluasi</h2>";
echo "
    	<table align='center' cellspacing='10'>
            <tr> 
            	<td width='140px'>Mata Kuliah / Blok</td>
                <td colspan='2'>$mKul[mkNama]</td>
            </tr>
			<tr> 
            	<td width='140px'>Periode</td>
                <td colspan='2'>$prd[taNama] ($sms)</td>
            </tr>
			<tr> 
            	<td width='140px'>Jumlah Evaluasi</td>
                <td colspan='2'>$jhasil</td>
            </tr>
		</table>";
		
		
		if ($jhasil>0){	
		echo"
		<table>
			<tr>
            	<td align='center'><h3><b>Hasil</b></h3></td>
            </tr>
		</table>";
			
			
			//batas tampilkan soal jenis a dan jawaban jenis a
			echo "<table>
			<tr>
            	<td align='center'>No</td>
				<td align='center'>Soal</td>";
				$qa=mysql_query("SELECT jId,jJawaban FROM jawaban WHERE jJenis='A'");
				while($a=mysql_fetch_array($qa))
				{
					echo "<td align='center'>$a[jJawaban]</td>";
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
			echo "<table>
			<tr>
            	<td align='center'>No</td>
				<td align='center'>Soal</td>";
				$qa=mysql_query("SELECT jJawaban FROM jawaban WHERE jJenis='B'");
				while($a=mysql_fetch_array($qa))
				{
					echo "<td align='center'>$a[jJawaban]</td>";
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
			echo "</table>";
			//batas tampilkan soal jenis b dan jawaban jenis b
			
			echo "<table>
					<tr align='center'>
					<td>
					<a href=modul/mod_laporanblok/cetakrekap.php?t=$taId&m=$mkId target='_blank'>
					<img src='images/cetak.png' title='Cetak Rekap'></a>
					</td>
					</tr>
					</table>";
			
		}else{
			echo"
			<table>
			<tr>
            	<td align='center'><h3><b>Data Evaluasi Untuk Mata Kuliah (Blok)<br> 
										$mKul[mkNama] <br>
										Pada Periode $prd[taNama] - Semester $sms <br>
										<strong><blink>Belum Ada..!!</blink></strong></b></h3></td>
            </tr>
			</table>";
		}
			
break;
	}
}
?>
<script type="text/javascript">  
   function cekIsi(form){ 
   if (form.mkul.value == ""){
    alert("Belum memilih Mata Kuliah!!");
	form.mkul.focus();
    return (false);
   }
   if (form.mperiode.value == ""){
    alert("Belum memilih periode!!");
	form.mperiode.focus();
	return (false);
   }
   alert(form.nkul.value);
   alert(form.npd.value);
   return (true);
   }   
</script> 