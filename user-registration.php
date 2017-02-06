<?php
	#$user_name = $_POST['name'];
	if(isset($_POST['name'])){$u_name = $_POST['name'];}
	if(isset($_POST['email'])){$u_email = $_POST['email'];}
	
	// pozdeji upravit if na to, aby udelal select do db podle a)username b)emailu a vyhodil error message pokud select vrati > 0 zaznamu
	if (isset($u_name)) {
		$msg = 'Jmeno jako vlozeno do DB!';
		echo $msg;
	} else {
		$emsg = 'Jmeno jako skoncilo s chybou...';
	}

	$abcd = 'abcd kocka prede';

	// connection to database
	/*
	$spoj = mysqli_connect('127.0.0.1','jdeme.varit','Jdemevarit123','jdemevarit');

 	// in case of error
 	if (!$spoj) {
    	die("Selhalo spojení s databází" . mysqli_error($spoj));
  	}

  	mysqli_close($spoj);*/
?>