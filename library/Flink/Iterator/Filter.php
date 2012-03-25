<?php

namespace Flink\Iterator;

class Filter extends Base
{
	
	private $_predicate;
	
 	public function __construct($predicate, $iterable) {
		parent::__construct($iterable);
		$this->_predicate = $predicate;
	}
	
	public function valid() {
		$predicate = $this->_predicate;
		while (true) {
			if (!parent::valid()) {
				return false;
			}
			$current = parent::current();
			if ($predicate($current)) {
				return true;
			}
			parent::next();
		}
	}
}