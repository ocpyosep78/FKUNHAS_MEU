<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
//$aksi="modul/mod_dosen/aksi_dosen.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Daftar Hasil</h2>
	<div id="tablewrapper">
		<div id="tableheader">
        	<div class="search">
                <select id="columns" onChange="sorter.search('query')"></select>
                <input type="text" id="query" onKeyUp="sorter.search('query')" />
                
            </div>
            <span class="details">
				<div align="right">Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span> <a href="javascript:sorter.reset()">reset</a></div>
        	</span>
        </div>
        
        <table cellpadding="0" cellspacing="0" border="0" id="table">
            <thead>
                <tr>
                    <th class="nosort" width="30px"><h3>No</h3></th>
                    <th align="center"><h3>Tanggal / Jam</h3></th>
                    <th align="center"><h3>Mata Kuliah</h3></th>
                    <th align="center"><h3>Periode</h3></th>
                    <th align="center"><h3>Semester</h3></th>
                    <th width="20px" align="center"><h3>Detail</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
        include "../../koneksi.php";
                $sekolah = mysql_query("SELECT a.*, b.mkNama, d.taNama, d.taSemester FROM hasil a 
										LEFT JOIN matakuliah b ON a.mkId=b.mkId 
										LEFT JOIN tahunajaran d ON a.taID=d.taId 
										ORDER BY a.taId DESC, a.hTanggal");
				while($s = mysql_fetch_array($sekolah)) {
					$noo++;
				if ($s[taSemester]%2==1)
					$semester="Ganjil";
				else if ($s[taSemester] % 2 == 0)
					$semester="Genap";
		echo "
                <tr>
                    <td valign='middle' align='center'>$noo</td>
                    <td valign='middle' align='center'>$s[hTanggal]</td>
					<td valign='middle'>$s[mkNama]</td>
					<td valign='middle' align='center'>$s[taNama]</td>
					<td valign='middle' align='center'>$semester</td>
					<td valign='middle' align='center'><a href='?module=hasil&act=view&id=$s[hId]'><img src='images/ico_view_24.png' title='View'></td>
                </tr>
           ";
				}
		     ?>
            </tbody>
        </table>
        <div id="tablefooter">
          <div id="tablenav">
            	<div>
                    <img src="images/first.gif" width="16" height="16" alt="First Page" onClick="sorter.move(-1,true)" />
                    <img src="images/previous.gif" width="16" height="16" alt="First Page" onClick="sorter.move(-1)" />
                    <img src="images/next.gif" width="16" height="16" alt="First Page" onClick="sorter.move(1)" />
                    <img src="images/last.gif" width="16" height="16" alt="Last Page" onClick="sorter.move(1,true)" />
                &nbsp; &nbsp;<select id="pagedropdown"></select>
				&nbsp; &nbsp;<a href="javascript:sorter.showall()">view all</a>
                </div>
            </div>
			<div id="tablelocation" align="right">
            	<div>
                    <select onChange="sorter.size(this.value)">
                    <option value="5">5</option>
                        <option value="10" selected="selected">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>Entries Per Page</span>
                / <font color="red">Page <span id="currentpage"></span> of <span id="totalpages"></span></font></div>
            </div>
        </div>
    </div>
	<script type="text/javascript" src="../mod_tabel/script.js"></script>
	<script type="text/javascript">
	var sorter = new TINY.table.sorter('sorter','table',{
		headclass:'head',
		ascclass:'asc',
		descclass:'desc',
		evenclass:'evenrow',
		oddclass:'oddrow',
		evenselclass:'evenselected',
		oddselclass:'oddselected',
		paginate:true,
		size:10,
		colddid:'columns',
		currentid:'currentpage',
		totalid:'totalpages',
		startingrecid:'startrecord',
		endingrecid:'endrecord',
		totalrecid:'totalrecords',
		hoverid:'selectedrow',
		pageddid:'pagedropdown',
		navid:'tablenav',
		sortcolumn:1,
		sortdir:1,
		//sum:[8],
		//avg:[6,7,8,9],
		//columns:[{index:7, format:'%', decimals:1},{index:8, format:'$', decimals:0}],
		init:true
	});
  </script>
  
</body>
<?php
/*
echo"<b>Keterangan</b><br><i>";
	$ket=mysql_query("Select * from jawaban");
	while($keterangan=mysql_fetch_array($ket))
	{
		echo "<font color='red'>".$keterangan['jId']."</font>. $keterangan[jJawaban]<br>";
	}
	echo "</i>";
*/	
break;
case "view" :
$qmk=mysql_query("SELECT a.*, b.mkNama, d.taNama, d.taSemester FROM hasil a 
				  LEFT JOIN matakuliah b ON a.mkId=b.mkId 
				  LEFT JOIN tahunajaran d ON a.taID=d.taId  
				  WHERE hId='$_GET[id]'");
$dmk=mysql_fetch_array($qmk);

$qh=mysql_query(" SELECT a.hId,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h1) AS Hs1,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h2) AS Hs2,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h3) AS Hs3,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h4) AS Hs4,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h5) AS Hs5,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h6) AS Hs6,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h7) AS Hs7,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h8) AS Hs8,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h9) AS Hs9,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h10) AS Hs10,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h11) AS Hs11,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h12) AS Hs12,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h13) AS Hs13,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h14) AS Hs14,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h15) AS Hs15,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h16) AS Hs16,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h17) AS Hs17,
				  (SELECT jJawaban FROM jawaban WHERE jId=a.h18) AS Hs18,
				  a.h19 AS Hs19
				  FROM hasil a WHERE a.hId=$_GET[id]");
$dh = mysql_fetch_array($qh);		
		  
$jwb[1]=$dh[Hs1]; $jwb[2]=$dh[Hs2]; $jwb[3]=$dh[Hs3]; $jwb[4]=$dh[Hs4]; $jwb[5]=$dh[Hs5];
$jwb[6]=$dh[Hs6]; $jwb[7]=$dh[Hs7]; $jwb[8]=$dh[Hs8]; $jwb[9]=$dh[Hs9]; $jwb[10]=$dh[Hs10];
$jwb[11]=$dh[Hs11]; $jwb[12]=$dh[Hs12]; $jwb[13]=$dh[Hs13]; $jwb[14]=$dh[Hs14]; $jwb[15]=$dh[Hs15];
$jwb[16]=$dh[Hs16]; $jwb[17]=$dh[Hs17]; $jwb[18]=$dh[Hs18]; $jwb[19]=$dh[Hs19];

echo "<h2>View Hasil Evaluasi</h2>";
echo "
    	<table align='center' cellspacing='10'>
            <tr> 
            	<td width='140px'>Mata Kuliah / Blok</td>
                <td colspan='2'>$dmk[mkNama]</td>
            </tr>
			<tr> 
            	<td width='140px'>Periode</td>
                <td colspan='2'>$dmk[taNama] - $dmk[taSemester]</td>
            </tr>
			<tr> 
            	<td width='140px'>Di isi pada</td>
                <td colspan='2'>$dmk[hTanggal]</td>
            </tr>
			<tr>
            	<td colspan='3' align='center'><h3><b>Hasil</b></h3></td>
            </tr>
			<tr>
            	<td align='center'>No</td>
				<td align='center'>Soal</td>
				<td align='center'>Jawaban</td>
            </tr>";
			$sl=mysql_query("SELECT * FROM soal ORDER by sId LIMIT 19");
			while ($dsl=mysql_fetch_array($sl)){
				$no++;
				echo "<tr>
            			<td align='center'>$dsl[sId]</td>
						<td>$dsl[sSoal]</td>
						<td>$jwb[$no]</td>
            		  </tr>";
			}
			echo "
			<tr>
            	<td colspan='3' align='center'><h3><b>Komentar/Saran</b></h3></td>
            </tr>
            <tr>
                <td colspan='3' align='center'>$dmk[hKomentar]</td>
            </tr>
			<tr>
            	<td colspan='3' align='center'><input type='reset' class='button' value='Kembali'  onclick=self.history.back()></td>
            </tr>
            
        </table>
";
break;
}
}
?>
