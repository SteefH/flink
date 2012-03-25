<?php

namespace Flink\Iterator;

class Skip extends Base
{
	protected $_skip;
	protected $_currentlyLeft = 0;
	
	public function __construct($number, $iterable) {
		parent::__construct($iterable);
		$this->_skip = $number;
	}
	
	public function rewind() {
		parent::rewind();
		$skip = $this->_skip;
		for ($skip = $this->_skip; $skip > 0 ; $skip--) { 
			if (!parent::valid()) {
				return;
			}
			parent::next();
		}
	}
}
