<?php

$nonEmpty = array(1, 2, 3);

$nonEmptyEnum = \Flink\Enumerable::create($nonEmpty)->defaultIfEmpty('EMPTY!');

echo "Enumerating...\n";
foreach ($nonEmptyEnum as $value) {
	echo "\t${value}\n";
}

echo "\n".str_repeat('=', 30)."\n\n";

$empty = array();
$emptyEnum = \Flink\Enumerable::create($empty)->defaultIfEmpty('EMPTY!');

echo "Enumerating...\n";
foreach ($emptyEnum as $value) {
	echo "\t${value}\n";
}
