<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_user/aksi_user.php";
switch($_GET[act]){
  // Tampil User
  default:
?>
<body>
<h2>Daftar User</h2>
    <div align="right"><a href='?module=user&act=tambahuser' class='button'>Tambah User</a> </div>    
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
                    <th><h3>No Id</h3></th>
                    <th><h3>Nama</h3></th>
                    
                    <th><h3>Username</h3></th>
                    <th><h3>Level</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
        include "../../koneksi.php";
                $sekolah = mysql_query("select * from user");
				while($s = mysql_fetch_array($sekolah)) {
					$no++;
		echo "
                <tr>
                    <td>$s[uId]</td>
                    
                    <td>$s[uNama]</td>
					<td>$s[uUsername]</td>
                    <td>$s[uLevel]</td>
					<td align='center'>
						<a href='$aksi?module=user&act=hapus&id=$s[uId]' onclick=\"return confirm('Apakah anda ingin menghapus user $s[uNama] ?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=user&act=ubah&id=$s[uId]'><img src='images/edit.png' title='Edit'></a>&nbsp;
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
 echo "<h2>Tambah User</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=user&act=input' onsubmit='return cekUser(this);'>
          <table>
          <tr><td>Nama</td>     
		  <td><input type='text' name='uNama' size='48'></td></tr>
          <tr><td>Level</td> 
		  <td><select name='uLevel'>
		  	<option value=''>---Pilih Level----</option>
			<option value='dekan'>Dekan</option>
			<option value='admin'>Administrator</option>
		  </select></td>
		  </tr>  
          <tr><td>Username</td>    
		  <td><input type=text name='uUsername' size=35></td></tr>
		  <tr><td>Password</td>       
		  <td><input type='password' name='uPassword' size=30></td></tr>
		  <tr><td>Ulangi Password</td>       
		  <td><input type='password' name='uPasswordU' size=30></td></tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "ubah" :
$sql=mysql_query("select * from user WHERE uId='$_GET[id]'");
$mahasiswa=mysql_fetch_array($sql);
echo "<h2>Edit User</h2>";
echo "
<form method='POST' action='$aksi?module=user&act=update' onsubmit='return cekUser(this);' >
    	<table align='center' cellspacing='10'>
            <tr>
            	<td>Nama Lengkap</td>
                <td>:</td>
                <td><input type='text' name='uNama' size='48' value='$mahasiswa[uNama]'>
					<input type='hidden' name='uId' size='48' value='$mahasiswa[uId]'>
				</td>
            </tr>
            <tr>
            	<td>Level</td>
                <td>:</td>
                <td>
				<select name='uLevel'>
					<option value=''>---Pilih Level----</option>
					<option value='dekan'>Dekan</option>
					<option value='admin'>Administrator</option>
				  </select>
				</td>
            </tr>
            <tr>
            	<td>Username</td>
                <td>:</td>
                <td><input type='text' name='uUsername' size='38' value='$mahasiswa[uUsername]'></td>
            </tr>
            <tr>
            	<td>Password</td>
                <td>:</td>
                <td><input type='password' name='uPassword' size='35'> <font color='red'><strong>*</strong></font></td>
            </tr>
             <tr>
            	<td>Ulangi Password</td>
                <td>:</td>
                <td><input type='password' name='uPasswordU' size='35'> <font color='red'><strong>*</strong></font></td>
            </tr>
			<tr>
            	<td colspan='3' align='left'><font color='red'><strong>*</strong> Kosongkan bila password tetap</font></td>
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
     
   function cekUser(form){ 
   if (form.uNama.value == ""){
    alert("Nama masih kosong !!");
    
	form.uNama.focus();
	return (false);
   }
   if (form.uLevel.value == ""){
    alert("Level masih kosong !!");
	form.uLevel.focus();
	return (false);
   }
   if (form.uUsername.value == ""){
    alert("Username masih kosong !!");
    
	form.uUsername.focus();
	return (false);
   }
   if (form.uPassword.value != form.uPasswordU.value){
    alert("Password tidak sama!!!");
	form.uPasswordU.focus();
	return (false);
   }
   return (true);
   }
</script> 
