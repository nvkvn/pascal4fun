<?php

	session_start();	
	$isLogged = $_SESSION["logged"];
	$loggedTime = $_SESSION["loggedTime"];
	
	if($isLogged != "True"){
		header('Location: login.php');
	}
?>
