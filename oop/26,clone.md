# Object Cloning

An object copy is created by using the clone keyword (which calls the object's __ clone() method if possible). An object's __clone() method cannot be called directly. 

`$copy_of_object = clone $object`

When an object is cloned, PHP will perform a shallow copy of all of the object's properties. Any properties that are references to other variables will remain references. 

`__clone(void): void`

Once the cloning is complete, if a __ clone() method is defined, then the newly created object's __clone() method will be called, to allow any necessary properties that need to be changed. 

```php
<?php
// cloning an object
class SubObject
{
    static $instances = 0;
    public $instance;

    public function __construct()
    {   
        $this->instance = ++self::$instances;
    }   
}

class MyCloneable
{
    public $object1;
    public $object2;

    function __clone()
    {   
        // Force a copy of this->object, otherwise it will point to same object
        $this->object1 = clone $this->object1;
    }   
}

$obj = new MyCloneable();

$obj->object1 = new SubObject();
$obj->object2 = new SubObject();

$obj2 = clone $obj;

echo 'Original object: <br />';
print_r($obj);
echo '<br />';

echo 'Cloned object: <br />';
print_r($obj2);
```

PHP 7.0.0 introduced the possibility to access a member of a freshly cloned object in a single expression: 

```php
<?php
// Access member of freshly cloned object
$dateTime = new DateTime();
echo (clone $dateTime)->format('Y');
```

