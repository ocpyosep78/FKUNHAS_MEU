<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_tahunajaran/aksi_tahunajaran.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Tahun Ajaran</h2>
    <div align="right"><a href='?module=tahunajaran&act=tambahuser' class='button'>Tambah Tahun Ajaran</a> </div>    
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
                    <th width="40px"><h3>No</h3></th>
                    <th><h3>Tahun Ajaran</h3></th>                   
                    <th><h3>Semester</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
        include "../../koneksi.php";
                $sekolah = mysql_query("select * from tahunajaran ORDER BY taId DESC");
				while($s = mysql_fetch_array($sekolah)) {
					$No++;
				if ($s[taSemester]=='1')
					$semester="Ganjil";
				elseif ($s[taSemester]=='2')
					$semester="Genap";
		echo "
                <tr>
                    <td>$No</td>
                   
                    <td>$s[taNama]</td>
					<td>$semester</td>
					<td align='center'>
						<a href='$aksi?module=tahunajaran&act=hapus&id=$s[taId]' onclick=\"return confirm('Apakah anda ingin menghapus Tahun Ajaran $s[taNama] Semester $semester ?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=tahunajaran&act=ubah&id=$s[taId]'><img src='images/edit.png' title='Edit'></a>&nbsp;";
						
			if ($s[taStatus]=='0')
			{			
				echo "<a href='$aksi?module=tahunajaran&act=a&id=$s[taId]' onclick=\"return confirm('Apakah anda ingin mengaktifkan Tahun Ajaran $s[taNama] Semester $semester ?')\">";
				echo "<img src='images/ico_error_16.png' title='Aktifkan Tahun ajaran' >";
				echo "</a>";
			}
			else 
				echo "<img src='images/ico_active_16.png' title='Aktifkan Tahun ajaran' >";
			
			echo "</td>
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
 echo "<h2>Tambah Tahun Ajaran</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=tahunajaran&act=input' onsubmit='return cekIsi(this);'>
          <table>
		  <tr><td width='140px'>Tahun Ajaran</td>     
		  <td><input type=text name='taNama' id='tn' size='38px'></td></tr>
          <tr><td>Semester</td>     
		  <td>
		  <select name='taSemester' id='ts'>
		  	<option value=''>--Pilih Semester--</option>
			<option value='1'>Ganjil</option>
			<option value='2'>Genap</option>
		  </select>
		  </td></tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "ubah" :
$sql=mysql_query("select * from tahunajaran WHERE taId='$_GET[id]'");
$data=mysql_fetch_array($sql);
echo "<h2>Edit Tahun Ajaran</h2>";
echo "
<form method='POST' action='$aksi?module=tahunajaran&act=update' onsubmit='return cekIsi(this);'>
    	<table align='center' cellspacing='10'>
            <tr><td width='140px'>Tahun Ajaran</td>     
		  <td><input type=text name='taNama' id='tn' value='$data[taNama]' size='38px'>
		  	  <input type='hidden' name='taId' value='$data[taId]'>
		  </td></tr>
          <tr><td>Semester</td>     
		  <td>
		  <select name='taSemester' id='ts'>
		  	<option value=''>--Pilih Semester--</option>
			<option value='1'>Ganjil</option>
			<option value='2'>Genap</option>
		  </select>
		  </td></tr>
            <tr>
            	<td colspan='3'><input type='submit' value='Update' name='simpanuser' class='button' />&nbsp; &nbsp; &nbsp; <input type='reset' class='button' value='Batal' onclick=self.history.back()></td>
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
   if (form.tn.value == ""){
    alert("Tahun Ajaran masih kosong..!!");
	form.tn.focus();
    return (false);
   }
   if (form.ts.value == ""){
    alert("Belum memilih Semester!!");
	form.ts.focus();
	return (false);
   }
   return (true);
   }   
</script> 
