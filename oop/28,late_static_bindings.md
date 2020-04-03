# Late Static Bindings

As of PHP 5.3.0, PHP implements a feature called late static bindings which can be used to reference the called class in a context of static inheritance. 

More precisely, late static bindings work by storing the class named in the last "non-forwarding call". In case of static method calls, this is the class explicitly named (usually the one on the left of the :: operator); in case of non static method calls, it is the class of the object. A "forwarding call" is a static one that is introduced by self::, parent::, static::, or, if going up in the class hierarchy, forward_static_call(). The function get_called_class() can be used to retrieve a string with the name of the called class and static:: introduces its scope. 
This feature was named "late static bindings" with an internal perspective in mind. "Late binding" comes from the fact that static:: will not be resolved using the class where the method is defined but it will rather be computed using runtime information. It was also called a "static binding" as it can be used for (but is not limited to) static method calls. 

Limitations of self::

Static references to the current class like self:: or __CLASS__ are resolved using the class in which the function belongs, as in where it was defined: 

```php
<?php
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

B::test();	// A


```

**Late Static Bindings' usage**:

Late static bindings tries to solve that limitation by introducing a keyword that references the class that was initially called at runtime. Basically, a keyword that would allow you to reference B from test() in the previous example. It was decided not to introduce a new keyword but rather use static that was already reserved. 

```php
<?php
// static:: simple usage
class A1
{
    public static function who()
    {   
        echo __CLASS__;
    }   

    public static function test()
    {   
        static::who();  // Here comes Late Static Bindings
    }   
}

class B1 extends A1
{
    public static function who()
    {   
        echo __CLASS__;
    }   
}

B1::test();		// B1
```

In non-static contexts, the called class will be the class of the object instance. Since $this-> will try to call private methods from the same scope, using static:: may give different results. Another difference is that static:: can only refer to static properties. 

```php
<?php
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
$c->test();
```

Late static bindings' resolution will stop at a fully resolved static call with no fallback. On the other hand, static calls using keywords like parent:: or self:: will forward the calling information. 

```php
<?php
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

C3::test();	// A3 C3 C3
```

