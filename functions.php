<?php
error_reporting(E_ALL);

echo '<body bgcolor="mintcream"><pre>';

// a simplest function
function example_func()
{
    echo 'Hello<br />';
    return 0;
}

example_func();

// Conditional functions
$makefoo = true;

/* We can't call foo() from here 
   since it doesn't exist yet,
   but we can call bar() */

bar();

if ($makefoo) {
    function foo()
    {
        echo "I don't exist until program execution reaches me.\n";
    }
}

/* Now we can safely call foo()
   since $makefoo evaluated to true */

if ($makefoo) foo();

function bar()
{
    echo "I exist immediately upon program start.\n";
}

// functions within functions
function outer()
{
    function inner()
    {
        echo "I don't exist until outer() is called.<br />";
    }
}

/* we can't call inner() yet, for it doesn' exist */

outer();

/* Now we can call inner() */

inner();

// recursive functions
function recursion($a)
{
    if ($a < 20) {
        echo $a . '<br />';
        recursion($a + 1);
    }
}

recursion(18);

/****** Function arguments ******/
// Passing arguments by value (the default)
$input = [1, 2];

function takesArray($input)
{
	echo "$input[0] + $input[1] = " . $input[0] + $input[1] . '<br />';
}

takesArray($input);

// Passing arguments by reference
function add_some_extra(&$string)
{
	$string .= 'and something extra.';
}
$str = 'This is the contens, ';
add_some_extra($str);
echo $str . '<br />';

// Default arguments values
function get_age($name = 'Tom', $age = 16)
{
	return $name . ' is ' . ($age + 2) . ' years old. <br />';
}

echo get_age();
echo get_age(null);
echo get_age(null, null);
echo get_age(null, 13);
echo get_age('Bill');
echo get_age('Lucy', 14);

// non-scalar types as default values
function make_coffee($type = ['cappuccino'], $maker = null)
{
	$device = $maker ?? 'hands';
	return 'Making a cup of ' . join(',', $type) . ' with ' . $device . '. <br />';
}
echo make_coffee();
echo make_coffee(['cappuccino', 'lavazza'], 'teapot');

// Arguments Type declarations
function test_alias(boolean $param) { }
//test_alias(true);	// Fatal error: Uncaught TypeError: Argument 1 passed to test_alias() must be an instance of boolean, bool given

function test_type(bool $param) {
	return $param;
}
echo test_type(true) . '<br />';

// Basic class type declaration
class C {}
class D extends C {}
class E {}

function f(C $c)
{
	echo 'Class name: ' . get_class($c) . '<br />';
}
f(new C);
f(new D);
// f(new E);	// Fatal error: Uncaught TypeError: Argument 1 passed to f() must be an instance of C, instance of E given

// Basic interface type declaration
interface I { public function f(); }
class Ii implements I {public function f() {} }
class J {}
function test_interface(I $i)
{
	echo 'Class name: ' . get_class($i) . '<br />';
}
test_interface(new Ii);
// test_interface(new J);	// Argument 1 passed to test_interface() must implement interface I, instance of J given

// Typed pass-by-reference Parameters
function array_baz(array &$param)
{
	$param = 1;
}
$arr = [];
array_baz($arr);
var_dump($arr);
// array_baz($arr);	// Argument 1 passed to array_baz() must be of the type array, int given

// Nullable type declaration
class Foo {}
function test_null(Foo $foo = null)
{
	var_dump($foo);
}
test_null(new Foo);
test_null(null);

/******	Strict typing	******/
// Weak typing
function sum(int $a, int $b) {
	return $a + $b;
}
var_dump(sum(1, 2));
var_dump(sum(1.5, 2.5));

// strict typing
// declare(strict_types=1);	// Fatal error: strict_types declaration must be the very first statement in the script
/******	strict typing look: strict_typeing.php	******/

// Return type declarations in weak mode
function weak_sum($a, $b): int
{
	return $a + $b;
}

var_dump(weak_sum(1, 2));	// int 3
var_dump(weak_sum(1, 2.5));	// int 3
