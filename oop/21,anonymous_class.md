# Anonymous classes

Support for anonymous classes was added in PHP 7. Anonymous classes are useful when simple, one-off objects need to be created.

```php
<?php
// pre PHP 7 code
class Logger
{
    public function log($msg)
    {   
        echo $msg;
    }   
}

//$util->setLogger(new Logger());

// PHP 7+ code
$util->setLogger(new class {
    public function log($msg)
    {
        echo $msg;
    }
});
```

They can pass arguments through to their constructors, extend other classes, implement interfaces, and use traits just like a normal class can: 

```php
<?php
class SomeClass {}
interface SomeInterface {}
trait SomeTrait {}

var_dump(new class(10) extends SomeClass implements SomeInterface {
    private $num;

    public function __construct($num)
    {   
        $this->num = $num;
    }

    use SomeTrait;
});
```

Nesting an anonymous class within another class does not give it access to any private or protected methods or properties of that outer class. In order to use the outer class' protected properties or methods, the anonymous class can extend the outer class. To use the private properties of the outer class in the anonymous class, they must be passed through its constructor: 

```php
<?php
// use the private properties of the outer class in the anonymous class
class Outer
{
    private $prop = 1;
    protected $prop2 = 2;

    protected function func1()
    {
        return 3;
    }
    
    public function func2()
    {
        return new class($this->prop) extends Outer {
            private $prop3;

            public function __construct($prop)
            {   
                $this->prop3 = $prop;
            }

            public function func3()
            {
                return $this->prop2 + $this->prop3 + $this->func1();
            }
        };
    }
}

echo (new Outer)->func2()->func3();		// 6
```

All objects created by the same anonymous class declaration are instances of that very class. 

```php
<?php
function anonymous_class()
{   
    return new class {};
}

if (get_class(anonymous_class()) === get_class(anonymous_class())) {
    echo 'Same class. <br />';
} else {
    echo 'Different class. <br />';
}
```

Note that anonymous classes are assigned a name by the engine, as demonstrated in the following example. This name has to be regarded an implementation detail, which should not be relied upon. 

`echo get_class(new class {});`