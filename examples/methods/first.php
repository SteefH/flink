<?php

$values = array('first', 'second', 'third');

$enum = \Flink\Enumerable::create($values);

echo 'First element: '.$enum->first();