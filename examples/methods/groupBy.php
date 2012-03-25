<?php

$people = array(
	array('id' => 1, 'name'=> 'harry',  'group'=>'losers'),
	array('id' => 2, 'name'=> 'hank',   'group'=>'winners'),
	array('id' => 3, 'name'=> 'charly', 'group'=>'losers')
);

$enum = \Flink\Enumerable::create($people)
	->groupBy(
		function ($person) {
			return $person['group'];
		}
	);
foreach ($enum as $group) {
	$groupKey = $group->key;
	echo "${groupKey}\n";
	foreach ($group as $person) {
		$person = $person['id'].': '.$person['name'];
		echo "\t${person}\n";
	}
}
echo "\n";
echo "\n";
echo 'With elementSelect closure';
echo "\n";
echo "\n";
$enum = \Flink\Enumerable::create($people)
	->groupBy(
		function ($person) {
			return $person['group'];
		},
		function ($person) {
			return strtoupper($person['name']);
		}
	);

foreach ($enum as $group) {
	$groupKey = $group->key;
	echo "${groupKey}\n";
	foreach ($group as $person) {
		echo "\t${person}\n";
	}
}
