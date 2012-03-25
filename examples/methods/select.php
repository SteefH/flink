<?php

$values = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

$enum = \Flink\Enumerable::create($values)
	->select(function ($value) {
		return "${value}^2 = ".($value * $value);
	});
	
foreach($enum as $value) {
	echo "${value}\n";
}