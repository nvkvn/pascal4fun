<?php
require 'libs/checklogin.php';
require 'libs/functions.php';
	
$username = $_SESSION["username"];
$exercises = list_exercises($username);

echo $exercises;
?>
