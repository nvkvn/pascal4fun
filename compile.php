<?php

require 'libs/filelib.php';// Nhung filelib php vao file
require 'libs/functions.php';

$content = $_POST['code']; // Lay code cua nguoi dung nhap
$filename = $_POST['filename'];//Lay ten tep tin chua code nguoi hoc
//$exer_id = $_POST['exer_id'];
$exer_id = isset($_POST['exer_id']) ? $_POST['exer_id'] : '';

if($exer_id > 2){
	$code = code_to_compile($content);
	$code2test = code_to_test($exer_id, $content,  $filename);
	$testfilename = str_replace('.pas', '_4test.pas', $filename);

	$check = write_src_file($filename, $code);
	write_src_file($testfilename, $code2test);
}else{
	$check = write_src_file($filename, $content);
}

if($check>0 && strlen($filename)>0){
	$res =  shell_exec('fpc temp/'.$filename) . '';
	
	$pos = strpos($res, 'Error');
	if($pos > 0){
		$res = 'Có lỗi, bạn hãy kiểm tra lại mã Pascal!!!<br/>----------<br />'. substr($res, $pos, -1);
	}else{
		$res = 'Biên dịch thành công.';
	}
	echo $res;
	
}else{
	echo 'Compile Error!!';
}

?>
