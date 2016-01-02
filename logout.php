<?php
	session_start();

	$_SESSION["logged"] = '';
	$_SESSION["loggedTime"] = '';
	$_SESSION["username"] = '';
	
	session_unset(); 
	session_destroy(); 
	header('Location: login.php');
	
?>
