<?php

$values = array(
	array(1, 2, 3, 4, 5, 6),
	array(10, 20, 30, 40, 50, 60),
	array(100, 200, 300, 400, 500, 600)
);

$enum = \Flink\Enumerable::create($values)
	->selectMany(function ($value) {
		return array_slice($value, 2);
	});
	
foreach($enum as $value) {
	echo "${value}\n";
}