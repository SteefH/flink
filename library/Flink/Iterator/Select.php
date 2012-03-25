<?php

namespace Flink\Iterator;

class Select extends Base
{
	public function __construct($select, $iterable) {
		parent::__construct($iterable);
		$this->_select = $select;
	}
	
	public function current() {
		$value = parent::current();
		$select = $this->_select;
		return $select($value);
	}
}