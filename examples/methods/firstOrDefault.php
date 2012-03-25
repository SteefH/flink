<?php

$values = array('first', 'second', 'third');

$enum = \Flink\Enumerable::create($values);

echo 'First element: '.$enum->firstOrDefault('none');
echo "\n";

$values = array();

$enum = \Flink\Enumerable::create($values);

echo 'First element: '.$enum->firstOrDefault('none');
