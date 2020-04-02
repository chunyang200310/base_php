<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// inheritance example
class Foo
{
	public function printItem(string $string)
	{
		echo 'Foo: ' . $string . PHP_EOL;
	}

	public function printPHP()
	{
		echo 'PHP is great.' . PHP_EOL;
	}
}

class Bar extends Foo
{
	public function printItem(string $string)
	{
		echo 'Bar: ' . $string . PHP_EOL;
	}
}

$foo = new Foo();
$bar = new Bar();
$foo->printItem('baz');
$foo->printPHP();
$bar->printItem('baz');
$bar->printPHP();
