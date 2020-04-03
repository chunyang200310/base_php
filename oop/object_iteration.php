<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Simple Object Iteration
class MyClass
{
	public $var1 = 'value 1';
	public $var2 = 'value 2';
	public $var3 = 'value 3';

	protected $protected = 'protected var';
	private $private = 'private var';

	public function iterateVisible()
	{
		echo "MyClass::iterateVisible: <br />";
		foreach ($this as $key => $value) {
			echo "$key => $value <br />";
		}
	}
}

$mc = new MyClass();

foreach ($mc as $key => $value) {
	echo "$key => $value <br />";
}

$mc->iterateVisible();

/***   Object Iteration implementing Iterator   ***/
class MyIterator implements Iterator
{
	private $var = [];

	public function __construct($array)
	{
		if (is_array($array)) {
			$this->var = $array;
		}
	}

	public function rewind()
	{
		echo "rewinding. <br />";
		reset($this->var);
	}

	public function current()
	{
		$var = current($this->var);
		echo "current: $var <br />";
		return $var;
	}

	public function key()
	{
		$var = key($this->var);
		echo "key: $var <br />";
		return $var;
	}

	public function next()
	{
		$var = next($this->var);
		echo "next: $var <br />";
		return $var;
	}

	public function valid()
	{
		$key = key($this->var);
		$var = ($key !== NULL && $key !== FALSE);
		echo "valid: $var <br />";
		return $var;
	}
}

$values = [1, 2, 3];
$it= new MyIterator($values);

foreach ($it as $a => $b) {
	echo "$a: $b <br />";
}

echo '<hr />';

/***  Object Iteration implementing IteratorAggregate  ***/
class MyCollection implements IteratorAggregate
{
	private $items = [];
	private $count = 0;

	// Required definition of interface IteratorAggregate
	public function getIterator()
	{
		return new MyIterator($this->items);
	}

	public function add($value)
	{
		$this->items[$this->count++] = $value;
	}
}

$coll = new MyCollection();
$coll->add('value 1');
$coll->add('value 2');
$coll->add('value 3');

foreach ($coll as $key => $val) {
	echo "key/value: [$key -> $val] <br />";
}
