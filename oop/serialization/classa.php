<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

class A
{
	public $one = 1;

	public function showOne()
	{
		echo $this->one;
	}
}
