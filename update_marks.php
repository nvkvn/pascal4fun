<?php
require 'libs/checklogin.php';
require 'libs/functions.php';

$username = isset($_SESSION["username"])? $_SESSION["username"]: '';
echo get_marks($username);
?>
