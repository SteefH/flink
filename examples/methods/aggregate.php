<?php

$distances = array(
	array('amount'=>12, 'unit'=>'mm'),
	array('amount'=>2,  'unit'=>'cm'),
	array('amount'=>32, 'unit'=>'mm'),
	array('amount'=>50, 'unit'=>'m'),
);

$multipliers = array(
	'mm' => 0.001,
	'cm' => 0.01,
	'dm' => 0.1,
	'm'  => 1.0
);

$totalDistance = \Flink\Enumerable::create($distances)
	->aggregate(function($total, $distance) use ($multipliers) {
		if ($total === null) {
			$total = 0;
		}
		$amount = $distance['amount'];
		$unit = $distance['unit'];
		return $total + $amount * $multipliers[$unit];
	});

echo "Total distance: ${totalDistance} m";