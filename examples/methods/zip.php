<?php

$numbers = array(1, 2, 3, 4, 5, 6);
$letters = array('a', 'b', 'c', 'd');

$enum = \Flink\Enumerable::create($numbers)->zip($letters);
	
foreach($enum as $value) {
	print_r($value);
}