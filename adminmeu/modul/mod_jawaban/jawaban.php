<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_jawaban/aksi_jawaban.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Daftar Jawaban</h2>
    <?php 
	//hapus komentar untuk menampilkan button tambah opsi jawaban
	//<div align="right"><a href='?module=jawaban&act=tambahuser' class='button'>Tambah Jawaban</a> </div> 
	?>
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
                    <th width="60px"><h3>Kode Jawaban</h3></th>
                    <th align="center"><h3>Jawaban</h3></th>
                    <th width="60px" align="center"><h3>Jenis Jawaban</h3></th>                   
                    <th width="70px" class="nosort" align="center"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
        include "../../koneksi.php";
                $sekolah = mysql_query("select * from jawaban order by jId asc");
				while($s = mysql_fetch_array($sekolah)) {
					$no++;
		echo "
                <tr>
                    <td align='center'>$s[jId]</td>
                    <td>$s[jJawaban]</td>
					<td align='center'>$s[jJenis]</td>
					<td align='center'>";
						//<a href='$aksi?module=jawaban&act=hapus&id=$s[jId]' onclick=\"return confirm('Apakah anda ingin menghapus jawaban dengan kode $s[jId] ?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						echo "<a href='?module=jawaban&act=ubah&id=$s[jId]'><img src='images/edit.png' title='Edit'></a>&nbsp;
						
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
 echo "<h2>Tambah Jawaban</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=jawaban&act=input'>
          <table>
		  <tr>
		  	<td>Soal</td>     
		  	<td><textarea name='jJawaban' id='jJawaban' cols='150' rows='5'></textarea></td>
		  </tr>
		  <tr>
		  	<td>Jenis Jawaban</td>     
		  	<td>
				<input type='radio' name='jJenis' id='jJenis1' value='A'>A</input>
				<input type='radio' name='jJenis' id='jJenis2' value='B'>B</input>
			</td>
		  </tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "ubah" :
$sql=mysql_query("select * from jawaban WHERE jId='$_GET[id]'");
$jawab=mysql_fetch_array($sql);
echo "<h2>Edit Jawaban</h2>";
echo "
<form method='POST' action='$aksi?module=jawaban&act=update' onsubmit='return cekIsi(this);'>
    	<table align='center' cellspacing='10'>
            <tr> 
            	<td>Jawaban</td>
                <td><textarea name='jJawaban' cols='150' rows='5'>$jawab[jJawaban]</textarea>
					<input type='hidden' name='jId' value='$jawab[jId]'>
                </td>
            </tr>
			<tr>
		  	<td>Jenis Soal</td>     
		  	<td>";
				if ($jawab['jJenis']=="A"){
					echo "<input type='radio' name='jJenis' id='jJenis1' value='A' checked>A</input>
						  <input type='radio' name='jJenis' id='jJenis2' value='B'>B</input>";
				}else{
					echo "<input type='radio' name='jJenis' id='jJenis1' value='A'>A</input>
						  <input type='radio' name='jJenis' id='jJenis2' value='B' checked>B</input>";
				}
			echo "
			</td>
		  	</tr>
            <tr>
            	<td colspan='3' align='center'><input type='submit' value='Update' name='simpanuser' class='button' />&nbsp; &nbsp; &nbsp; <input type='reset' class='button' value='Batal' onclick=self.history.back()></td>
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
   if (form.jJawaban.value == ""){
    alert("Jawaban masih kosong..!!");
	form.jJawaban.focus();
    return (false);
   }
   if (form.jJenis1.value == "")&&(form.jJenis2.value== ""){
    alert("Belum memilih Jenis!!");
	form.jJawaban.focus();
	return (false);
   }
   return (true);
   }   
</script> 
