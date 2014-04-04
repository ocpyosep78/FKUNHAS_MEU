<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_matakuliah/aksi_matakuliah.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Daftar Matakuliah</h2>
    <div align="right"><a href='?module=matakuliah&act=tambahuser' class='button'>Tambah Matakuliah</a> </div>    
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
                    <th width="60px"><h3>Kode MK</h3></th>                             
                    <th><h3>Nama</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
        include "../../koneksi.php";
                $sekolah = mysql_query("SELECT * FROM matakuliah");
				while($s = mysql_fetch_array($sekolah)) {
					$no++;
		echo "
                <tr>
                    <td align='right'>$s[mkId]</td>
					<td>$s[mkNama]</td>
					<td align='center'>
						<a href='$aksi?module=matakuliah&act=hapus&id=$s[mkId]' onclick=\"return confirm('Apakah anda ingin menghapus matakuliah $s[mkNama] ?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=matakuliah&act=ubah&id=$s[mkId]'><img src='images/edit.png' title='Edit'></a>&nbsp;
						
						</a>
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
case "tambahuser" :
 echo "<h2>Tambah Matakuliah</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=matakuliah&act=input' onsubmit='return cekIsi(this);'>
          <table>
          <tr><td>Nama</td>     
		  <td><input type=text name='mkNama' id='mkNama' size=78></td></tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "ubah" :
$sql=mysql_query("select * from matakuliah WHERE mkId='$_GET[id]'");
$dosen=mysql_fetch_array($sql);
echo "<h2>Edit Dosen</h2>";
echo "
<form method='POST' action='$aksi?module=matakuliah&act=update' onsubmit='return cekIsi(this);'>
    	<table align='center' cellspacing='10'>
            <tr>
            	<td>Nama</td>
                <td>:</td>
                <td><input type='text' name='mkNama' id='mkNama' size='68' value='$dosen[mkNama]'>
					<input type='hidden' name='mkId' value='$dosen[mkId]'>
				</td>
            </tr>
            
            <tr>
            	<td colspan='3' align='center'><input type='submit' value='Update' name='simpanuser' class='button' />&nbsp; &nbsp; &nbsp; <input type='reset' class='button' value='Batal' onClick='self.history.back();'></td>
            </tr>
            
        </table>
    </form>
";
break;
}
}
?>
<script type="text/javascript">  
   function cekIsi(form){ 
   if (form.mkNama.value == ""){
    alert("Nama Blok/Mata Kuliah masih kosong..!!");
	form.mkNama.focus();
    return (false);
   }
   return (true);
   }   
</script> 
