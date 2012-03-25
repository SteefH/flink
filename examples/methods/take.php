<?php

$values = array('a', 'b', 'c', 'd', 'e', 'f');

$enum = \Flink\Enumerable::create($values)->take(3);
	
foreach($enum as $value) {
	echo "${value}\n";
}