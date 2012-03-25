<?php

$values = array(23, 352, 21, 435, 49);

$average = \Flink\Enumerable::create($values)->average();

echo "Average: ${average}";