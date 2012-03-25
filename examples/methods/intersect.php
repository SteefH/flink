<?php

$values = array('a', 'b', 'c', 'd', 'e', 'x', 'y', 'z', 'a', 'b', 'c');

$other = array('d', 'x', 'y', 'b', 'x', 'q');

$enum = \Flink\Enumerable::create($values)->intersect($other);

// Take note: intersect results in a collection without duplicates

foreach($enum as $value) {
	echo "${value}\n";
}