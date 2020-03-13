<?php
echo '<pre>';
$var = NULL;
$var = '';

echo gettype($var) . '<br />';

// functions about String
echo strlen('Hello world') . '<br />';

echo str_word_count('How are you?') . '<br />';

echo strpos('What is your name?', 'your') . '<br />';

echo strrev('Hello') . '<br />';

echo str_replace('world', 'Dolly', 'Hello world!') . '<br />';

// PHP integer
$a = 1;
$b = -1;
$c = 0123;
$d = 0x123;
var_dump($a, $b, $c, $d);
echo 'PHP int mas: ' . PHP_INT_MAX . '<br />';
echo 'PHP int size: ' . PHP_INT_SIZE . '<br />';
// convert functions
$e = decbin($b);
$f = hexdec($d);
$g = octdec($c);
echo $e . '<br />';
echo $f . '<br />';
echo $g . '<br />';

// check if the type of a variable is integer
var_dump(is_int($d), is_long($c), is_integer($b));

// PHP float
$a = 1.23;
$b = 2.4e3;
var_dump($a, $b);
// check if the type of a variable is float
var_dump(is_float($a), is_double($b));

// max float
echo 'PHP float max: ' . PHP_FLOAT_MAX . '<br />';

// finite
$x = 1.9e411;
var_dump($x);				// float(INF)
var_dump(is_float($x));		// true
var_dump(is_finite($x));	// false

// NaN
$x = acos(8);
$y = '';
var_dump($x);				// float(NAN)
var_dump(is_NaN($x), is_NaN($y));

// PHP array
$arr0 = array(1, 2, 3);

$arr1[] = 1;
$arr1[] = 2;
$arr1[] = 3;

$arr2 = [1, 2, 3];		// recommend

var_dump($arr0, $arr1, $arr2);

// PHP Object
class Car
{
	public $brand = 'BMW';
	
	public function showBrand()
	{
		return $this->brand;
	}
}

// create an object
$car = new Car();

// get properties
echo $car->brand . '<br />';

// call functions
echo $car->showBrand() . '<br />';

// NULL
$null_x;
@var_dump($null_x);

// PHP Resource
// e.g.: database Connection
