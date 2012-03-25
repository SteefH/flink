<?php

namespace Flink;

class Enumerable extends Iterator\Base
{
	
	public static function create($iterable) {
		return new Enumerable($iterable);
	}
	
	public function where($predicate) {
		return new Enumerable(new Iterator\Filter($predicate, $this));
	}
	
	public function select($function) {
		return new Enumerable(new Iterator\Select($function, $this));
	}
	public function selectMany($function=null) {
		if ($function !== null) {
			$iterable = new Iterator\FlattenSelect($function, $this);
		} else {
			$iterable = new Iterator\Flatten($this);
		}
		return new Enumerable($iterable);
	}
	
	public function concat($next) {
		return new Enumerable(new Iterator\Flatten(array($this, $next)));
	}
	
	public function zip($other, $zipFunction=null) {
		return new Enumerable(new Iterator\Zip($this, $other, $zipFunction));
	}
	
	public function takeWhile($condition) {
		return new Enumerable(new Iterator\TakeWhile($condition, $this));
	}
	
	public function skipWhile($condition) {
		return new Enumerable(new Iterator\SkipWhile($condition, $this));
	}
	
	public function skip($number) {
		return new Enumerable(new Iterator\Skip($number, $this));
	}
	
	public function take($number) {
		return new Enumerable(new Iterator\Take($number, $this));
	}
	
	public function all($function=null) {
		if ($function) {
			foreach ($this as $value) {
				if (!$function($value)) {
					return false;
				}
			}
			return true;
		}
		foreach ($this as $value) {
			if (!$value) {
				return false;
			}
		}
		return true;
	}
	
	public function any($function=null) {
		if ($function) {
			foreach ($this as $value) {
				if ($function($value)) {
					return true;
				}
				return false;
			}
		}
		foreach ($this as $value) {
			if ($value) {
				return true;
			}
		}
		return false;
	}
	
	public function aggregate($function, $seed=null, $resultFunc=null) {
		$result = $seed;
		foreach ($this as $value) {
			$result = $function($result, $value);
		}
		if ($resultFunc !== null) {
			return $resultFunc($result);
		}
		return $result;
	}
	
	public function average($function=null) {
		$total = 0;
		$count = 0;
		if ($function === null) {
			foreach ($this as $value) {
				$total += $value;
				$count++;
			}
		} else {
			foreach ($this as $value) {
				$total += $function($value);
				$count++;
			}
		}
		if ($count === 0) {
			return 0;
		}
		return $total / $count;
	}
	
	public function contains($value, $comparer=null) {
		if ($comparer !== null) {
			foreach ($this as $myValue) {
				if ($comparer($value, $myValue)) {
					return true;
				}
			}
			return false;
		}
		foreach ($this as $myValue) {
			if ($value === $myValue) {
				return true;
			}
		}
		return false;
	}
	
	public function count($predicate = null) {
		if ($this->_iterable instanceof \Countable) {
			return count($this->_iterable);
		}
		$count = 0;
		foreach ($this as $value) {
			$count++;
		}
		return $count;
	}

	public function defaultIfEmpty($default) {
		$this->rewind();
		if ($this->valid()) {
			return $this;
		}
		return new Enumerable(array($default));
	}
	

	public function distinct($comparer=null) {
		return new Enumerable(new Iterator\Distinct($this));
	}

	public function elementAt($index) {
		if ($this->_iterable instanceof \SeekableIterator) {
			$this->_iterable->seek($index);
			if (!parent::valid()) {
				throw new \OutOfBoundsException('Index out of bounds');
			}
			return $this->_iterable->current();
		}
		return $this->skip($index)->first();
	}
	
	public function except($other, $comparer=null) {
		return new Enumerable(new Iterator\Except($this, $other));
	}
	
	public function first($condition=null) {
		parent::rewind();
		while (1) {
			if (!parent::valid()) {
				throw new \OutOfBoundsException('Empty Enumerable');
			}
			$current = parent::current();
			if ($condition === null || condition($current)) {
				return $current;
			}
			parent::next();
		}
	}
	
	public function firstOrDefault($default, $condition=null) {
		parent::rewind();
		while (1) {
			if (!parent::valid()) {
				return $default;
			}
			$current = parent::current();
			if ($condition === null || $condition($current)) {
				return $current;
			}
			parent::next();
		}
	}
	
	public function groupBy(
		$keySelector, $elementSelector=null, $resultSelector=null
	) {
		return new Enumerable(
			new Iterator\GroupBy(
				$this, $keySelector, $elementSelector, $resultSelector
			)
		);
	}
	
	public function groupJoin(
		$inner, $outerKeySelector, $innerKeySelector, $resultSelector,
		$compare=null
	) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function intersect($other, $comparer=null) {
		return new Enumerable(new Iterator\Intersect($this, $other));
	}
	
	public function join(
		$inner, $outerKeySelector, $innerKeySelector, $resultSelector,
		$compare=null
	) {
		return new Enumerable(
			new Iterator\Join(
				$this, $inner, $outerKeySelector, $innerKeySelector,
				$resultSelector
			)
		);
	}
	
	public function last($predicate=null) {
		if (
			$this->_iterable instanceof \Countable
			&& $this->_iterable instanceof \SeekableIterator
		) {
			$this->_iterable->seek(count($this->_iterable) - 1);
			return $this->_iterable->current();
		}
		$empty = true;
		$lastValue = null;
		foreach ($this as $value) {
			$lastValue = $value;
			$empty = false;
		}
		if (!$empty) {
			return $lastValue;
		}
		throw new \OutOfBoundsException('Empty Enumerable');
	}
	
	public function lastOrDefault($default, $predicate=null) {
		if ($this->_iterable instanceof \Countable) {
			if (count($this->_iterable) === 0) {
				return $default;
			}
			return $this->last();
		}
		$empty = true;
		$lastValue = null;
		foreach ($this as $value) {
			$lastValue = $value;
			$empty = false;
		}
		if (!$empty) {
			return $lastValue;
		}
		return $default;
	}
	
	public function max($function=null) {
		$result = 0;
		$first = true;
		if ($function === null) {
			foreach ($this as $value) {
				if ($first) {
					$first = false;
					$result = $value;
				} else {
					if ($value > $result) {
						$result = $value;
					}
				}
			}
		} else {
			foreach ($this as $value) {
				$value = $function($value);
				if ($first) {
					$first = false;
					$result = $value;
				} else {
					if ($value > $result) {
						$result = $value;
					}
				}
			}
		}
		return $result;
	}
	
	public function min($function=null) {
		$result = 0;
		$first = true;
		if ($function === null) {
			foreach ($this as $value) {
				if ($first) {
					$first = false;
					$result = $value;
				} else {
					if ($value < $result) {
						$result = $value;
					}
				}
			}
		} else {
			foreach ($this as $value) {
				$value = $function($value);
				if ($first) {
					$first = false;
					$result = $value;
				} else {
					if ($value < $result) {
						$result = $value;
					}
				}
			}
		}
		return $result;
	}
	
	public function orderBy($keySelector, $comparer=null) {
		throw new \Exception("Not implemented"); // TODO
	}

	public function orderByDescending($keySelector, $comparer=null) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public static function range($start, $count) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public static function repeat($value, $count) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function reverse() {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function sequenceEqual($comparer=null) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function single($function=null) {
		$found = false;
		$first = null;
		
		if ($function === null) {
			foreach ($this as $value) {
				if ($found) {
					throw new \OutOfBoundsException(
						'Enumerable contains more than one element'
					);
				}
				$found = true;
				$first = $value;
			}
			if (!$found) {
				throw new \OutOfBoundsException('Enumerable is empty');
			}
			return $first;
		}
		foreach ($this as $value) {
			if (!$function($value)) {
				continue;
			}
			if ($found) {
				throw new \OutOfBoundsException(
					'Enumerable contains more than one matching element'
				);
			}
			$found = true;
			$first = $value;
		}
		if (!$found) {
			throw new \OutOfBoundsException(
				'Enumerable contains no matching element'
			);
		}
		return $first;
	}
	
	public function singleOrDefault($default, $function=null) {
		$found = false;
		$first = null;
		
		if ($function === null) {
			foreach ($this as $value) {
				if ($found) {
					throw new \OutOfBoundsException(
						'Enumerable contains more than one element'
					);
				}
				$found = true;
				$first = $value;
			}
			if (!$found) {
				return $default;
			}
			return $first;
		}
		foreach ($this as $value) {
			if (!$function($value)) {
				continue;
			}
			if ($found) {
				throw new \OutOfBoundsException(
					'Enumerable contains more than one matching element'
				);
			}
			$found = true;
			$first = $value;
		}
		if (!$found) {
			return $default;
		}
		return $first;
	}
	
	public function sum($function=null) {
		$total = 0;
		if ($function === null) {
			foreach ($this as $value) {
				$total += $value;
			}
		} else {
			foreach ($this as $value) {
				$total += $function($value);
			}
		}
		return $total;
	}
	
	public function thenBy($keySelector) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function thenByDescending($keySelector) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function toArray() {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function toAssociativeArray($keySelector) {
		throw new \Exception("Not implemented"); // TODO
	}
	
	public function union($other) {
		throw new \Exception("Not implemented"); // TODO
	}
}
