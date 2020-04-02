<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

class Logger
{
	public function log($msg)
	{
		echo $msg;
	}
}

//$util->setLogger(new Logger());

// PHP 7+ code
/*
$util->setLogger(new class {
	public function log($msg)
	{
		echo $msg;
	}
});
 */

// They can pass arguments through to their constructors, extend other classes, implement interfaces, and use traits just like a normal class can: 
class SomeClass {}
interface SomeInterface {}
trait SomeTrait {}

var_dump(new class(10) extends SomeClass implements SomeInterface {
	private $num;

	public function __construct($num)
	{
		$this->num = $num;
	}

	use SomeTrait;
});

// use the private properties of the outer class in the anonymous class
class Outer
{
	private $prop = 1;
	protected $prop2 = 2;

	protected function func1()
	{
		return 3;
	}

	public function func2()
	{
		return new class($this->prop) extends Outer {
			private $prop3;

			public function __construct($prop)
			{
				$this->prop3 = $prop;
			}

			public function func3()
			{
				return $this->prop2 + $this->prop3 + $this->func1();
			}
		};
	}
}

echo (new Outer)->func2()->func3();

// All objects created by the same anonymous class declaration are instances of that very class. 
function anonymous_class()
{
	return new class {};
}

if (get_class(anonymous_class()) === get_class(anonymous_class())) {
	echo 'Same class. <br />';
} else {
	echo 'Different class. <br />';
}

echo get_class(new class {});
