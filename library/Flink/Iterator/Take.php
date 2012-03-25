<?php

namespace Flink\Iterator;

class Take extends Base
{
	protected $_count;
	protected $_currentCount;
	
	public function __construct($number, $iterable) {
		parent::__construct($iterable);
		$this->_count = $number;
	}
	
	public function rewind() {
		parent::rewind();
		$this->_currentCount = $this->_count;
	}
	public function next() {
		parent::next();
		$this->_currentCount--;
	}
	
	public function valid() {
		if ($this->_currentCount <= 0) {
			return false;
		}
		return parent::valid();
	}
}
