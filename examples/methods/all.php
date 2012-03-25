<?php

$values = array('a', 'b', 'c', 1, 3, 5, 'x', 'y', 'z');

$allString = \Flink\Enumerable::create($values)->all(function ($value) {
	return is_string($value);
});

echo "All string? ".($allString ? "Yes\n" : "No\n");

$allScalar = \Flink\Enumerable::create($values)->all(function ($value) {
	return is_scalar($value);
});

echo "All scalar? ".($allScalar ? "Yes\n" : "No\n");