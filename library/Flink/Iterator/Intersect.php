<?php

namespace Flink\Iterator;

class Intersect extends Base
{
	private $_keys = null;
	private $_other = null;
	
	public function __construct($iterable, $other) {
		parent::__construct($iterable);
		$this->_other = $other;
	}
	
	public function rewind() {
		parent::rewind();
		$this->_keys = array();
		foreach ($this->_other as $value) {
			$this->_keys[$this->_getValueHashKey($value)] = 0;
		}
	}
	
	public function valid() {
		while(1) {
			if (!parent::valid()) {
				return false;
			}
			$key = $this->_getValueHashKey(parent::current());
			if (array_key_exists($key, $this->_keys) && $this->_keys[$key] === 0) {
				$this->_keys[$key] = 1;
				return true;
			}
			parent::next();
		}
	}
}