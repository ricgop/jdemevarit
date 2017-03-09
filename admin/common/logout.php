<?php
	session_start();
	session_destroy();
	header("Location: http://localhost/jdemevarit/admin/prihlaseni.php");
?>