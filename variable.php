<?php
error_reporting(7);
echo '<body bgcolor="mintcream"> <pre>';

// case sensitive
$var = 'bob';
$Var = 'Bob';
echo "$var, $Var" . '<br />';

$a = 'Hello';
$b = $a;
$c = &$a;
echo "$a, $b, $c" . '<br />';

$a = 'world';
echo "$a, $b, $c";

// static variable
function foo()
{
    static $int = 0;
    static $int = 1 + 2;
    $int++;
    echo $int . '<br />';
}

foo();
