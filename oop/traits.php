<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

trait common
{
	function getSum()
	{
		echo 'trait: getSum() <br />';
	}
}

class Dog
{
	public function getSum()
	{
		echo 'parent: getSum() <br />';
	}
}

class LittleDog extends Dog
{
	use common;

	/*
	public function getSum()
	{
		echo 'Son: getSum() <br />';
	}
	 */
}

$ld = new LittleDog();
$ld->getSum();
