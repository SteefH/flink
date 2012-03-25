<?php

$values = array('first', 'second', 'third');

$enum = \Flink\Enumerable::create($values);

echo 'Last element: '.$enum->lastOrDefault('none');
echo "\n";

$values = array();

$enum = \Flink\Enumerable::create($values);

echo 'Last element: '.$enum->lastOrDefault('none');
