<?php

namespace Flink\Iterator;


class Distinct extends Base
{
	private $_keys = null;
	
	public function rewind() {
		parent::rewind();
		$this->_keys = array();
	}
	
	public function valid() {
		while(1) {
			if (!parent::valid()) {
				return false;
			}
			$key =  $this->_getValueHashKey(parent::current());
			if (!array_key_exists($key, $this->_keys)) {
				$this->_keys[$key] = 1;
				return true;
			}
			parent::next();
		}
	}
}