<?php

$values = array('a', 'b', 'c', 'd', 'e', 'x', 'y', 'z', 'a', 'b', 'c');

$exclude = array('d', 'x', 'y', 'b', 'x', 'q');

$enum = \Flink\Enumerable::create($values)->except($exclude);

// Take note: besides leaving out elements that are present in both collections,
// the except method also leaves out duplicates from the original collection

foreach($enum as $value) {
	echo "${value}\n";
}