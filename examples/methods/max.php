<?php

$values = array(32, 53, 1, 342, 0, 12);

$enum = \Flink\Enumerable::create($values);

echo "Maximum value: ".$enum->max();
