<?php
require 'libs/functions.php';

session_start();

$username = $_POST['username'];
$passwd = $_POST['password'];
$passwd = md5($passwd);
echo 'Login ...';
if (check_login($username, $passwd)) {
	$_SESSION["username"] = $username;
	$_SESSION["logged"] = "True";
	$_SESSION["loggedTime"] = date("Y-m-d h:i:s");
	
	header('Location: practice.php');
} else {
	$_SESSION["username"] = "";
    	$_SESSION["logged"] = "False";
	$_SESSION["loggedTime"] = "";

	header('Location: login.php');
}

?>
