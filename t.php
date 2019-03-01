<?php
error_reporting(1);
/*
$f = file("proxy.txt");
$arrc = array_chunk($f,2);
foreach($arrc as $a)
{
	foreach($a as $k)
		echo $k.'<br/>';
	echo "<hr/>";
}
*/

echo 'test<br/>';

$file = "cookie.txt";
$rand = rand(1,10);
$fget = file_get_contents($file);
$content = empty($fget) ? $rand : $fget."\n".$rand;
file_put_contents($file, $content);
$th = array_chunk(file('cookie.txt'),2);
foreach($th as $a)
{
	for($i = 0; count($a)>=$i;++$i)
		echo $a[$i];
	echo "<br/><br/>";
}


