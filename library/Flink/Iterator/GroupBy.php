<?php

namespace Flink\Iterator;

use \Flink\Enumerable;

class GroupBy extends Base
{
	private $_keySelector		= null;
	private $_elementSelector	= null;
	private $_resultSelector	= null;
	private $_groups			= null;
	private $_groupIterator		= null;
	
	public function __construct($iterable, $keySelector, $elementSelector, $resultSelector) {
		parent::__construct($iterable);
		$this->_keySelector		= $keySelector;

		$this->_elementSelector	= $elementSelector;

		if ($resultSelector === null) {
			$this->_resultSelector	= function ($e) { return $e; };
		} else {
			$this->_resultSelector	= $resultSelector;
		}
	}
	
	public function rewind() {
		parent::rewind();
		$this->_groups = array();
		$keySelector = $this->_keySelector;
		$elementSelector = $this->_elementSelector;

		foreach ($this->_iterable as $value) {
			$key = $keySelector($value);
			$hashedKey = $this->_getValueHashKey($key);
			
			if (array_key_exists($hashedKey, $this->_groups)) {
				$this->_groups[$hashedKey][1][] = $value;
			} else {
				$this->_groups[$hashedKey] = array($key, array($value)); 
			}
		}
		$this->_groupIterator = new \ArrayIterator($this->_groups);
	}
	
	public function valid() {
		return $this->_groupIterator->valid();
	}
	
	public function next() {
		$this->_groupIterator->next();
	}
	
	public function current() {
		$resultSelector = $this->_resultSelector;
		list($key, $elements) = $this->_groupIterator->current();
		$elements = new Enumerable($elements);
		if ($this->_elementSelector !== null) {
			$elements = $elements->select($this->_elementSelector);
		}
		$elements->key = $key;
		return $resultSelector($elements);
	}
	
} 