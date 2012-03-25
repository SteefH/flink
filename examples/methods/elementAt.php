<?php

$values = array('a', 'b', 'c', 'd', 'e');
$enum = \Flink\Enumerable::create($values);
echo "Element at position 3: ";
var_dump($enum->elementAt(3));