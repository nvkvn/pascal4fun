<?php

require 'libs/checklogin.php';
require 'libs/functions.php';
	
$username = $_SESSION["username"];
$exerid = $_GET['id'];
			
if(!active_exercise($exerid, $username)){
	header('Location: practice.php');
}

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
			if($exerid==null || $exerid==''){
				$exerid = 0;
			}
			$filename = $username . '_exer_' . $exerid;
		?>

		<header>
			<a href='index.php' class='Link'></a>
			<span id="profile" >
				Xin chào <a href="#"><?php echo $username; ?></a>(<span id="marks" class="marks"></span>) | 
				<a href="index.php">Trang chủ</a> |		
				<a href="logout.php">Đăng xuất</a>
			</span>
			
		</header>
		<div id="content">
			<?php

			echo '<div id="exercise-pane"></div>';
			
			if($exerid == 0){
				echo '<h2>Tập viết chương trình</h2>';
			}else{
				$question = get_question($exerid);

				echo '<h2>Bài số '.$exerid.'</h2>';
				echo '<p class="question">'.$question.'</p>';
			}

			?>
			<div id="left">
			<table class="large">
			<tr>
				<td> 
					<textarea name="code" id="code">
<?php
echo get_code($exerid, $username);
?>					</textarea>
				</td>	
			</tr>
			<tr>
				<td>
					<input type="button" onclick="compileFunct('<?php echo $filename; ?>.pas', <?php echo $exerid; ?>)" class="btn" value="Biên dịch" id="compile">
				</td>
			</tr>
			<tr>
				<td>
					<div id="result"></div>
				</td>									
			</tr>
			
			</table>
			</div>

			<div id="right">
				<?php
				$btn_value = "Kiểm thử";

				if($exerid < 3){
					$btn_value = "Chạy";
				}

				if($exerid != 0){
				?>
				<input type="button" onclick="executeFunct('<?php echo $filename; ?>', <?php echo $exerid; ?>)" class="btn btn2 btn-dis" value="<?php echo $btn_value; ?>" id="execute" disabled />
			 	<div id="output"></div>
				<?php } ?>
			</div>
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
	  updateMarks();
	</script>
	
</html>
