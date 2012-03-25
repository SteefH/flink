<?php

$values = array(1, 2, 3, 100, 4, 5, 100, 6);

$enum = \Flink\Enumerable::create($values)
	->skipWhile(function ($value) {
		return $value !== 100;
	});
	
foreach($enum as $value) {
	echo "${value}\n";
}