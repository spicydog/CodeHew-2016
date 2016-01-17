<?php

$inputFile = 'tooeasy_input.txt';
$outputFile = 'spicydog_tooeasy_output.txt';

$handle = @fopen('tooeasy_input.txt', 'r');

$output = '';
$T = intval(fgets($handle));
for ($t=0; $t<$T; $t++) {
	$N = intval(fgets($handle));
	
	if (isHard($N)) {
		$result = 'hard';
	} else {
		$result = 't' . str_repeat('o', $N) . ' easy';
	}
	$result .= "\n";
	
	echo $result;
	$output .= $result;
}
fclose($handle);
file_put_contents($outputFile, $output);

function isHard($n) {
	return $n%3 === 0 || $n%7 === 0;
}