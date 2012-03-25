<?php

$enum = \Flink\Enumerable::create(
		array(1, 2, 3, 4, 5, 6)
	)->concat(
		array(10, 20, 30, 40, 50, 60)
	)->concat(
		array(100, 200, 300, 400, 500, 600)
	);
	
foreach($enum as $value) {
	echo "${value}\n";
}