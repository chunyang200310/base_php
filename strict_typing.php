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
