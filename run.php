<?php
include 'libs/filelib.php';
include 'libs/functions.php';
include 'libs/marksutil.php';

$filename = $_GET['filename'];
$exerid = $_GET['exerid'];

$code = read_src_file($filename.'.pas');

session_start();
$username = $_SESSION["username"];

if(strlen($filename)>0 && strlen($code)>0 &&  strlen($code)< 1000){
	$output = '';
	if($exerid<3){	
		$output = shell_exec('temp/'.$filename);
		echo $output;
		echo '<br />----------<br />';
		$output = trim($output);
	}
	
	if($exerid !=0){
		if(result($exerid, $filename, $code, $output)){
			set_marks($username, $exerid);
			
			echo '<p class="success"> Rất tốt !!!</p>';
			echo '<input type="button" id="next" class="btn btn3" value="Bài tiếp theo" onclick="nextExercise('.($exerid+1).')"/>';
		}else{
			echo '<p class="error"> Bạn hãy kiểm tra lại chương trình!!!</p>';
		}
	}	
}else{
	echo 'ERROR!!!';
}

?>
