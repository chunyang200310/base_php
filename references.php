<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Assign by Reference
$a =& $b;
var_dump($a, $b);	// null, null

// Using references with undefined variable
function foo(&$var) {}

foo($c);
var_dump($c);		// null

$d = [];
foo($d['b']);
var_dump(array_key_exists('b', $d));	// boolean true

$e = new stdClass();
foo($e->d);
var_dump(property_exists($e, 'd'));		// boolean true

// Referencing global variables inside functions
$var1 = 'Example variable';
$var2 = '';

function global_references($use_globals)
{
	global $var1, $var2;

	if (!$use_globals) {
		$var2 =& $var1;		// visible only inside the function
	} else {
		$GLOBALS['var2'] =& $var1;	// visible also in global context
	}
}

global_references(false);
echo 'Var2 is set to ' . $var2 . '<br />';
global_references(true);
echo 'Var2 is set to ' . $var2 . '<br />';

// References and foreach statement
$ref = 0;
$row =& $ref;

foreach ([1, 2, 3] as $row) {
	// do something
}

echo '$ref = ' . $ref . '<br />';


// While not being strictly an assignment by reference, expressions created with the language construct array() can also behave as such by prefixing & to the array element to add.
$a1 = 1;
var_dump($a1);
$b1 = [2, 3];
var_dump($a1, $b1);
$arr = [&$a1, &$b1[0], &$b1[1]];
var_dump($a1, $b1, $arr);

$arr[0]++; $arr[1]++; $arr[2]++;
var_dump($a1, $b1, $arr);

/*** Pass by Reference  ***/
function pass_by_ref(&$var)
{
	$var++;
}

$pa = 5;
pass_by_ref($pa);
echo $pa . '<br />';

function &return_ref()
{
	$a = 5;
	return $a;
}

pass_by_ref(return_ref());
echo return_ref();
echo '<br />';

/*** Returning References  ***/
class Foo
{
	public $value = 42;

	public function &getValue()
	{
		return $this->value;
	}
}

$obj = new Foo();
$myValue = &$obj->getValue();	// $myValue is a reference to $obj->value, which is 42.
$obj->value = 2;
echo 'MyValue: ' . $myValue . '<br />';

/***  Unsetting References  ***/
$x = 1;
$y =& $x;
var_dump($x, $y);
xdebug_debug_zval('x', 'y');

unset($x);
var_dump($x, $y);
xdebug_debug_zval('x', 'y');
