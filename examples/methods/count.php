<?php

$values = array(23, 352, 21, 435, 49);

$numberOfElements = \Flink\Enumerable::create($values)->count();
echo "Contains ${numberOfElements} elements";
