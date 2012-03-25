<?php

namespace Flink\Iterator;

class SkipWhile extends Base
{
	protected $_conditionFunc;
	
	public function __construct($conditionFunc, $iterable) {
		parent::__construct($iterable);
		$this->_conditionFunc = $conditionFunc;
	}
	
	public function rewind() {
		parent::rewind();
		$func = $this->_conditionFunc;
		while(parent::valid()) {
			if (!$func(parent::current())) {
				return;
			}
			parent::next();
		}
	}
}
