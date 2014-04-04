<?php
 session_start(); 
 include "config/fungsi_rupiah.php";
 include"config/koneksi.php";
 include"config/fungsi_indotgl.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Fakultas Kedokteran Universitas Hasanuddin Makassar">
<meta name="author" content="kuisoner online">
<link rel="shortcut icon" href="adminmeu/images/favicon.ico" />
	<!-- batas include boostsrap -->
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
      }
    </style>
    
   	<link href="asset/css/bootstrap.css" rel="stylesheet">
    <link href="asset/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="asset/css/custom.docs.css" rel="stylesheet">
	
	<!-- include dtbale
	<link href="asset/dtable/DT_bootstrap.css" rel="stylesheet" media="screen">
	-->
	
    <script src="asset/js/jquery.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/bootstrap-tooltip.js"></script>
	<script src="asset/js/bootstrap-scrollspy.js"></script>
    <script src="asset/js/application.js"></script>
	
	<!-- include dtbale
	<script src="asset/dtable/datatables/js/jquery.dataTables.min.js"></script>
	<script src="asset/dtable/DT_bootstrap.js"></script>
	<script src="asset/dtable/scripts.js"></script>
	-->
	
	<!-- batas include boostsrap -->
<title>Fakultas Kedokteran Universitas Hasanuddin Makassar</title>
</head>
<body>
<!-- navigasi menu -->
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand pull-left" href="?p=home">MEU Fakultas Kedokteran - UNHAS</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="?p=home"><i class="icon-home icon-white"></i> Beranda</a></li>
              <?php
				if ($_SESSION[login]==1)
				{
    				echo "<li><a href='?p=kuesioner'><i class='icon-tasks icon-white'></i> Kuesioner</a></li>";
					echo "<li><a href='?p=materi'><i class='icon-book icon-white'></i> Download Materi</a></li>";
					echo "<li><a href='?p=jadwal'><i class='icon-calendar icon-white'></i> Jadwal</a></li>";
				}
				?>
            </ul>
            <?php
			if($_SESSION[login]==0){
			?>
            	<form class="navbar-form pull-right" method="post" action="cek_login.php">
		        <input class="span2" type="text" name="user" placeholder="Username">
        		<input class="span2" type="password" name="pass" placeholder="Password">
              	<button type="submit" class="btn btn-primary">Sign in</button>
            	</form>
			<?php
			}else{
			?>       
            	<div class="btn-group  pull-right">    
                <button class="btn btn-primary">
					<?php echo "$_SESSION[user_id]"; ?>
                </button>        
			  	<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                	<i class="icon-user icon-white"></i>&nbsp;
                </button>
			  	<ul class="dropdown-menu">
					<li><a href="?p=profil"><i class="icon-wrench"></i> Profil</a></li>
					<li class="divider"></li>
					<li><a href="logout.php"><i class="icon-off"></i> Log Out</a></li>
			  	</ul>
                </div>
            <?php
			}
			?>
          </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- navigasi menu -->

<header class="jumbotron subhead" id="overview">
	<div class="container">
		<img style="float:left ; margin: 0 20px 0 0;" alt="Unhas" src="asset/img/logo.png"></img>
		<h1>Selamat Datang di MEU Fakultas Kedokteran UNHAS</h1>
		<big>Medical Unit Education</big>
	</div>
</header>
<br>

<!-- content body -->
<div class="container-fluid">
<div class="row">
	<div class="container">
		<div class="hero-unit">
		<?php
        if ($_GET[p]=='home'){
			include "welcome.php";
		}elseif($_GET[p]=='materi'){
			include "materi.php";
		}elseif($_GET[p]=='kuesioner'){
			include "kuesioner.php";
		}elseif($_GET[p]=='profil'){
			include "profil.php";
		}elseif($_GET[p]=='jadwal'){
			include "jadwal.php";
		}else{
			include "welcome.php";	
		}
		?>
		</div>
     	<div class="container">
        	<div class="row">
     		<div class="span4">
   				<img src="asset/img/blog.png" height="48" width="48" style="float:left ; margin: 0 20px 0 0;"/>
				<h2>Info Terbaru</h2>			
				<?php
					$qi = mysql_query("SELECT * FROM info ORDER by iId DESC LIMIT 2");
					while($i=mysql_fetch_array($qi)){
						echo "<blockquote>";
						if (empty($i[iFile])){
							echo "<p>$i[iJudul]</p>";
						}else{
							echo "<p><a href='fileinfo/$i[iFile]'>$i[iJudul]</a></p>";
						}
						if (!empty($i[iIsi])){
							echo "<small>$i[iIsi]</small>";
						}
						echo "</blockquote>";
					}
				?>
       		</div><!--/span-->
            <div class="span4">
     			<img src="asset/img/home.png" height="48" width="48" style="float:left ; margin: 0 20px 0 0;"/>
				<h2>Kontak Kami</h2>
        		<p><strong>ICT Fakultas Kedokteran UNHAS</strong><br> 
                (Ruang ICT Lantai 3 Fakulatas Kedokteran)<br />
				Email : ictfkunhas@gmail.com
                </p>
       		</div><!--/span-->
			<div class="span4">
				<img src="asset/img/web.png" height="48" width="48" style="float:left ; margin: 0 20px 0 0;"/>
   				<h2>Web Link</h2>
            	<ul>
					<li><a href="http://unhas.ac.id">Web UNHAS</a></li>
					<li><a href="http://med.unhas.ac.id">Web Fakultas Kedokteran UNHAS</a></li>
					<li><a href="http://koas.med.unhas.ac.id">KOAS</a></li>
					<li><a href="http://krs.med.unhas.ac.id">KRS</a></li>
				</ul>
       		</div><!--/span-->
            </div>
		</div><!--/continer-->
        
    <hr>    
	<footer>
	   <p>&copy; Fakultas Kedokteran Unhas Makassar <?php echo date("Y");?> || Suppport by <span>Mediatama Solusindo</span></p>
	</footer> 
</div>   
</div><!--/.fluid-container-->
<!-- content body -->    
</body>
</html>