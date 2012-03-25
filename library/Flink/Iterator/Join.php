<?php

namespace Flink\Iterator;

class Join extends Base
{
	private $_innerByKey			= null;
	private $_inner					= null;
	private $_outerKeySelector		= null;
	private $_innerKeySelector		= null;
	private $_resultSelector		= null;
	private $_currentInnerIterator	= null;
	
	public function __construct($outer, $inner, $outerKeySelector, $innerKeySelector, $resultSelector) {
		parent::__construct($outer);
		$this->_inner				= $inner;
		$this->_outerKeySelector	= $outerKeySelector;
		$this->_innerKeySelector	= $innerKeySelector;
		$this->_resultSelector		= $resultSelector;
	}
	
	public function rewind() {
		parent::rewind();
		$this->_innerByKey = array();
		$this->_currentInnerIterator = null;
		$innerKeySelector = $this->_innerKeySelector;
		foreach ($this->_inner as $value) {
			$key = $innerKeySelector($value);
			if (array_key_exists($key, $this->_innerByKey)) {
				$this->_innerByKey[$key][] = $value;
			} else {
				$this->_innerByKey[$key] = array($value);
			}
		}
	}
	
	public function valid() {
		if ($this->_currentInnerIterator !== null) {
			if ($this->_currentInnerIterator->valid()) {
				return true;
			}
			parent::next();
		}
		$outerKeySelector = $this->_outerKeySelector;
		while(1) {
			if (!parent::valid()) {
				return false;
			}
			$key = $outerKeySelector(parent::current());
			
			if (array_key_exists($key, $this->_innerByKey)) {
				$this->_currentInnerIterator = new Base($this->_innerByKey[$key]);
				$this->_currentInnerIterator->rewind();
				if ($this->_currentInnerIterator->valid()) {
					return true;
				}
			}
			parent::next();
		}
	}
	
	public function next() {
		$this->_currentInnerIterator->next();
	}
	
	public function current() {
		$resultSelector = $this->_resultSelector;
		return $resultSelector(parent::current(), $this->_currentInnerIterator->current());
	}
	
}