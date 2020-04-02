# Scope Resolution Operator (::)

The Scope Resolution Operator (also called Paamayim Nekudotayim) or in simpler terms, the double colon, is a token that allows access to static, constant, and overridden properties or methods of a class. 

When referencing these items from outside the class definition, use the name of the class. 

```php
<?php
// :: from outside the class definition
class MyClass
{
    public const CONST_VALUE = 'A constant value';
}

$mc = 'MyClass';
echo $mc::CONST_VALUE . '<br />';
echo MyClass::CONST_VALUE . '<br />';
```

Three special keywords self, parent and static are used to access properties or methods from inside the class definition. 

```php
<?php
// :: from inside the class definition
class OtherClass extends MyClass
{   
    public static $my_static = 'static variable';
    
    public static function doubleColon()
    {   
        echo parent::CONST_VALUE . '<br />';
        echo self::$my_static . '<br />';
    }   
}   

$oc = 'OtherClass';
$oc::doubleColon();
OtherClass::doubleColon();
```

When an extending class overrides the parents definition of a method, PHP will not call the parent's method. It's up to the extended class on whether or not the parent's method is called. This also applies to Constructors and Destructors, Overloading, and Magic method definitions. 

```php
<?php
class A
{
    public function aFunc()
    {
        echo 'a::aFunc()';
    }
}

class B extends A
{
    // Override parent's definition
    public function aFunc()
    {
        echo 'b::aFunc()';
        
        // But still call the parent function
        parent::aFunc();
    }
}

$b = new B();
$b->aFunc();
```

