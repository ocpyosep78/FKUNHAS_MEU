<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_info/aksi_info.php";
switch($_GET[act]){
  default:
?>
<body>
<h2>Daftar Info</h2>
    <div align="right"><a href='?module=info&act=tambah' class='button'>Tambah Info</a> </div>    
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
                    <th width='10px'><h3>No</h3></th>
                    <th><h3>Judul</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
				include "../../koneksi.php";
                $fm = mysql_query("SELECT a.* FROM info a");
								   
				while($s = mysql_fetch_array($fm)) {
					$no++;
		echo "
                <tr>
                    <td>$no</td>";
					if (empty($s[iFile])){
						echo "<td>$s[iJudul]</td>";
					}else{
						echo "<td><a href='../fileinfo/$s[iFile]' target='_blank'>$s[iJudul]</a></td>";
					}
					echo "	
					</td>
					<td align='center'>
						<a href='$aksi?module=info&act=hapus&id=$s[iId]' onclick=\"return confirm('Apakah anda ingin menghapus?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=info&act=edit&id=$s[iId]'><img src='images/edit.png' title='Edit'></a>&nbsp;";
						echo "</a>
					</td>
                </tr>";
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
 echo "<h2>Tambah Info</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=info&act=input' onsubmit='return cekIsi(this);' enctype='multipart/form-data'>
          <table>
          <tr><td width='170px'>Judul</td>     
		  <td><input type=text name='iJudul' id='iJudul' size=100></td></tr>
		  <tr><td width='170px'>Isi Info</td>     
		  <td><textarea style=\"margin: 2px; width: 500px; height: 100px;\" id='iIsi' name='iIsi'></textarea></td></tr>
          <tr><td>File</td>     
		  <td><input type='file' name='fupload' id='fupload' size=40></td></tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan id='simpan'>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "edit" :
$sql=mysql_query("select * from info WHERE iId='$_GET[id]'");
$fl=mysql_fetch_array($sql);
echo "<h2>Edit Info</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=info&act=edit&id=$fl[iId]' onsubmit='return cekIsi(this);' enctype='multipart/form-data'>
          <table>
          <tr><td width='170px'>Judul</td>     
		  <td><input type=text name='iJudul' id='iJudul' size=150 value='$fl[iJudul]'></td></tr>
		  <tr><td width='170px'>Isi Info</td>     
		  <td><textarea style=\"margin: 2px; width: 500px; height: 100px;\" id='iIsi' name='iIsi'>$fl[iIsi]</textarea></td></tr>
          <tr><td>File</td>     
		  <td><a href='../filemateri/$fl[fFile]' target='_blank'>$fl[fFile]</td></tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Update>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
}
}
?>
<script type="text/javascript">  
   function cekIsi(form){ 
   if (form.iJudul.value == ""){
    alert("Judul masih kosong!!");
	form.iJudul.focus();
    return (false);
   }
   if (form.simpan.value=="simpan"){
	if (form.fupload.value == "")&&(form.iIsi.value=""){
		alert("Isi atau Lampiran file masih kosong !!");
		form.iIsi.focus();
		return (false);
	}
   }
   return (true);
   }
   </script> 
