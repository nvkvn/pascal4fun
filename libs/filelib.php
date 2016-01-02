<?php

function exist($file_name){
	if(file_exists("temp/" . $file_name) === TRUE){
		return true;
	}
	return false;
}

function write_src_file($file_name, $content){
	$srcfile = fopen("temp/". $file_name, "w") or die("Unable to open file!");
	$result = fwrite($srcfile, $content);
	fclose($srcfile);
	return $result;
}

function read_src_file($file_name){
	$src_file = fopen("temp/" . $file_name, "r") or die("Unable to open file!");
	$content = fread($src_file, filesize("temp/" . $file_name));
	fclose($src_file);

	return $content;
}

function remove($file_name){
	if(file_exists("temp/" . $file_name) === TRUE){
		unlink("temp/" . $file_name);	
		return true;
	}
	return false;
}
?>
