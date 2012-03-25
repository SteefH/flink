<?php

namespace Flink\Iterator;

class Zip extends Base
{
	protected $_second;
	protected $_func;
	
	public function __construct($first, $second, $func) {
		parent::__construct($first);
		$this->_second = new Base($second);
		$this->_func = $func;
	}
	
	public function rewind() {
		parent::rewind();
		$this->_second->rewind();
	}
	public function next() {
		parent::next();
		$this->_second->next();
	}
	public function valid() {
		return parent::valid() && $this->_second->valid();
	}
	public function current() {
		$firstVal = parent::current();
		$secondVal = $this->_second->current();
		if ($this->_func) {
			$func = $this->_func;
			return $func($firstVal, $secondVal);
		}
		$result = new \StdClass;
		$result->first	= $firstVal;
		$result->second	= $secondVal;
		return $result;
	}
}