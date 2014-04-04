<?php
date_default_timezone_set('Asia/Makassar');
include "koneksi.php";
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_combobox.php";
include "../config/class_paging.php";
include "../config/fungsi_rupiah.php";

// Bagian Home
if ($_GET[module]=='home'){
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[user_id]</b>, selamat datang di halaman Administrator.<br> Silahkan klik menu pilihan yang berada 
          di sebelah kiri untuk mengelola konten website anda. </p>
          <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo " WITA</p>";
}

// Bagian Modul
elseif ($_GET[module]=='mahasiswa'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_mahasiswa/mahasiswa.php";
  }
}
elseif ($_GET[module]=='matakuliah'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_matakuliah/matakuliah.php";
  }
}
elseif ($_GET[module]=='materi'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_materi/materi.php";
  }
}
elseif ($_GET[module]=='jadwal'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_jadwal/jadwal.php";
  }
}
elseif ($_GET[module]=='info'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_info/info.php";
  }
}
elseif ($_GET[module]=='soal'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_soal/soal.php";
  }
}
elseif ($_GET[module]=='jawaban'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_jawaban/jawaban.php";
  }
}
elseif ($_GET[module]=='hasil'){
    include "modul/mod_hasil/hasil.php";
}
elseif ($_GET[module]=='rekaphasil'){
    include "modul/mod_laporanblok/laporanblok.php";
}
elseif ($_GET[module]=='tahunajaran'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_tahunajaran/tahunajaran.php";
  }
}
elseif ($_GET[module]=='user'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_user/user.php";
  }
}

/*
elseif ($_GET[module]=='dosen'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_dosen/dosen.php";
  }
}
elseif ($_GET[module]=='jadwalkuliah'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_jadwalkuliah/jadwalkuliah.php";
  }
}
elseif ($_GET[module]=='jadwalmengajar'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_jadwalmengajar/jadwalmengajar.php";
  }
}
elseif ($_GET[module]=='topik'){
  if ($_SESSION['level']=='admin'){
    include "modul/mod_topik/topik.php";
  }
}
*/
// Apabila modul tidak ditemukan
else{
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[user_id]</b>, selamat datang di halaman Administrator.<br> Silahkan klik menu pilihan yang berada 
          di sebelah kiri untuk mengelola konten website anda. </p>
          <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo " WITA</p>";
}
?>
