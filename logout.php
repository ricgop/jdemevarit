<?php
	session_start();
	session_destroy();
	include 'menu.html';
	echo '<div class="alert alert-success"><strong>Odhlášení</strong> proběhlo úspěšně!</div>'; header( "refresh:3;url=http://localhost/jdemevarit/recepty.php" );
?>