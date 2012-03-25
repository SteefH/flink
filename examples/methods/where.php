<?php

$values = array(1, 2, 3, 4, 5, 6);

$enum = \Flink\Enumerable::create($values)
	->where(function ($value) {
		return $value % 2 === 0;
	});
	
foreach($enum as $value) {
	echo "${value}\n";
}