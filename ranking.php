<html>
	<head>
		<title>Pascal 4fun | Lý thuyết</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="css/main.css">

	</head>
	
	<body>
		<header>
			<a href='index.php' class='Link'></a>
		</header>
		<div id="content">
			<div id="ranking">
				<h2>Bảng xếp hạng</h2>
				<?php 
				//ini_set('display_errors', 'On');
				require 'libs/functions.php';
				echo ranking();
				?>
			</div>
		</div>
	</body>
</html>
