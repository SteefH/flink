<?php

$values = array('a', 'b', 'c', 'd', 'e', 'f');

$enum = \Flink\Enumerable::create($values)->skip(3);
	
foreach($enum as $value) {
	echo "${value}\n";
}