<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda menuju halaman web'); window.location = '../'</script>";
?>