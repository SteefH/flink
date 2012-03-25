<?php

namespace Flink\Iterator;

class Flatten extends Base
{
	private $_currentIterable = null;

	protected function _createEnumerable($iterable) {
		return new Base($iterable);
	}
	
	public function rewind() {
		parent::rewind();
		$this->_currentIterable = null;
	}
	
	public function valid() {
		if ($this->_currentIterable !== null) {
			if ($this->_currentIterable->valid()) {
				return true;
			}
			parent::next();
		}
		while (true) {
			if (!parent::valid()) {
				return false;
			}
			$this->_currentIterable = $this->_createEnumerable(parent::current());
			$this->_currentIterable->rewind();
			if ($this->_currentIterable->valid()) {
				return true;
			}
			parent::next();
		}
	}
	
	function current() {
		return $this->_currentIterable->current();
	}

	function key() {
		return $this->_currentIterable->key();
	}

	function next() {
		$this->_currentIterable->next();
	}
	
}