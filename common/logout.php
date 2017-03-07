<?php
	session_start();
	session_destroy();
	header("Location: http://localhost/jdemevarit/recepty.php?page1");
?>