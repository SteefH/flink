<?php

$values = array('a', 'b', 'c', 1, 3, 5, 'x', 'y', 'z');

$anyString = \Flink\Enumerable::create($values)->any(function ($value) {
	return is_string($value);
});

echo "Any string? ".($anyString ? "Yes\n" : "No\n");

$anyObject = \Flink\Enumerable::create($values)->any(function ($value) {
	return is_object($value);
});

echo "Any object? ".($anyObject ? "Yes\n" : "No\n");