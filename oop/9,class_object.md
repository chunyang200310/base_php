# Classes and Objects

As of PHP 5, PHP includes a complete object model. Some of its features are: visibility, abstract and final classes and methods, additional magic methods, interfaces, cloning and typehinting. 

PHP treats objects in the same way as references or handles, meaning that each variable contains an object reference rather than a copy of the entire object. 

### 1, The Basics

**class**
Basic class definitions begin with the keyword ***class***, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class. 

The class name can be any valid label, provided it is not a PHP reserved word. A valid class name starts with a letter or underscore, followed by any number of letters, numbers, or underscores. 

A class may contain its own constants, variables (called "properties"), and functions (called "methods").

```php
<?php
    // Simple Class definition
    class SimpleClass
    {
        // property declaration
        public $var = 'a default value';

        // method declaration
        public function displayVar()
        {
            echo $this->var . '<br />';
        }
    }
```

The pseudo-variable $this is available when a method is called from within an object context. $this is a reference to the calling object (usually the object to which the method belongs, but possibly another object, if the method is called statically from the context of a secondary object). 

```php
<?php
    // Some examples of the $this pseudo-variable
    class A
    {
        public function foo()
        {   
            if (isset($this)) {
                echo '$this is defined (' . get_class($this) . ') <br />';
            } else {
                echo '$this is NOT defined. <br />';
            }
        }   
    }

    class B
    {
        public function bar()
        {   
            A::foo();
        }   
    }

    $a = new A();
    $a->foo();
    A::foo();

    $b = new B();
    $b->bar();
    B::bar();
```

**Object**: The instance of a class.

To create an instance of a class, the new keyword must be used. An object will always be created unless the object has a constructor defined that throws an exception on error. Classes should be defined before instantiation (and in some cases this is a requirement). 

If a string containing the name of a class is used with new, a new instance of that class will be created. If the class is in a namespace, its fully qualified name must be used when doing this. 

If there are no arguments to be passed to the class's constructor, parentheses after the class name may be omitted. 

```php
<?php
    // Creating an instance
    class CreateInstance
    {
        public $instance = null;

        public function getInstance()
        {   
            $this->instance = new self;
            return $this->instance;
            // return new self;
        }   
    }

    $ci = new CreateInstance();
    var_dump($ci);
    var_dump($ci->instance);
    var_dump($ci->getInstance());
    var_dump($ci->instance);

    $cls = 'createinstance';    // case insensitive
    $ci1 = new $cls;
    var_dump($ci1);
```

In the class context, it is possible to create a new object by new self and new parent. 

When assigning an already created instance of a class to a new variable, the new variable will access the same instance as the object that was assigned. This behaviour is the same when passing instances to a function. A copy of an already created object can be made by cloning it. 

```php
<?php
// Object Assignment
class ObjAssign
{
    public $var = 'a default value';

    public function displayVar()
    {
        echo $this->var;
    }
}

$instance = new ObjAssign();
$assigned = $instance;
$reference =& $instance;
$clone = clone $instance;
$instance->var = '$assigned will have this value';
$instance = null;

var_dump($instance, $reference, $clone, $assigned);
```

PHP 5.3.0 introduced a couple of new ways to create instances of an object: 

```php
<?php
// Creating new objects
class Test
{
    public static function getNew()
    {   
        return new static;
    }   
}

class Child extends Test {}

$obj1 = new Test();
$obj2 = new $obj1;
var_dump($obj1, $obj2);
var_dump($obj1 == $obj2);
var_dump($obj1 === $obj2);
$obj3 = Test::getNew();
var_dump($obj3);
$obj4 = Child::getNew();
var_dump($obj4);
var_dump($obj4 instanceof Child);	// true
var_dump($obj4 instanceof Test);	// true

//PHP 5.4.0 introduced the possibility to access a member of a newly created object in a single expression:
echo (new DateTime())->format('Y') . '<br />';  // 2020
```

**Properties and methods**:

Class properties and methods live in separate "namespaces", so it is possible to have a property and a method with the same name. Referring to both a property and a method has the same notation, and whether a property will be accessed or a method will be called, solely depends on the context, i.e. whether the usage is a variable access or a function call. 

```php
<?php
// Property access vs. method call
class PropertyMethod
{
    public $bar = 'property: bar';

    public function bar()
    {
        return 'method: bar()';
    }
}
// var_dump(PHP_EOL);
$pm = new PropertyMethod();
echo $pm->bar, PHP_EOL, $pm->bar(), PHP_EOL;
```

Calling an anonymous function which has been assigned to a property is not directly possible. Instead the property has to be assigned to a variable first, for instance. As of PHP 7.0.0 it is possible to call such a property directly by enclosing it in parentheses. 

```php
<?php
// Calling an anonymous function stored in a property
class FuncInProperty
{
    public $bar;

    public function __construct()
    {
        $this->bar = function() {
            return 42;
        };
    }
}

$fip = new FuncInProperty();
var_dump($fip);

// as of PHP 5.3.0
$func = $obj->bar;
// echo $func(), PHP_EOL;   // Fatal error: Uncaught Error: Function name must be a string

// alternatively, as of PHP 7.0.0
echo ($fip->bar)(), PHP_EOL;
```

**extends**
A class can inherit the methods and properties of another class by using the keyword extends in the class declaration. It is not possible to extend multiple classes; a class can only inherit from one base class. 
The inherited methods and properties can be overridden by redeclaring them with the same name defined in the parent class. However, if the parent class has defined a method as final, that method may not be overridden. It is possible to access the overridden methods or static properties by referencing them with parent::. 
When overriding methods, the parameter signature should remain the same or PHP will generate an E_STRICT level error. This does not apply to the constructor, which allows overriding with different parameters. 

```php
<?php
// Class Inheritance
class ExtendClass extends SimpleClass
{
    // redefine the parent method
    public function displayVar()
    {   
        echo 'Extending class. <br />';
        parent::displayVar();
    }
}

$ec = new ExtendClass();
$ec->displayVar();

// Class name resolution
echo ExtendClass::class . '<br />';
```

