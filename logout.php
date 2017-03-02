<?php
	session_start();
	session_destroy();
	include 'common/menu.html';
	echo '<div class="alert alert-success"><strong>Odhlášení</strong> proběhlo úspěšně!</div>'; header( "refresh:2;url=http://localhost/jdemevarit/recepty.php" );
?>