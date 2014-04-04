<?php
session_start();
date_default_timezone_set("Asia/Makassar");

if ($_SESSION[login]==1)
{  
	include"config/koneksi.php";
	switch($_GET[a])
	{
		default : 
		$sql=mysql_query("SELECT * FROM mahasiswa WHERE mNim='$_SESSION[issss]'");
		$mahasiswa=mysql_fetch_array($sql);
		$tlhr = substr($mahasiswa[mTlahir],8,2);
		$blhr = substr($mahasiswa[mTlahir],5,2);
		$thn = substr($mahasiswa[mTlahir],0,4);
	?>
	<div class="navbar navbar-inverse">
    	<div class="navbar-inner">
           	<div class="container">
            	<a class="brand" href="#"> Data Mahasiswa</a>
        	</div>
    	</div><!--/navbar-inner--> 
	</div><!--/navbar-->
    <hr>
    
    <form class="form-horizontal" method="POST" action="?p=profil&a=update" onSubmit='return cekUser(this);'>
    	<div class="control-group">
    		<label class="control-label">NIM</label>
    		<div class="controls">
            <input class="input-medium" type="text" name="mNim" readonly value="<?php echo "$mahasiswa[mNim]";?>">
            </div>
	    </div>
    	<div class="control-group">
    		<label class="control-label">Nama Lengkap</label>
    		<div class="controls">
            <input class="input-xlarge" type="text" name="mNama" value="<?php echo "$mahasiswa[mNama]";?>" required>
            </div>
	    </div>
        <div class="control-group">
    		<label class="control-label">Kelas</label>
    		<div class="controls">
            <?php
			if ($mahasiswa['mJurusan']=="reg")
			{
			?>
            <select name="mJurusan">
                <option value="reg">Regional</option>
                <option value="int">Internasional</option>
          	</select>
            <?php
            }else{
			?>
            <select name="mJurusan">
                <option value="int">Internasional</option>
				<option value="reg">Regional</option>
          	</select>
            <?php	
			}
			?>
            </div>
	    </div>
		
		<div class="control-group">
    		<label class="control-label">Angkatan</label>
    		<div class="controls">
				<select name='mAngkatan' id='mAngkatan' class='span2' required>
					<option value=''>-- Pilih Angkatan --</option>
					<?php
					for ($x=1990;$x<=2020;$x++){
						if ($mahasiswa[mAngkatan]==$x){
							echo "<option value='$x' selected>$x</option>";
						}else{
							echo "<option value='$x'>$x</option>";
						}
					}
					?>
				</select>
            </div>
	    </div>
		
		<div class="control-group">
    		<label class="control-label">Tanggal Lahir</label>
    		<div class="controls">
				<select name='mTgl' class='span1' required>
					<option value=''>Tgl</option>
					<?php
					for ($x=1;$x<=31;$x++){
						if ($tlhr==$x){
							echo "<option value='$x' selected>$x</option>";
						}else{
							echo "<option value='$x'>$x</option>";
						}
					}
					?>
				</select>
				<select name='mBln' class='span2' required>
					<option value=''>Bulan</option>
					<?php
					for ($x=1;$x<=12;$x++){
						if ($blhr==$x){
							echo "<option value='$x' selected>";echo getBulan($x); "</option>";
						}else{
							echo "<option value='$x'>";echo getBulan($x); "</option>";
						}
					}
					?>
				</select>
				<select name='mThn' class='span1' required>
					<option value=''>Thn</option>
					<?php
					for ($x=1990;$x<=2020;$x++){
						if ($thn==$x){
							echo "<option value='$x' selected>$x</option>";
						}else{
							echo "<option value='$x'>$x</option>";
						}
					}
					?>
				</select>
            </div>
	    </div>
		 
		<div class="control-group">
    		<label class="control-label">Alamat</label>
    		<div class="controls">
            <input class="input-xxlarge" type="text" name="mAlamat" value="<?php echo "$mahasiswa[mAlamat]";?>" required>
            </div>
	    </div>
		
		<div class="control-group">
    		<label class="control-label">No HP</label>
    		<div class="controls">
            <input class="input-large" type="text" name="mHp" value="<?php echo "$mahasiswa[mHp]";?>" required>
            </div>
	    </div>
		
		<div class="control-group">
    		<label class="control-label">Email</label>
    		<div class="controls">
            <input class="input-xlarge" type="text" name="mEmail" value="<?php echo "$mahasiswa[mEmail]";?>" required>
            </div>
	    </div>
		
        <div class="control-group">
    		<label class="control-label">Username</label>
    		<div class="controls">
            <input class="input-medium" type="text" name="mUsername" value="<?php echo "$mahasiswa[mUsername]";?>">
            </div>
	    </div>
        <div class="control-group">
    		<label class="control-label">Password</label>
    		<div class="controls">
            <input class="input-medium" type="password" name="mPassword"> <strong>*</strong>
            </div>
	    </div>
        <div class="control-group">
    		<label class="control-label">Ulangi Password</label>
    		<div class="controls">
            <input class="input-medium" type="password" name="mPasswordU"> <strong>*</strong>
            </div>
	    </div>
        
        <div class="control-group">
    		<div class="controls">
				<span class="label label-important">* Kosongkan bila password tetap</span>
            </div>
	    </div>
        
    	<div class="control-group">
    		<div class="controls">
            	<button class="btn btn-primary" type"submit" name="simpanuser"><i class="icon-ok-sign icon-white"></i> Simpan</button>
                <button class="btn" type='reset' onClick='self.history.back();'><i class="icon-remove"></i> Batal</button>
		    </div>
    	</div>
        
    </form>
    
	<?php
    break;	
	case "update" :
		if (isset($_POST['simpanuser']))
		{
			$mNama=$_POST['mNama'];
			$mJurusan=$_POST['mJurusan'];
			$mAngkatan=$_POST['mAngkatan'];
			$mTlahir = $_POST['mThn']."-".$_POST['mBln']."-".$_POST['mTgl'];
			$mAlamat=$_POST['mAlamat'];
			$mHp=$_POST['mHp'];
			$mEmail=$_POST['mEmail'];
			$mUsername=$_POST['mUsername'];
			$mPassword=$_POST['mPassword'];
			$mPasswordU=$_POST['mPasswordU'];

			If(($mPassword=="") or ($mPassword=="")){
				$sqlUp = mysql_query("UPDATE mahasiswa SET mNama='$mNama', 
														   mJurusan='$mJurusan',
														   mAngkatan='$mAngkatan',
														   mTlahir='$mTlahir',
														   mAlamat='$mAlamat',
														   mHp='$mHp',
														   mEmail='$mEmail', 
														   mUsername='$mUsername' WHERE mNim='$_SESSION[issss]'");
			}else{
				$mPass=md5($mPassword);
				$sqlUp = mysql_query("UPDATE mahasiswa SET mNama='$mNama', 
														   mJurusan='$mJurusan',
														   mAngkatan='$mAngkatan',
														   mTlahir='$mTlahir',
														   mAlamat='$mAlamat', 
														   mHP='$mHp', 
														   mEmail='$mEmail', 
														   mUsername='$mUsername', 
														   mPassword='$mPass' WHERE mNim='$_SESSION[issss]'");
			}
			if ($sqlUp){ 
				echo "<script>alert ('Data Mahasiswa Berhasil Diubah');</script>";
			}else{
				echo "<script>alert ('Data Mahasiswa Gagal Diubah');</script>";
			}
       echo "<script> parent.location='?p=home';</script>";
	} break;		
	}
}else{
	echo"<script>parent.location ='index.php';</script>";
}
?>