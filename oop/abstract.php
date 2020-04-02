<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Abstract class
abstract class AbstractClass
{
	// force extending class to define this method
	abstract protected function getValue();
	abstract protected function prefixValue($prefix);

	// common method
	public function printOut()
	{
		echo $this->getValue() . '<br />';
	}
}

class ConcreteClass1 extends AbstractClass
{
	protected function getValue()
	{
		return 'ConcreteClass1';
	}

	public function prefixValue($prefix)
	{
		return "{$prefix}ConcreteClass1";
	}
}

class ConcreteClass2 extends AbstractClass
{
	protected function getValue()
	{
		return 'ConcreteClass2';
	}

	public function prefixValue($prefix)
	{
		return "{$prefix}ConcreteClass2";
	}
}

$conc1 = new ConcreteClass1();
$conc1->printOut();
echo $conc1->prefixValue('FOO_') . '<br />';

$conc2 = new ConcreteClass2();
$conc2->printOut();
echo $conc2->prefixValue('FOO_') . '<br />';

abstract class PrefixProcess
{
	// abstract method only needs to define the required arguments
	abstract protected function prefixName($name);
}

class DoProcess extends PrefixProcess
{
	// child class may define optinal arguments not in parent's signature
	public function prefixName($name, $separator = '.')
	{
		if ($name == 'Pacman') {
			$prefix = 'Mr';
		} elseif ($name == 'Pacwoman') {
			$prefix = 'Mrs';
		} else {
			$prefix = '';
		}
		return "{$prefix}{$separator} {$name}";
	}
}

$dp = new DoProcess();
echo $dp->prefixName('Pacman') . '<br />';
echo $dp->prefixName('Pacwoman') . '<br />';
