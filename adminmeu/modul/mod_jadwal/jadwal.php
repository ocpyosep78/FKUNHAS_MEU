<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_jadwal/aksi_jadwal.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Daftar File Jadwal</h2>
    <div align="right"><a href='?module=jadwal&act=tambah' class='button'>Tambah File Jadwal</a> </div>    
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
                    <th><h3>No</h3></th>
                    <th><h3>Jadwal</h3></th>
                    <th><h3>Semester</h3></th>
					<th><h3>Tahun Ajaran</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
				include "../../koneksi.php";
                $fm = mysql_query("SELECT a.*,b.mkNama,c.taNama,c.taSemester FROM jadwal a 
								   LEFT JOIN matakuliah b ON a.mkId=b.mkId
								   LEFT JOIN tahunajaran c ON c.taId=a.taId");
								   
				while($s = mysql_fetch_array($fm)) {
					$no++;
					if ($s[jdJur]=="reg")
						$jr="Regular";
					else
						$jr="Internasional";
						
					if ($s[taSemester]=="1")
						$sm="Ganjil";
					else
						$sm="Genap";
		echo "
                <tr>
                    <td>$no</td>
                    <td><a href='../filejadwal/$s[jdFile]' target='_blank'>$s[mkNama] - $jr</td>
                    <td>$sm</td>
					<td>$s[taNama]</td>
					<td align='center'>
						<a href='$aksi?module=jadwal&act=hapus&id=$s[jdId]' onclick=\"return confirm('Apakah anda ingin menghapus?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=jadwal&act=edit&id=$s[jdId]'><img src='images/edit.png' title='Edit'></a>&nbsp;";
						echo "</a>
					</td>
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
break;
case "tambah" :
 echo "<h2>Tambah File Jadwal</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=jadwal&act=input' onsubmit='return cekIsi(this);' enctype='multipart/form-data'>
          <table>
          <tr><td>File</td>     
		  <td><input type='file' name='fupload' id='fupload' size=40></td></tr>
		  <tr><td>Blok/Mata Kuliah</td>       
		  <td>
			<select name='mkId' id='mkId'>
		  	<option value=''>--Pilih Blok/Mata Kuliah--</option>";
			$mk=mysql_query("SELECT * FROM matakuliah ");
			while($dmk=mysql_fetch_array($mk)){
				echo "<option value='$dmk[mkId]'>$dmk[mkNama]</option>";
			}
	echo	"</select>
		  </td>
		  </tr>
          <tr><td>Kelas</td> 
		  <td>
			<select name='jdJur' id='jdJur'>
		  	<option value=''>--Pilih Kelas--</option>
			<option value='reg'>Reguler</option>
			<option value='int'>Internasional</option>
			</select>
		  </td></tr>  
		  <tr><td>Tahun Ajaran (Semester)</td>       
		  <td>
			<select name='taId' id='taId'>
		  	<option value=''>--Tahun Ajaran--</option>";
			$pd=mysql_query("SELECT * FROM tahunajaran");
			while($dpd=mysql_fetch_array($pd)){
				if ($dpd['taSemester']%2==1){
					$sms = "Ganjil";
				}else{
					$sms = "Genap";
				}
				echo "<option value='$dpd[taId]'>$dpd[taNama] ($sms)</option>";
			}
	echo	"</select>
		  </td>
		  </tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan id='simpan'>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "edit" :
$sql=mysql_query("select * from jadwal WHERE jdId='$_GET[id]'");
$fl=mysql_fetch_array($sql);
echo "<h2>Edit File Jadwal</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=jadwal&act=edit&id=$fl[jdId]' onsubmit='return cekIsi(this);' enctype='multipart/form-data'>
          <table>
          <tr><td>File</td>     
		  <td><a href='../filejadwal/$fl[jdFile]' target='_blank'>$fl[jdFile]</td></tr>
		  <tr><td>Blok/Mata Kuliah</td>       
		  <td>
			<select name='mkId' id='mkId'>";
			$mk=mysql_query("SELECT * FROM matakuliah ");
			while($dmk=mysql_fetch_array($mk)){
				if ($dmk[mkId]==$fl[mkId]){
					echo "<option value='$dmk[mkId]' selected>$dmk[mkNama]</option>";
				}else{
					echo "<option value='$dmk[mkId]'>$dmk[mkNama]</option>";
				}
			}
	echo	"</select>
		  </td>
		  </tr>
          <tr><td>Kelas</td> 
		  <td>
			<select name='jdJur' id='jdJur'>";
		  	if ($fl[fJur]=='reg'){
				echo "<option value='reg' selected>Reguler</option>
					  <option value='int'>Internasional</option>";
			}else{
				echo "<option value='reg'>Reguler</option>
					  <option value='int' selected>Internasional</option>";
			}
	echo	"</select>
		  </td></tr>  
		  <tr><td>Tahun Ajaran (Semester)</td>       
		  <td>
			<select name='taId' id='taId'>
		  	<option value=''>--Tahun Ajaran--</option>";
			$pd=mysql_query("SELECT * FROM tahunajaran");
			while($dpd=mysql_fetch_array($pd)){
				if ($dpd['taSemester']%2==1){
					$sms = "Ganjil";
				}else{
					$sms = "Genap";
				}
				if ($fl[taId]==$dpd[taId]){
					echo "<option value='$dpd[taId]' selected>$dpd[taNama] ($sms)</option>";
				}else{
					echo "<option value='$dpd[taId]'>$dpd[taNama] ($sms)</option>";
				}
			}
	echo	"</select>
		  </td>
		  </tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Update>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
}
}
?>
<script type="text/javascript">  
     
   function cekIsi(form){ 
   if (form.simpan.value=="simpan"){
	if (form.fupload.value == ""){
		alert("File masih kosong !!");
		form.fupload.focus();
		return (false);
	}
   }
   if (form.mkId.value == ""){
    alert("Mata Kuliah/Blok masih kosong !!");
	form.mkId.focus();
	return (false);
   }
   if (form.jdJur.value == ""){
    alert("Kelas masih kosong !!");
	form.jdJur.focus();
	return (false);
   }
   if (form.taId.value == ""){
    alert("Tahun Ajaran masih kosong !!");
	form.taId.focus();
	return (false);
   }
   return (true);
   }
   </script> 
