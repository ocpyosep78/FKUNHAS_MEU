<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_materi/aksi_materi.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Daftar File Materi</h2>
    <div align="right"><a href='?module=materi&act=tambah' class='button'>Tambah File Materi</a> </div>    
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
                    <th><h3>Judul Materi</h3></th>
                    <th><h3>Blok</h3></th>
					<th><h3>Kelas</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
				include "../../koneksi.php";
                $fm = mysql_query("SELECT a.*,b.mkNama FROM filemateri a 
								   LEFT JOIN matakuliah b ON a.mkId=b.mkId");
								   
				while($s = mysql_fetch_array($fm)) {
					$no++;
					if ($s[fJur]=="reg")
						$jr="Regular";
					else
						$jr="Internasional";
						
		echo "
                <tr>
                    <td>$no</td>
                    <td><a href='../filemateri/$s[fFile]' target='_blank'>$s[fJudul]</td>
                    <td>$s[mkNama]</td>
					<td>$jr</td>
					<td align='center'>
						<a href='$aksi?module=materi&act=hapus&id=$s[fId]' onclick=\"return confirm('Apakah anda ingin menghapus?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=materi&act=edit&id=$s[fId]'><img src='images/edit.png' title='Edit'></a>&nbsp;";
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
 echo "<h2>Tambah File Materi</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=materi&act=input' onsubmit='return cekIsi(this);' enctype='multipart/form-data'>
          <table>
          <tr><td width='170px'>Judul</td>     
		  <td><input type=text name='fJudul' id='fJudul' size=150></td></tr>
          <tr><td>File</td>     
		  <td><input type='file' name='fupload' id='fupload' size=40><br>* Hanya mendukung untuk file PDF</td></tr>
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
			<select name='fJur' id='fJur'>
		  	<option value=''>--Pilih Kelas--</option>
			<option value='reg'>Reguler</option>
			<option value='int'>Internasional</option>
			</select>
		  </td></tr>  
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan id='simpan'>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "edit" :
$sql=mysql_query("select * from filemateri WHERE fId='$_GET[id]'");
$fl=mysql_fetch_array($sql);
echo "<h2>Edit File Materi</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=materi&act=edit&id=$fl[fId]' onsubmit='return cekIsi(this);' enctype='multipart/form-data'>
          <table>
          <tr><td width='170px'>Judul</td>     
		  <td><input type=text name='fJudul' id='fJudul' size=150 value='$fl[fJudul]'></td></tr>
          <tr><td>File</td>     
		  <td><a href='../filemateri/$fl[fFile]' target='_blank'>$fl[fFile]</td></tr>
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
			<select name='fJur' id='fJur'>";
		  	if ($fl[fJur]=='reg'){
				echo "<option value='reg' selected>Reguler</option>
					  <option value='int'>Internasional</option>";
			}else{
				echo "<option value='reg'>Reguler</option>
					  <option value='int' selected>Internasional</option>";
			}
	echo	"</select>
		  </td></tr>  
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Update>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
}
}
?>
<script type="text/javascript">  
     
   function cekIsi(form){ 
   if (form.fJudul.value == ""){
    alert("Judul masih kosong!!");
	form.fJudul.focus();
    return (false);
   }
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
   if (form.fJur.value == ""){
    alert("Kelas masih kosong !!");
	form.fJur.focus();
	return (false);
   }
   return (true);
   }
   </script> 
