<?php

function comma_seperate($string_array, $line_break_flag) {
	$string  = array_shift($string_array);
	foreach($string_array as $s) {
		$string .= ",";
		if($line_break_flag) {
			$string .= "\n";
		} else {
			$string .= " ";
		}
		$string .= $s;
	}
	return $string;
}