<?php
session_start();
error_reporting(0);
if (empty($_SESSION['user_id']) AND empty($_SESSION['password'])){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'><link href='css/reset.css' rel='stylesheet' type='text/css'>
 <center><br><br><br><br><br><br>Maaf, untuk masuk <b>Halaman Administrator</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=143></a>
             </div>";
  echo "<input type=button class=simplebtn value='LOGIN DI SINI' onclick=location.href='index.php'></a></center>";
}
else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description"  content="kuesioner fakultas kedokteran unhas"/>
<meta name="keywords" content="unhas, kedokteran, kuesioner"/>
<meta name="robots" content="ALL,FOLLOW"/>
<meta name="Author" content="Ardhe DeFourteenz"/>
<meta http-equiv="imagetoolbar" content="no"/>
<title>.::Halaman Administrator::.</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="stylesheet" href="css/reset.css" type="text/css"/>
<link rel="stylesheet" href="css/style.css" type="text/css"/>
<link rel="stylesheet" href="css/screen.css" type="text/css"/>
<link rel="stylesheet" href="css/fancybox.css" type="text/css"/>
<link rel="stylesheet" href="css/jquery.wysiwyg.css" type="text/css"/>
<link rel="stylesheet" href="css/jquery.ui.css" type="text/css"/>
<link rel="stylesheet" href="css/visualize.css" type="text/css"/>
<link rel="stylesheet" href="css/visualize-light.css" type="text/css"/>
<link rel="stylesheet" href="tabel/style.css" />
<script type="text/javascript" src="tabel/script.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
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

</head>

<body>
	<!--header-->
	<div class="header clear">
    		<div class="header title">MEU Fakultas Kedokteran - UNHAS</div>
			<ul class="links clear">
				<li>..::&nbsp;&nbsp;Selamat Datang <?=$_SESSION[user_id]?>&nbsp;&nbsp;::..&nbsp;&nbsp;</li>
			<li><a href="?module=home"><img src="images/home.png" alt="" class="icon" /> <span class="text">Beranda</span></a></li>
			<li><a href="logout2.php"><img src="images/ico_view_24.png" alt="" class="icon" /><span class="text">Lihat Website</span></li>
			<li><a href="logout.php"><img src="images/ico_logout_24.png" alt="" class="icon" /> <span class="text">Keluar</span></a></li>
			</ul>
	</div>
    <!--header-->
    <!--sidebar-->   
	<div class="sidebar">
		<div class="logo clear" align="center">
        	<img src="images/logo.png" alt=""/>
            <div><strong>Fakultas Kedokteran<br />Universitas Hasanuddin</strong></div>
        </div>
        
		<div class="menu">
		  <ul>
          	 <?php
			if ($_SESSION['level']=='admin'){
			echo "<li><a href=#>MENU MASTERS</a><ul>";
					include "menumaster.php";
			echo "</ul></li>";
			}
			?>
            <li><a href="#">HASIL</a>
			    <ul>
				  <?php include "menuhasil.php"; ?>
				</ul>
			</li>
            <?php
			if ($_SESSION['level']=='admin'){
			echo "<li><a href=#>PENGATURAN</a><ul>";
					include "menusetting.php";
			echo "</ul></li>";
			}
			?>
			</ul>
	  	</div>
	</div>
    <!--sidebar-->
	
	<div class="main"> <!-- mainpage layout -->    	
		<div class="main-wrap">
			<div class="page clear">			
				<div class="notification note-success">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td width="2%">&nbsp;</td>
			      <td width="95%"><?php include "content.php"; ?></td>
			      <td width="3%">&nbsp;</td>
			    </tr>
				</table>
				</div>
                <!-- end of content-box -->
			</div><!-- end of page -->		
            <div class="footer"></div>
		</div>
	</div>
<!--
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12958851-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->
</body>

<meta http-equiv="content-type" content="text/html;charset=UTF-8">
</html>
<?php
}
?>