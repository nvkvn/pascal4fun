<?php
require 'libs/functions.php';

$user = isset($_POST['username']) ? $_POST['username'] : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';
$repass = isset($_POST['repassword']) ? $_POST['repassword'] : '';
$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
$code = 0;

if (validate_user($user)==true){
	
	if (strcmp($pass,$repass)==0 && strlen(trim($pass))){	
		$pass = md5($pass);
		$repass = md5($repass);

		$check = create_user($user, $pass, $fullname);
		if($check==true){
			header('Location: login.php');
		}else{
			$code = 1;
		}
	}else{
		$code = 2;
	}
		
} else {
	$code = 3;
}

if($code > 0){
	header('Location: register.php?error='.$code);
}
?>
