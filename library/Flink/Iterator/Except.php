<?php

namespace Flink\Iterator;


class Except extends Base
{
	
	private $_keys = null;
	private $_other = null;
	
	public function __construct($iterable, $other) {
		parent::__construct($iterable);
		$this->_other = new Base($other);
	}
	
	public function rewind() {
		parent::rewind();
		$this->_keys = array();
		foreach ($this->_other as $value) {
			$this->_keys[$this->_getValueHashKey($value)] = 1;
		}
	}
	
	public function valid() {
		while(1) {
			if (!parent::valid()) {
				return false;
			}
			$key =  $this->_getValueHashKey(parent::current());
			if (!array_key_exists($key, $this->_keys)) {
				return true;
			}
			parent::next();
		}
	}

	public function current() {
		$current = parent::current();
		$this->_keys[$this->_getValueHashKey($current)] = 1;
		return $current;
	}
}