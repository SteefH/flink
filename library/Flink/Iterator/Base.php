<?php

namespace Flink\Iterator;

class Base implements \Iterator
{
	
	
	private static $_valueKeyFuncs = null;
	protected function _getValueHashKey($value) {
		$funcs = self::$_valueKeyFuncs;
		if ($funcs === null) {
			$funcs = self::$_valueKeyFuncs = array(
				'is_array'=> function ($v) {
					return 'a:'.serialize($v);
				},
				'is_bool'=> function ($v) {
					return 'b:'.serialize($v);
				},
				'is_float'=> function ($v) {
					return 'f:'.serialize($v);
				},
				'is_int'=> function ($v) {
					return 'i:'.serialize($v);
				},
				'is_null'=> function ($v) {
					return 'n';
				},
				'is_object'=> function ($v) {
					return 'o:'.spl_object_hash($v);
				},
				'is_resource'=> function ($v) {
					return 'r:'.((int)$v);
				},
				'is_string'=> function ($v) {
					return 'v:'.$v;
				}
			);
		}
		foreach ($funcs as $test => $func) {
			if ($test($value)) {
				return $func($value);
			}
		}
	}
	
	protected $_iterable;
	
	public function __construct($iterable) {
		if ($iterable instanceof \Iterator) {
			$this->_iterable = $iterable;
		} elseif ($iterable instanceof \Traversable) {
			$this->_iterable = new \IteratorIterator($iterable);
		} elseif ($iterable instanceof \IteratorAggregate) {
			$this->_iterable = $iterable->getIterator();
		} elseif (is_array($iterable)) {
			$this->_iterable = new \ArrayIterator($iterable);
		} else {
			$this->_iterable = new \ArrayIterator(array($iterable));
		}
	}
	
	function rewind() {
		$this->_iterable->rewind();
	}

	function current() {
		return $this->_iterable->current();
	}

	function key() {
		return $this->_iterable->key();
	}

	function next() {
		$this->_iterable->next();
	}

	function valid() {
		return $this->_iterable->valid();
	}
}