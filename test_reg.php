<?php

echo 'TEST REGEX<br />';
$str = ' Read(Name); writeln(\'Hello \',   name);';
$patt = '/ read(ln){0,1}[(][a-z]{1,}[)];/i';
$patt2 = '/ write(ln){0,1}[(]\'Hello \',( ){0,}[a-z]{1,}[)];/i';
echo preg_match($patt2, $str);
//print_r($matches);

echo '<br />-----------------------------------<br />';

$src_file = fopen("temp/admin_exer_2.pas", "r") or die("Unable to open file!");
$code = fread($src_file, filesize('temp/admin_exer_2.pas'));


$patt0 = '/var [a-z]{1,}( ){0,}:( ){0,}string( ){0,};/i';
$check = preg_match($patt0, $code, $arr);
print_r($arr);
$tmp = $arr[0];

$pos2 = strpos($tmp, 'var') + 3;
$tmp = substr($tmp, $pos2);
$pos = strpos($tmp, ':');
$tmp = substr($tmp, 0, $pos);

$tmp = trim($tmp);
$patt1 = '/read(ln){0,1}[(]'.$tmp.'[)];/i';
echo $patt1;
$check = preg_match($patt1, $code);


$patt2 = '/write(ln){0,1}[(]\'Hello \',( ){0,}[a-z]{1,}[)];/i';
$check += preg_match($patt2, $code);

echo $code;
echo 'Check: '.$check;

$str = 'Ha Noi mua thu 1945';
echo str_replace('1945','45', $str);
?>
