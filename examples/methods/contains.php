<?php

$values = array(23, 352, 21, 435, 49);

$enum = \Flink\Enumerable::create($values);

echo "Contains 50? ".($enum->contains(50) ? "Yes\n" : "No\n");
echo "Contains 21? ".($enum->contains(21) ? "Yes\n" : "No\n");