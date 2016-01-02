<?php

require_once 'connect2db.php';
require_once 'filelib.php';

function check_login($username, $password){
	$conn = get_connection();

	$sql = "SELECT * FROM Users WHERE username ='$username' AND password ='$password' AND active=1 LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);

	if ($result->num_rows == 1) {
		$row =  mysqli_fetch_assoc($result);
		if($row['username'] == $username){
			return true;
		}
	}
	
	$conn->close();	

	return false;	
}

function validate_user($username){
	echo $username;
	if(strlen($username) > 0 && strlen(trim($username)) > 0){
		$conn = get_connection();
		$sql = "SELECT * FROM Users WHERE username ='$username' LIMIT 0,30";
		$result =  mysqli_query($conn, $sql);
		echo $sql;
		if ($result->num_rows == 0) {
			return true;
		}
	
		$conn->close();	
	}
	return false;
}


function create_user($username, $passwd, $fullname){
	if(strlen(trim($username)) > 0 && strlen(trim($passwd)) > 0){
		$conn = get_connection();

		$sql = "INSERT INTO Users(username, password, fullname, marks, active) VALUES('$username', '$passwd', '$fullname', 0, 0)";
		//if ($conn->query($sql) === TRUE) {
		if (mysqli_query($conn, $sql)){
			return true;
		}
	
		$conn->close();	
	}

	return false;
}

function active_exercise($exer_id, $username){
	$conn = get_connection();
	$sql = "SELECT marks FROM Users WHERE username='$username' LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);
	
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$marks = $row['marks'];
		if($marks >= ($exer_id - 1) * 5){
			return true;
		}
	}

	return false;
}

function list_exercises($username){
	$exercises = '';
	$conn = get_connection();

	$sql = "SELECT * FROM Exercise LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		$exercises = '<ul id="exercise">';
		while($row = $result->fetch_assoc()) {
			$exercises .= '<li>';
			if(active_exercise($row["exercise_id"], $username)){
				$exercises .= '<a href="do_exercise.php?id='.$row["exercise_id"].'">Bài số '.$row["exercise_id"].'</a>';	
				$exercises .= '<p>'.$row["name"].'</p>';
			}else{
				$exercises .= 'Bài số '.$row["exercise_id"];
				$exercises .= '<p>'.$row["name"].'</p>';
			}

			$exercises .= '</li>';		
		}
		$exercises .= '</ul>';
	}
	$conn->close();	
	
	return $exercises;
}

function get_question($exerid){
	$question = '';
	$conn = get_connection();
	$sql = "SELECT * FROM Exercise WHERE exercise_id=". $exerid ." LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);
	
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$question = $row["question"];
	}
	$conn->close();	
	
	return $question;
}

function get_answer($exerid){
	$answer = '';
	$conn = get_connection();

	$sql = "SELECT * FROM Exercise WHERE exercise_id=". $exerid ." LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);

	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$answer = $row["answer"];
	}
	$conn->close();	
	
	return $answer;
}

function get_marks($username){
	$conn = get_connection();
	$sql = "SELECT marks FROM Users WHERE username='$username' LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);
	
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$marks = $row['marks'];
		return $marks;
	}

	return 0;
}

function set_marks($username, $exer_id){
	if(strlen($username) > 0 && strlen(trim($username, ' ')) > 0 
		&& $exer_id > 0 && get_marks($username) < $exer_id*5){
		$conn = get_connection();
		
		$marks = get_marks($username) + 5;
		$sql = "UPDATE Users SET marks=".$marks." WHERE username='".$username."'";
		
		if ($conn->query($sql)===TRUE) {
			return true;
		}
	
		$conn->close();	
	}

	return false;
}

function ranking(){
	$ranking_board = '';

	$conn = get_connection();

	$sql = "SELECT * FROM Users ORDER BY marks DESC LIMIT 0,10";
	$result =  mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		$ranking_board .= '<table id="ranking-board">';
		$ranking_board .= '<tr>';
		$ranking_board .= '	<th>STT</th><th>Tài khoản</th><th>Điểm</th>';
		$ranking_board .= '</tr>';
		$num = 1;
		while($row = $result->fetch_assoc()) {
			$ranking_board .= '<tr>';
			$ranking_board .= '	<td align="center">'.$num.'</td><td>'.$row['username'].'</td><td align="right">'.$row['marks'].'</td>';
			$ranking_board .= '</tr>';	
			$num++;	
		}
		$ranking_board .= '</table>';
	}
	$conn->close();		
	
	return $ranking_board;
}

function get_sample_code($exerid){
	$conn = get_connection();
	$sql = "SELECT sample_code FROM Exercise WHERE exercise_id='$exerid' LIMIT 0,30";
	$result =  mysqli_query($conn, $sql);
	
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$sample_code = $row['sample_code'];
		return trim($sample_code);
	}

	return '(* Sample code *)&#10;';
}

function get_passed_code($exerid,  $username){
	$file_name = $username . '_exer_' . $exerid .'.pas';

	if(exist($file_name) === FALSE){
		return '';
	}
	
	$code = read_src_file($file_name);
	
	$passcode = '';
	if($exerid > 2){
		$pos1= stripos($code, '(*---*)');
		$pos2= strrpos($code, '(*---*)');
		$passcode =  substr($code, 0, $pos2);
		$passcode =  substr($passcode, $pos1 + 8);
	}else{
		$passcode = $code;
	}

	return $passcode;
}

function get_code($exerid, $username){
	$code = '';

	if(get_marks($username) >= $exerid * 5){
		$code = get_passed_code($exerid,  $username);
	}
	if(strlen($code) == 0 || strcmp($code, 'Unable to open file!') == 0){
		$code = get_sample_code($exerid);
	}
	
	return $code;	
}

function code_to_compile($code){
	$new_code = 
'program Exercise;
(*---*)
' . $code . '
(*---*)
begin
end.';
	return $new_code;
}

function code_to_test($exer_id, $code,  $filename){
	$new_code = '';
		
	if($exer_id == 3 || $exer_id == 4 || $exer_id == 5 || $exer_id == 6 ){
		$new_code = 'program TestProgram;

'.$code.'

begin
	writeln(cal(#NUM));
end.';	
	}

	return $new_code;
}
?>
