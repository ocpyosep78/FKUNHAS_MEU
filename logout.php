<?php
	session_start();
	unset($_SESSION[user_id]);
	unset($_SESSION[level]);
	unset($_SESSION['login']);
	session_destroy()
?>
<script>
parent.location = "index.php";
</script>