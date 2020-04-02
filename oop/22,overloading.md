# Overloading

Overloading in PHP provides means to dynamically create properties and methods. These dynamic entities are processed via magic methods one can establish in a class for various action types. 

The overloading methods are invoked when interacting with properties or methods that have not been declared or are not visible in the current scope. The rest of this section will use the terms inaccessible properties and inaccessible methods to refer to this combination of declaration and visibility. 

All overloading methods must be defined as public. 

None of the arguments of these magic methods can be passed by reference. 

PHP's interpretation of overloading is different than most object oriented languages. Overloading traditionally provides the ability to have multiple methods with the same name but different quantities and types of arguments. 

**Property overloading**:

`public __set(string $name, mixed $value): void`

`public __get(string $name): mixed `

`public __isset(string $name): bool `

`public __unset(string $name): void`

__ set() is run when writing data to inaccessible (protected or private) or non-existing properties. 
__ get() is utilized for reading data from inaccessible (protected or private) or non-existing properties. 
__ isset() is triggered by calling isset() or empty() on inaccessible (protected or private) or non-existing properties. 
__ unset() is invoked when unset() is used on inaccessible (protected or private) or non-existing properties. 
The $name argument is the name of the property being interacted with. The __set() method's $value argument specifies the value the $name'ed property should be set to. 
Property overloading only works in object context. These magic methods will not be triggered in static context. Therefore these methods should not be declared static. As of PHP 5.3.0, a warning is issued if one of the magic overloading methods is declared static. 

```php
<?php
// overloading properties via the __get/set/isset/unset methods
class PropertyTest
{
    // Location for overloaded data
    private $data = []; 

    // Overloading not used on declared properties
    public $declared = 1;

    // Overloading only used on this when accessed outside the class
    private $hidden = 2;

    public function __set($name, $value)
    {   
        echo 'Setting $name to $value. <br />';
        $this->data[$name] = $value;
    }   

    public function __get($name)
    {   
        echo 'Getting the value of $name. <br />';
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name . 
            ' in ' . $trace[0]['file'] . 
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }   

    public function __isset($name)
    {   
        echo 'Is $name set? <br />';
        return isset($this->data[$name]);
    }   

    public function __unset($name)
    {   
        echo 'Unsetting $name. <br />';
        unset($this->data[$name]);
    }   

    // not a magic method
    public function getHidden()
    {   
        return $this->hidden;
    }   
}

$pt = new PropertyTest();

$pt->a = 1;
echo $pt->a . '<br />';

var_dump(isset($pt->a));
unset($pt->a);
var_dump(isset($pt->a));
echo '<br />';

echo $pt->declared . '<br />';

// Privates are visible inside the class, so __get() not used
echo 'getHidden(): ' . $pt->getHidden() . '<br />';

// Privates not visible outside of class, so __get() is used
echo $pt->hidden . '<br />';
```

**Method overloading**:

`public __call ( string $name , array $arguments ) : mixed `

`public static __callStatic ( string $name , array $arguments ) : mixed`

__ call() is triggered when invoking inaccessible methods in an object context. 
__ callStatic() is triggered when invoking inaccessible methods in a static context. 
The $name argument is the name of the method being called. The $arguments argument is an enumerated array containing the parameters passed to the $name'ed method. 

```php
<?php
/****** Overloading methods via the __call() and __callStatic() methods ******/
class MethodTest
{
    public function __call($name, $args)
    {
        // value of $name is case sensitive
        echo '__call is calling... <br />';
        echo "Calling object method '$name' " . implode(', ', $args) . '<br />';
    }
    
    public static function __callStatic($name, $args)
    {
        echo '__callStatic is calling... <br />';
        echo "Calling static method '$name' " . implode(', ', $args) . '<br />';
    }
}   

$mt = new MethodTest();
$mt->runTest('in object context');

MethodTest::runTest('in static context');
```

