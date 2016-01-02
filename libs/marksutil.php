<?php

require_once 'filelib.php';

function check_code_2($code){
	$patt0 = '/var( ){1,}[a-z0-9]{1,}( ){0,}:( ){0,}string( ){0,};/i';//Regular Expression (bieu thuc chinh quy\quy tac)
	$check = preg_match($patt0, $code, $arr);
	
	$tmp = isset($arr[0])? $arr[0] : '';
	$pos1 = strpos($tmp, 'var') + 3;
	$tmp = substr($tmp, $pos1);
	$pos2 = strpos($tmp, ':');
	$tmp = substr($tmp, 0, $pos2);

	$var_name = trim($tmp);
	$patt1 = '/read(ln){0,1}[(]' . $var_name . '[)];/i';
	$check += preg_match($patt1, $code);
	$patt2 = '/write(ln){0,1}[(]\'Hello \',( ){0,}' . $var_name . '[)];/i';
	$check += preg_match($patt2, $code);

	return $check;
}

function test_result($x, $filename, $code2test){
	$tmp_code = str_replace('#NUM', $x, $code2test);
	
	$full_file_name = $filename.'_4test-'.$x;
	
	write_src_file($full_file_name .'.pas', $tmp_code);

	shell_exec('fpc temp/'.$full_file_name.'.pas');
	$res =  shell_exec('temp/'.$full_file_name);

	//Xoa cac ky tu trang di cho nhe:
	$res = trim($res);
		
	//Xoa tep sinh ra de Test:
	remove($full_file_name); //Runable
	remove($full_file_name.'.o');	//Link object
	remove($full_file_name.'.pas');	//Source code

	return $res;
}

function run_tests($filename, $test_cases){
	$code2test = read_src_file($filename.'_4test.pas');
		
	$count_pass = 0;
	$result = array(count($test_cases));
	foreach($test_cases as $key=>$value){
		
		$result[$key] = test_result($key, $filename, $code2test);
		if($result[$key] == $value){
			$count_pass++;
		}
	}
	remove($filename); //Xoa tep chuong trinh
	remove($filename.'.o'); //Xoa tep lien ket bien dich

	echo show_testing_result($test_cases, $result);

	if($count_pass == count($test_cases)){
		return true;
	}

	return false;
}

function show_testing_result($test_cases, $result){
	
	$testing_result = '<table class="testing-res">';
	$testing_result .= '<tr class="header">';
	$testing_result .= '	<td>x</td>';
	$testing_result .= '	<td>Kỳ vọng</td>';
	$testing_result .= '	<td>Thực tế</td>';
	$testing_result .= '	<td></td>';
	$testing_result .= '</tr>';

	foreach($test_cases as $key=>$value){
		$status = '&nbsp;';
		$css = 'fail';
		if($result[$key] == $value || strcmp($result[$key], $value) == 0){
			$css = 'pass';
		}

		$testing_result .= '<tr class="'.$css.'">';
		$testing_result .= '	<td>'.$key.'</td>';
		$testing_result .= '	<td>'.$value.'</td>';
		$testing_result .= '	<td>'.$result[$key].'</td>';
		$testing_result .= '	<td><span>'.$status.'</span></td>';
		$testing_result .= '</tr>';
	}

	$testing_result .= '</table>';

	return $testing_result;
}

function get_testcases($exerid){
	$cases = array();
	
	for ($i=0; $i<10; $i++)
	{
		$x = rand(0,50);

		switch($exerid){
			case "3": $expect = $x - 1; break;
			case "4": $expect = $x%2 + 1; break;
			case "5": 
				{
					if($x%2 == 0){
						$expect = "chan";
					}else{
						$expect = "le";
					}
				}
				break;
			case "6": 
				{	
					$sum = 0;
					for ($j = 0; $j<=$x; $j++)
					{ 
						$sum = $sum + $j;	
					}
					$expect = $sum;

				} 
				break;
		}

		$cases[$x] = $expect;
	}

	return $cases;
}

function result($exerid, $filename, $code, $output){
	if($exerid == 1){	
		$answer = get_answer($exerid);
		if(strcmp($output, $answer) == 0){
			return true;
		}
	}elseif($exerid == 2){
		$check = check_code_2($code);
		$answer = get_answer($exerid);
		$answer = trim($answer);

		if($check == 3 && strcmp($output, $answer) == 0){
			return true;
		}	
	}elseif($exerid == 3 || $exerid == 4 || $exerid==5 || $exerid==6){ 
		$cases = get_testcases($exerid);
		if(run_tests($filename, $cases)){
			return true; 
		}
	}
	
	return false;
}
?>
