<?php

$singleValue = array(32);

$enum = \Flink\Enumerable::create($singleValue);

echo "Single value: ".$enum->single();
echo "\n";

$multipleValues = array(32, 3497);

$enum = \Flink\Enumerable::create($multipleValues);

// This will throw an exception
echo "Single value: ".$enum->single();