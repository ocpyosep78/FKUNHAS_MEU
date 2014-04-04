<?php
session_start();
 if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_mahasiswa/aksi_mahasiswa.php";
switch($_GET[act]){
  default:
?>
<body>
<h2>Daftar Mahasiswa</h2>
    <div align="right"><a href='?module=mahasiswa&act=tambahuser' class='button'>Tambah Mahasiswa</a> </div>    
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
                    <th class="nosort"><h3>No</h3></th>
                    <th><h3>Nim</h3></th>
                    <th><h3>Nama</h3></th>
                    <th><h3>Jurusan</h3></th>
					<th><h3>HP</h3></th>
					<th><h3>Email</h3></th>
                    <th width="70px" class="nosort"><h3>Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            <?php
				include "../../koneksi.php";
                $sekolah = mysql_query("SELECT * FROM mahasiswa");
				while($s = mysql_fetch_array($sekolah)) {
					$no++;
					if ($s[mJurusan]=="reg"){
						$jr="Regular";
					}else{
						$jr="Internasional";
					}
					if ($s[mTlahir]=='0000-00-00'){
						$tlahir = "-";
					}else{
						$tlahir = $s[mTlahir];
					}
					
		echo "
                <tr>
                    <td>$no</td>
                    <td>$s[mNim]</td>
                    <td>$s[mNama]</td>
					<td>$jr</td>
					<td>$s[mHp]</td>
					<td>$s[mEmail]</td>
					<td align='center'>
						<a href='$aksi?module=mahasiswa&act=hapus&id=$s[mNim]' onclick=\"return confirm('Apakah anda ingin menghapus mahasiswa $s[mNama] ?')\"><img src='images/del.png' title='Hapus'></a>&nbsp;
						<a href='?module=mahasiswa&act=ubah&id=$s[mNim]'><img src='images/edit.png' title='Edit'></a>&nbsp;";
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
case "tambahuser" :
 echo "<h2>Tambah Mahasiswa</h2>
 <div id='tablewrapper'>
		<div id='tableheader'>
        	<div class='search'>
          <form method=POST action='$aksi?module=mahasiswa&act=input' onsubmit='return cekUser(this);'>
          <table>
          <tr><td width='170px'>Nim</td>     
		  <td><input type=text name='mNim'></td></tr>
          <tr><td>Nama</td>     
		  <td><input type=text name='mNama' size=48></td></tr>
          <tr><td>Jurusan</td> 
		  <td><select name='mJur' id='mJur'>
		  	<option value=''>--Pilih Jurusan--</option>
			<option value='reg'>Reguler</option>
			<option value='int'>Internasional</option>
		  </select></td></tr> 
		  <tr><td>Angkatan</td>
		  <td><select name='mAngkatan' id='mAngkatan'>
		  	<option value=''>--Pilih Angkatan--</option>";
			for ($x=1990;$x<=2020;$x++){
				echo "<option value='$x'>$x</option>";
			}
		  echo "
		  </select></td></tr> 
		  <tr><td>Tanggal Lahir</td>
		  <td>";
			echo "<select name='mTgl'>";
				for ($x=1;$x<=31;$x++){
					echo "<option value='$x'>$x</option>";
				}
			echo "</select>
			<select name='mBln'>";
				for ($x=1;$x<=12;$x++){
					echo "<option value='$x'>";echo getBulan($x); "</option>";
				}
			echo "</select>
			<select name='mThn'>";
				for ($x=1990;$x<=2020;$x++){
				echo "<option value='$x'>$x</option>";
			}
			echo "</select>";
		  echo "
		  </td></tr> 
          <tr><td>Alamat</td>       
		  <td><input type=text name='mAlamat' size=58 id='mAlamat'></td></tr>
		  <tr><td>No HP</td>       
		  <td><input type=text name='mHp' size=20 id='mHP'></td></tr>
		  <tr><td>Email</td>       
		  <td><input type=text name='mEmail' size=50 id='mEmail'></td></tr>
		  <tr><td>Username</td>       
		  <td><input type=text name='mUsername' size=35></td></tr>
		  <tr><td>Password</td>       
		  <td><input type='password' name='mPassword' size=30></td></tr>
		  <tr><td>Ulangi Password</td>       
		  <td><input type='password' name='mPasswordU' size=30></td></tr>
          <tr><td colspan=2 align='center'><input type=submit class='button' value=Simpan>
                            <input type=button class='button' value=Batal onclick=self.history.back()></td></tr>
          </table></form></div></div></div>";
break;
case "ubah" :
$sql=mysql_query("select * from mahasiswa WHERE mNim='$_GET[id]'");
$mahasiswa=mysql_fetch_array($sql);

$tlhr = substr($mahasiswa[mTlahir],8,2);
$blhr = substr($mahasiswa[mTlahir],5,2);
$thn = substr($mahasiswa[mTlahir],0,4);

echo "<h2>Edit Mahasiswa</h2>";
echo "
<form method='POST' action='$aksi?module=mahasiswa&act=update' onsubmit='return cekUser(this);' >
    	<table align='center' cellspacing='10'>
            <tr> 
            	<td>Nim</td>
                <td>:</td>
                <td><input type='text' name='mNim' size='28' value='$mahasiswa[mNim]' readonly='readonly'>
                </td>
            </tr>
            <tr>
            	<td>Nama Lengkap</td>
                <td>:</td>
                <td><input type='text' name='mNama' size='48' value='$mahasiswa[mNama]'></td>
            </tr>
            <tr>
            	<td>Jurusan</td>
                <td>:</td>
                <td>
					<select name='mJur'>";
					if ($mahasiswa['mJurusan']=="reg"){
						echo "<option value='reg' selected>Reguler</option>
							  <option value='int'>Internasional</option>";
					}elseif($mahasiswa['mJurusan']=="int"){
						echo "<option value='reg'>Reguler</option>
							  <option value='int' selected>Internasional</option>";
					}
			echo	"</select>
				</td>
            </tr>
			<tr>
				<td>Angkatan</td>
				<td>:</td>
				<td>
					<select name='mAngkatan' id='mAngkatan'>";
						for ($x=1990;$x<=2020;$x++){
							if ($x==$mahasiswa[mAngkatan]){
								echo "<option value='$x' selected>$x</option>";
							}else{
								echo "<option value='$x'>$x</option>";
							}
						}
			   echo "</select>
			    </td>
			</tr> 
			<tr>
				<td>Tanggal Lahir</td>
				<td>:</td>
				<td>
					<select name='mTgl'>";
						for ($x=1;$x<=31;$x++){
							if ($x==$tlhr){
								echo "<option value='$x' selected>$x</option>";
							}else{
								echo "<option value='$x'>$x</option>";
							}
						}
			  echo "</select>
					<select name='mBln'>";
						for ($x=1;$x<=12;$x++){
							if ($x==$blhr){
								echo "<option value='$x' selected>".getBulan($x)."</option>";
							}else{
								echo "<option value='$x'>".getBulan($x)."</option>";
							}
						}
			  echo "</select>
					<select name='mThn'>";
						for ($x=1990;$x<=2020;$x++){
							if ($x==$thn){
								echo "<option value='$x' selected>$x</option>";
							}else{
								echo "<option value='$x'>$x</option>";
							}
						}
			  echo "</select>";
		  echo "
		  </td></tr> 
            <tr>
            	<td>Alamat</td>
                <td>:</td>
                <td><input type='text' name='mAlamat' size='58' value='$mahasiswa[mAlamat]'></td>
            </tr>
			<tr>
				<td>No HP</td> 
				<td>:</td>
				<td><input type='text' name='mHp' size=20 id='mHP' value='$mahasiswa[mHp]'></td>
			</tr>
			<tr>
				<td>Email</td> 
				<td>:</td>
				<td><input type='text' name='mEmail' size=50 id='mEmail' value='$mahasiswa[mEmail]'></td>
			</tr>
            <tr>
            	<td>Username</td>
                <td>:</td>
                <td><input type='text' name='mUsername' size='38' value='$mahasiswa[mUsername]'></td>
            </tr>
            <tr>
            	<td>Password</td>
                <td>:</td>
                <td><input type='password' name='mPassword' size='35'> <font color='red'><strong>*</strong></font></td>
            </tr>
             <tr>
            	<td>Ulangi Password</td>
                <td>:</td>
                <td><input type='password' name='mPasswordU' size='35'> <font color='red'><strong>*</strong></font></td>
            </tr>
            <tr>
            	<td colspan='3' align='center'><input type='submit' value='Update' name='simpanuser' class='button' />&nbsp; &nbsp; &nbsp; <input type='reset' class='button' value='Batal' onClick='self.history.back();'></td>
            </tr>
            <tr>
            	<td colspan='3' align='left'><font color='red'><strong>*</strong> Kosongkan bila password tetap</font></td>
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
   if (form.mNim.value == ""){
    alert("Nim masih kosong!!");
	form.mNim.focus();
    return (false);
   }
   if (form.mNama.value == ""){
    alert("Nama masih kosong !!");
	form.mNama.focus();
	return (false);
   }
   if (form.mJur.value == ""){
    alert("Jurusan masih kosong !!");
	form.mJur.focus();
	return (false);
   }
   if (form.mAngkatan.value == ""){
    alert("Belum memilih Angkatan !!");
	form.mAngkatan.focus();
	return (false);
   }
   if (form.mAlamat.value == ""){
    alert("Alamat masih kosong !!");
	form.mAlamat.focus();
	return (false);
   }
   if (form.mHP.value == ""){
    alert("No. HP masih kosong !!");
	form.mHP.focus();
	return (false);
   }
   if (form.mEmail.value == ""){
    alert("Email masih kosong !!");
	form.mEmail.focus();
	return (false);
   }
   if (form.mUsername.value == ""){
    alert("Username masih kosong !!");
	form.mUsername.focus();
	return (false);
   }
   if (form.mPassword.value=="")&&(form.simpanuser.value!="Update"){
	alert("Password masih kosong !!");
	form.mPassword.focus();
	return (false);
   }
   
   if (form.mPassword.value != form.mPasswordU.value){
    alert("Password tidak sama!!!");
	form.mPasswordU.focus();
	return (false);
   }
   return (true);
   }
   </script> 
