<?php

namespace Flink\Iterator;

class TakeWhile extends Base
{
	protected $_conditionFunc;
	
	public function __construct($conditionFunc, $iterable) {
		parent::__construct($iterable);
		$this->_conditionFunc = $conditionFunc;
	}
	
	public function valid() {
		if (!parent::valid()) {
			return false;
		}
		$func = $this->_conditionFunc;
		return $func(parent::current());
	}
}