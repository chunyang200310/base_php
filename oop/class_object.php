<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream"> <pre>';

// Simple Class definition
class SimpleClass
{
	// property declaration
	public $var = 'a default value';

	// method declaration
	public function displayVar()
	{
		echo $this->var . '<br />';
	}
}

// create an instance of a class
$sc = new SimpleClass();
echo 'Property: ' . $sc->var . '<br />';
$sc->displayVar();

// Some examples of the $this pseudo-variable
class A
{
	public function foo()
	{
		if (isset($this)) {
			echo '$this is defined (' . get_class($this) . ') <br />';
		} else {
			echo '$this is NOT defined. <br />';
		}
	}
}

class B
{
	public function bar()
	{
		A::foo();
	}
}

$a = new A();
$a->foo();
A::foo();

$b = new B();
$b->bar();
B::bar();

// creating an instance 
class CreateInstance
{
	public $instance = null;

	public function getInstance()
	{
		$this->instance = new self;
		return $this->instance;
		// return new self;
	}
}

$ci = new CreateInstance();
var_dump($ci);
var_dump($ci->instance);
var_dump($ci->getInstance());
var_dump($ci->instance);

$cls = 'createinstance';	// case insensitive
$ci1 = new $cls;
var_dump($ci1);

// Object Assignment
class ObjAssign
{
	public $var = 'a default value';

	public function displayVar()
	{
		echo $this->var;
	}
}

$instance = new ObjAssign();
$assigned = $instance;
$reference =& $instance;
$clone = clone $instance;
$instance->var = '$assigned will have this value';
$instance = null;

var_dump($instance, $reference, $clone, $assigned);

// PHP 5.3.0 introduced a couple of new ways to create instances of an object: 
// Creating new objects
class Test
{
	public static function getNew()
	{
		return new static;
	}
}

class Child extends Test {}

$obj1 = new Test();
$obj2 = new $obj1;
var_dump($obj1, $obj2);
var_dump($obj1 == $obj2);
var_dump($obj1 === $obj2);
$obj3 = Test::getNew();
var_dump($obj3);
$obj4 = Child::getNew();
var_dump($obj4);
var_dump($obj4 instanceof Child);
var_dump($obj4 instanceof Test);

// PHP 5.4.0 introduced the possibility to access a member of a newly created object in a single expression: 
echo (new DateTime())->format('Y') . '<br />';	// 2020

// Property access vs. method call
class PropertyMethod
{
	public $bar = 'property: bar';

	public function bar()
	{
		return 'method: bar()';
	}
}
// var_dump(PHP_EOL);
$pm = new PropertyMethod();
echo $pm->bar, PHP_EOL, $pm->bar(), PHP_EOL;

// Calling an anonymous function stored in a property
class FuncInProperty
{
	public $bar;

	public function __construct()
	{
		$this->bar = function() {
			return 42;
		};
	}
}

$fip = new FuncInProperty();
var_dump($fip);

// as of PHP 5.3.0
$func = $obj->bar;
// echo $func(), PHP_EOL;	// Fatal error: Uncaught Error: Function name must be a string

// alternatively, as of PHP 7.0.0
echo ($fip->bar)(), PHP_EOL;

// Class Inheritance
class ExtendClass extends SimpleClass
{
	// redefine the parent method
	public function displayVar()
	{
		echo 'Extending class. <br />';
		parent::displayVar();
	}
}

$ec = new ExtendClass();
$ec->displayVar();

// Class name resolution
echo ExtendClass::class . '<br />';
