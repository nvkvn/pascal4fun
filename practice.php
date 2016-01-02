<?php

include 'libs/checklogin.php';
include 'libs/functions.php';
	
$username = $_SESSION["username"];

?>
<html>
	<head>
		<title>Pascal 4fun | Thực hành</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="css/style.css">

		<link rel="stylesheet" href="js/lib/codemirror.css">
		<script src="js/lib/codemirror.js"></script>
		<script src="js/mode/pascal/pascal.js"></script>

		<script src="js/jquery-1.11.3.js"></script>
		<script src="js/script.js"></script>
		
	</head>
	
	<body>
		<?php
			$exerid = $_GET['id'];
			if($exerid==null || $exerid==''){
				$exerid = 0;
			}
			$filename = $username . '_exer_' . $exerid;
		?>

		<header>
			<a href='index.php' class='Link'></a>
			<span id="profile" >
				Xin chào <a href="#"><?php echo $username; ?></a>(<span class="marks"><?php echo get_marks($exerid, $username); ?></span>) | 
				<a href="index.php">Trang chủ</a> |			
				<a href="logout.php">Đăng xuất</a>
			</span>
			
		</header>
		<div id="content">
			<?php
			echo '<div id="exercise-pane"></div>';
			echo '<h2>Tập viết chương trình</h2>';
			?>
			
			<form method="post">
			<table class="large">
			<tr>
				<td valign="top">
					Mã Pascal:
				</td>
				<td> 
					<textarea name="code" id="code">
program Excercise<?php echo $exerid; ?>;
begin
	(*  Viết mã Pascal ở đây *)
end.			
					</textarea>
				</td>	
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="button" onclick="compileFunct('<?php echo $filename; ?>.pas')" class="btn" value="Biên dịch" id="compile">
				</td>
			</tr>
			<tr>
				<td valign="top">
					Kết quả biên dịch:
				</td>
				<td>
					<div id="result"></div>
				</td>									
			</tr>
			</table>
			</form>
		</div>
	</body>

	<script>
	  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		lineNumbers: true,
		mode: "text/x-pascal"
	  });
	</script>
	<script>
	  getExercises();
	</script>
</html>
