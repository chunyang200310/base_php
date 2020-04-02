# Static Keyword

**Static** keyword define static methods and properties. static can also be used to define static variables and for late static bindings. 

Declaring class properties or methods as static makes them accessible without needing an instantiation of the class. A property declared as static cannot be accessed with an instantiated class object (though a static method can). 

**static methods**: 

Because static methods are callable without an instance of the object created, the pseudo-variable $this is not available inside the method declared as static. 

```php
<?php
// static method example
class Foo 
{
    public function normalFunc()
    {   
        echo 'Normal function. <br />';
    }   

    public static function aStaticMethod()
    {   
        echo 'I am a static method. <br />';
    }   
}

Foo::aStaticMethod();
// Foo::normalFunc();   // Deprecated: Non-static method Foo::normalFunc() should not be called statically
$sm = 'Foo';
$sm::aStaticMethod();
```

**Static properties**: 

Static properties cannot be accessed through the object using the arrow operator ->. 

Like any other PHP static variable, static properties may only be initialized using a literal or constant before PHP 5.6; expressions are not allowed. In PHP 5.6 and later, the same rules apply as const expressions: some limited expressions are possible, provided they can be evaluated at compile time. 

```php
<?php
// static property example
class StaticPro
{
    public static $my_static = 'foo';

    public function staticValue()
    {   
        return self::$my_static;
    }   
}

class SubStatic extends StaticPro
{
    public function parentStatic()
    {   
        return parent::$my_static;
    }   
}

echo StaticPro::$my_static . '<br />';
$sp = new StaticPro();
echo $sp->staticValue() . '<br />';
echo $sp->my_static . '<br />'; // Undefined property: StaticPro::$my_static

echo $sp::$my_static . '<br />';

$cls = 'StaticPro';
echo $cls::$my_static . '<br />';

echo SubStatic::$my_static . '<br />';
$ss = new SubStatic();
echo $ss->parentStatic();
```

