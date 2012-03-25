<?php

namespace Flink\Iterator;

class FlattenSelect extends Flatten
{
	private $_select = null;
	
	public function __construct($select, $iterable) {
		parent::__construct($iterable);
		$this->_select = $select;
	}

	protected function _createEnumerable($iterable) {
		$select = $this->_select;
		return new Base($select($iterable));
	}
}
