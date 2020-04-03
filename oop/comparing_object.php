<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// object comparison
function bool2str($bool)
{
	if ($bool === false) {
		return 'FALSE';
	} else {
		return 'TRUE';
	}
}

function compareObjects(&$o1, &$o2)
{
	echo 'o1 == o2 : ' . bool2str($o1 == $o2) . '<br />';
	echo 'o1 != o2 : ' . bool2str($o1 != $o2) . '<br />';
	echo 'o1 === o2 : ' . bool2str($o1 === $o2) . '<br />';
	echo 'o1 !== o2 : ' . bool2str($o1 !== $o2) . '<br />';
}

class Flag
{
	public $flag;

	public function __construct($flag = true)
	{
		$this->flag = $flag;
	}
}

class OtherFlag
{
	public $flag;

	public function __construct($flag = true)
	{
		$this->flag = $flag;
	}
}

$o = new Flag();
$p = new Flag();
$q = $o;
$r = new OtherFlag();

echo 'Two instances of the same class. <br />';
compareObjects($o, $p);

echo '<br /> Two references to the same instance. <br />';
compareObjects($o, $q);

echo '<br /> Instances of twor different classes. <br />';
compareObjects($o, $r);
