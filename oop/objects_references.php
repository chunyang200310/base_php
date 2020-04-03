<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// references and objects
class A
{
	public $foo = 1;
}

$a = new A();
$b = $a;
xdebug_debug_zval('a', 'b');
var_dump($a, $b);	// ($a) = ($b) = <id>

$b->foo = 2;
echo $a->foo . '<br />';
echo $b->foo . '<br />';
$a = 'a';
var_dump($b);
unset($a);
var_dump($b);


$c = new A();
$d = &$c;		// ($c, $d) = <id>
xdebug_debug_zval('c', 'd');
var_dump($c, $d);
$d->foo = 2;
echo $c->foo . '<br />';
echo $d->foo . '<br />';
$c = 'a';
var_dump($d);
unset($c);
var_dump($d);

$e = new A();

function foo($obj)
{
	// ($obj) = ($e) = <id>
	$obj->foo = 2;
}

foo($e);
echo $e->foo . '<br />';
