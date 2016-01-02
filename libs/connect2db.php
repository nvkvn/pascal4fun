<?php
function get_connection(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "pascal4fun";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}	

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	mysqli_set_charset($conn,"utf8");
	return $conn;
}
?> 
