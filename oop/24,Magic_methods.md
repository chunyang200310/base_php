# Magic Methods

The function names `__ construct(), __ destruct(), __ call(), __ callStatic(), __ get(), __ set(), __ isset(), __ unset(), __ sleep(), __ wakeup(), __ toString(), __ invoke(), __ set_state(), __ clone() and __ debugInfo() `are magical in PHP classes. You cannot have functions with these names in any of your classes unless you want the magic functionality associated with them. 

All magic methods **MUST** be declared as **public**. 

PHP reserves all function names starting with __ as magical. It is recommended that you do not use function names with __ in PHP unless you want some documented magic functionality.

### __ sleep() and __ wakeup():

`public __sleep(void): array`

`__wakeup(void): void`

serialize() checks if your class has a function with the magic name __sleep(). If so, that function is executed prior to any serialization. It can clean up the object and is supposed to return an array with the names of all variables of that object that should be serialized. If the method doesn't return anything then NULL is serialized and E_NOTICE is issued. 

```php
<?php
/***  Sleep and wakeup  ***/
class Connection
{
    protected $link;
    private $dsn, $username, $password;

    public function __construct($dsn, $username, $password)
    {   
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }   

    private function connect()
    {   
        $this->link = new PDO($this->dsn, $this->username, $this->password);
    }   

    public function __sleep()
    {   
        return ['dsn', 'username', 'password'];
    }   

    public function __wakeup()
    {   
        $this->connect();
    }   
}
```

### __ toString():

`public __toString(void): string`

The __toString() method allows a class to decide how it will react when it is treated like a string. For example, what echo $obj; will print. This method must return a string, as otherwise a fatal E_RECOVERABLE_ERROR level error is emitted. 

It was not possible to throw an exception from within a __toString() method before PHP 7.4.0. Doing so will result in a fatal error. 

```php
<?php
/***  __toString()  ***/
class TestClass
{
    public $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }
    
    public function __toString()
    {
        return $this->foo;
    }
}   

$tc = new TestClass('hello');
echo $tc . '<br />';
```

### __ invoke():

`__ invoke([$...]): mixed`

The __invoke() method is called when a script tries to call an object as a function. 

```php
<?php
/***  __invoke()  ***/
class CallableClass
{
    public function __invoke($x)
    {   
        var_dump($x);
    }
}   

$cc = new CallableClass();
$cc(5);
var_dump(is_callable($cc));
```

### __ set_state():

`static __set_state(array $properties): object`

This static method is called for classes exported by var_export() since PHP 5.1.0. 
The only parameter of this method is an array containing exported properties in the form array('property' => value, ...). 

```php
<?php
/***  __set_state()  ***/
class A
{   
    public $var1;
    public $var2;

    public static function __set_state($an_array)
    {
        $obj = new A;
        $obj->var1 = $an_array['var1'];
        $obj->var2 = $an_array['var2'];
        return $obj;
    }
}   

$a = new A;
$a->var1 = 5;
$a->var2 = 'foo';

eval('$b = ' . var_export($a, true) . ';');

var_dump($b);
```

When exporting an object, var_export() does not check whether __ set_state() is implemented by the object's class, so re-importing such objects will fail, if __ set_state() is not implemented. Particularly, this affects some internal classes. It is the responsibility of the programmer to verify that only objects will be re-imported, whose class implements __set_state(). 

### __ debugInfo():

`__ debugInfo(void): array`

This method is called by var_dump() when dumping an object to get the properties that should be shown. If the method isn't defined on an object, then all public, protected and private properties will be shown. 

```php
<?php
/***  __debugInfo()  ***/
class C
{
    private $prop;

    public function __construct($val) 
    {
        $this->prop = $val;
    }
    
    public function __debugInfo()
    {
        return [
            'propSquared' => $this->prop ** 2,
        ];
    }
}   

var_dump(new C(42));
```

