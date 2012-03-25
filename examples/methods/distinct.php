<?php

$values = array(23, 352, 21, 435, 100, 1, 23, 49, 1);

$enum = \Flink\Enumerable::create($values)->distinct();
foreach ($enum as $value) {
	echo "${value}\n";
}
