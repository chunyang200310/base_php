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

// check if the type of a variable is integer
var_dump(is_int($d), is_long($c), is_integer($b));

// PHP float
$a = 1.23;
$b = 2.4e3;
var_dump($a, $b);
// check if the type of a variable is float
var_dump(is_float($a), is_double($b));

// max float
echo PHP_FLOAT_MAX;
