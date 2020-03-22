<?php
declare(strict_types = 1);

error_reporting(7);

function sum(int $a, int $b)
{
	return $a + $b;
}

var_dump(sum(1, 2));
// var_dump(sum(1.5, 2.5));
/* Fatal error: Uncaught TypeError: Argument 1 passed to sum() 
 * must be of the type int, float given 
 */

// catching typeError
try {
	var_dump(sum(1.5, 2.5));
} catch (TypeError $e) {
	// var_dump($e);
	echo 'Error: ' . $e->getMessage();
}

echo '<br /> Hello <br />';

// variable-length argument lists
function get_sum(...$numbers)
{
	$acc = 0;
	foreach ($numbers as $n) {
		$acc += $n;
	}
	return $acc;
}

echo 'The sum = ' . get_sum(1, 2, 3, 4) . '<br />';

// use ... to provide arguments
function add($a, $b)
{
	return $a + $b;
}
echo add(...[1, 2]) . '<br />';
$a = [1, 2];
echo add(...$a) . '<br />';

// Type hinted variable arguments
function total_intervals($unit, DateInterval ...$intervals) {
    $time = 0;
    foreach ($intervals as $interval) {
        $time += $interval->$unit;
    }
    return $time;
}
$a = new DateInterval('P1D');
$b = new DateInterval('P2D');
echo total_intervals('d', $a, $b).' days <br />';
// This will fail, since null isn't a DateInterval object.
// Fatal error: Uncaught TypeError: Argument 2 passed to total_intervals() must be an instance of DateInterval, null given
// echo total_intervals('d', null);

// Accessing variable arguments in PHP 5.5 and earlier 
function sum_early() {
	$acc = 0;
	foreach (func_get_args() as $n) {
		$acc += $n;
	}
	return $acc;
}
echo sum_early(1, 2, 3, 4) . '<br />';

// Functions as argument
function func_as_arg($a, $b, $c)
{
	return $c($a, $b);
}

$sum = func_as_arg(1, 2, function ($a, $b) {
	return $a + $b;
});
echo 'Sum is: ' . $sum . '<br />';

/******	Returning values	******/
// use of return
function square($num)
{
	return $num * $num;
}

echo '4 x 4 = ' . square(4) . '<br />';

// returning an array to get multiple values
function small_numbers()
{
	return [0, 1, 2];
}
list ($zero, $one, $two) = small_numbers();
echo $zero, $one, $two . '<br />';

// Returning a reference from a function
function &returns_reference()
{
	return $someref;
}
$newref =& returns_reference();

/****** Return tyoe declarations  ******/
// Basic reurn type declaration
function sum_type($a, $b): float
{
	return $a + $b;
}
var_dump(sum_type(1, 2));	// float 3

// strict mode in action
function sum_strict($a, $b): int
{
	return $a + $b;
}
var_dump(sum_strict(1, 2));
try {
	var_dump(sum_strict(1, 2.5));
} catch (TypeError $e) {
	echo $e->getMessage();
}

// Returning an object
class C {}
function getC(): C
{
	return new C;
}
var_dump(getC());

/******  Variable functions  ******/
// variable function example
function var_func()
{
	echo 'call function: var_func <br />';
}

$str = 'var_func';
$str();

// call Object method with the variable functions
class CallVar
{
	public function variable()
	{
		$name = 'bar';
		//$name = 'Bar';	// method name case insensitive
		$this->$name();	// call the bar() method
	}

	public function bar()
	{
		echo 'This is bar <br />';
	}
}

$cv = new CallVar();
$funcName = 'variable';
$cv->$funcName();

// When calling static methods, the function call is stronger 
// than the static property operator
class FooStatic
{
	public static $variable = 'static property';

	public static function variable()
	{
		echo 'Method variable called. <br />';
	}
}

echo FooStatic::$variable . '<br />';
FooStatic::variable() . '<br />';
$variable = 'variable';
FooStatic::$variable();

// Complex callables
class ComplexCall
{
	public static function bar()
	{
		echo 'bar <br />';
	}

	public function baz()
	{
		echo 'baz <br />';
	}
}

$func = ['ComplexCall', 'bar'];
$func();
$func = [new ComplexCall, 'baz'];
$func();
$func = 'ComplexCall::bar';
$func();

/******  Internal (built-in) functions  ******/
// example 1
echo preg_replace_callback('~-([a-z])~', function ($match) {
	// var_dump($match);
	return strtoupper($match[1]);
}, 'hello-world');

// Anonymous function variable assignment example
$greet = function ($name)
{
	echo '<br /> Hello ' . $name . '<br />';
};	// semicolon cannot be omited!
$greet('World');
$greet('PHP');

// Inheriting variables from the parent scope 
$message = 'hello';

$example = function ()
{
	var_dump($message);
};
$example();		// null

$example = function () use ($message)
{
	var_dump($message);
};
$example();

$message = 'world';
var_dump($message);
$example();

// reset message
$message = 'hello';

$example = function () use (&$message)
{
	var_dump($message);
};
$example();

$message = 'world';
$example();

// Closures can also accept regular arguments
$example = function ($arg) use ($message) {
	var_dump($arg . ' ' . $message);
};
$example('hello');

// Automatic binding of $this 
class Test
{
	public function testing()
	{
		return function() {
			var_dump($this);
		};
	}
}

$obj = new Test;
$function = $obj->testing();
$function();

// Attempting to use $this inside a Static anonymous functions
class UseThis
{
	function __construct()
	{
		$func = static function() {
			// var_dump($this);
			// Fatal error: Uncaught Error: Using $this when not in object context
		};
		$func();
	}
}
new UseThis();

// Attempting to bind an object to a static anonymous function
$func = static function() {
	// function body
};
$func = $func->bindTo(new StdClass); // Warning: Cannot bind an instance to a static closure
$func();	// Fatal error: Uncaught Error: Function name must be a string
