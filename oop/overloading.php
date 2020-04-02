<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// overloading properties via the __get/set/isset/unset methods
class PropertyTest
{
	// Location for overloaded data
	private $data = [];

	// Overloading not used on declared properties
	public $declared = 1;

	// Overloading only used on this when accessed outside the class
	private $hidden = 2;

	public function __set($name, $value)
	{
		echo 'Setting $name to $value. <br />';
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		echo 'Getting the value of $name. <br />';
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}

		$trace = debug_backtrace();
		trigger_error(
			'Undefined property via __get(): ' . $name . 
			' in ' . $trace[0]['file'] . 
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
		return null;
	}

	public function __isset($name)
	{
		echo 'Is $name set? <br />';
		return isset($this->data[$name]);
	}

	public function __unset($name)
	{
		echo 'Unsetting $name. <br />';
		unset($this->data[$name]);
	}

	// not a magic method
	public function getHidden()
	{
		return $this->hidden;
	}
}

$pt = new PropertyTest();

$pt->a = 1;
echo $pt->a . '<br />';

var_dump(isset($pt->a));
unset($pt->a);
var_dump(isset($pt->a));
echo '<br />';

echo $pt->declared . '<br />';

// Privates are visible inside the class, so __get() not used
echo 'getHidden(): ' . $pt->getHidden() . '<br />';

// Privates not visible outside of class, so __get() is used
echo $pt->hidden . '<br />';

/****** Overloading methods via the __call() and __callStatic() methods ******/
class MethodTest
{
	public function __call($name, $args)
	{
		// value of $name is case sensitive
		echo '__call is calling... <br />';
		echo "Calling object method '$name' " . implode(', ', $args) . '<br />';
	}

	public static function __callStatic($name, $args)
	{
		echo '__callStatic is calling... <br />';
		echo "Calling static method '$name' " . implode(', ', $args) . '<br />';
	}
}

$mt = new MethodTest();
$mt->runTest('in object context');

MethodTest::runTest('in static context');
