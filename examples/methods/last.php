<?php

$values = array('first', 'second', 'third');

$enum = \Flink\Enumerable::create($values);

echo 'Last element: '.$enum->last();