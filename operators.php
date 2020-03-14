<?php
echo '<pre>';
// Arithmetic Operators: + - * / % **
$x = 1;
$y = 2;
$a = $x + $y;
$b = $x - $y;
$c = $x * $y;
$d = $x / $y;
$e = $x % $y;
$f = $x ** $y;
echo 'x + y = ' . $a. '<br />';
echo 'x - y = ' . $b. '<br />';
echo 'x * y = ' . $c. '<br />';
echo 'x / y = ' . $d. '<br />';
echo 'x % y = ' . $e. '<br />';
echo 'x ** y = ' . $f. '<br />';

// Assignment Operators
$x = 1;
$x += 2;
echo $x . '<br />';

// Comparison Operators
// <=>
$ss = mt_rand(0, 2);
$ss1 = mt_rand(0, 2);
$res = $ss <=> $ss1;
echo $ss . ' ** ' . $ss1 . ' ** ' . $res . '<br />';
var_dump($res);
echo '<br />';

// Increment / Decrement
$a = null;
$a++;
var_dump($a);	// int (1)
echo '<br />';

// Logical Operators
function leapYear($year)
{
	return ($year % 4 == 0 && $year %100 != 0) || $year % 400 == 0;
}

var_dump(leapYear(2020));
var_dump(leapYear(2021));

// String Operators
$num = 1;
$str = 'foo';
$mix = $num . $str;
$mix .= $str;
var_dump($mix);		// string(4) '1foofoo'

// Array Operators
$arr = [1, 2, 3];
$arr2 = ['a', 'b', 'c'];
$tog = $arr + $arr2;
$tog1 = $arr2 + $arr;
var_dump($tog, $tog1);

// Conditional Assignment Operators
$a = 1 > 1 ? 'hello' : 'world';
$b = null ?? 'good';
var_dump($a, $b);

// type Operators: instanceof
class MyClass
{
}

$a = new MyClass();
var_dump($a instanceof MyClass);
