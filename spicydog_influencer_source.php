<?php

$inputFile = 'influencer_input.txt';
$outputFile = 'spicydog_influencer_output.txt';

$handle = @fopen('influencer_input.txt', 'r');

$output = '';
$L = intval(fgets($handle));
for ($l=0; $l<$L; $l++) {
	$wr = explode(' ', fgets($handle));
	$M = intval($wr[0]);
	$target = intval($wr[1]);
	$writers = [];
	for ($m = 0; $m<$M; $m++) {
		$writers[] = array_map('intval', explode(' ', str_replace(' 0', '', fgets($handle))));
	}
	$result = compute($writers, $target, 1, count($writers)) . "\n";
	echo $result;
	$output .= $result;
}
fclose($handle);
file_put_contents($outputFile, $output);


function compute(&$writers, &$target, $min, $max, $prev = []) {
	$bestResult = INF;
	for ($i=$min; $i<=$max; $i++) {
		$new = array_merge($prev, [$i]);

		$result = compute($writers, $target, $i+1, $max, $new);
		if ($result < $bestResult) {
			$bestResult = $result;
		}
		$result = matchWriters($writers, $target, $new);
		if ($result < $bestResult) {
			$bestResult = $result;
		}
	}
	return $bestResult;
}

function matchWriters(&$writers, &$target, $ids) {
	$candicates = [];
	foreach ($ids as $id) {
		$candicates[] = $writers[$id-1];
	}

	if (validate($candicates, $target)) {
		return count($candicates);
	} else {
		return INF;
	}
}

function validate($writers, $target) {
	$readers = [];
	foreach ($writers as $writer) {
		foreach ($writer as $reader) {
			$readers[$reader] = true;
		}
		if (count($readers) === $target) {
			return true;
		}
	}
	return false;
}

