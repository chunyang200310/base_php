<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// self:: usage
class A
{
	public static function who()
	{
		echo __CLASS__;
	}

	public static function test()
	{
		self::who();
	}
}

class B extends A
{
	public static function who()
	{
		echo __CLASS__;
	}
}

B::test();
echo '<br />';

// static:: simple usage
class A1
{
	public static function who()
	{
		echo __CLASS__;
	}

	public static function test()
	{
		static::who();	// Here comes Late Static Bindings
	}
}

class B1 extends A1
{
	public static function who()
	{
		echo __CLASS__;
	}
}

B1::test();
echo '<br />';

// static:: usage in a non-static context
class A2
{
	private function foo()
	{
		echo 'Success! <br />';
	}

	public function test()
	{
		$this->foo();
		static::foo();
	}
}

class B2 extends A2
{
	// foo() will be copied to B2, hence its scope will still be A2 and the call
	// be successful
}

class C2 extends A2
{
	private function foo()
	{
		// original method is replaced; the scope of the new one is C2
	}
}

$b = new B2();
$b->test();
$c = new C2();
// $c->test();

// Forwarding and non-forwarding calls
class A3
{
	public static function foo()
	{
		static::who();
	}

	public static function who()
	{
		echo __CLASS__ . '<br />';
	}
}

class B3 extends A3
{
	public static function test()
	{
		A3::foo();
		parent::foo();
		self::foo();
	}

	public static function who()
	{
		echo __CLASS__ . '<br />';
	}
}

class C3 extends B3
{
	public static function who()
	{
		echo __CLASS__ . '<br />';
	}
}

C3::test();
