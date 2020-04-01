# Constructors and destructors

### Constructor

`__construct ([ mixed $args = "" [, $... ]] ) : void`

PHP 5 allows developers to declare constructor methods for classes. Classes which have a constructor method call this method on each newly-created object, so it is suitable for any initialization that the object may need before it is used. 

Parent constructors are not called implicitly if the child class defines a constructor. In order to run a parent constructor, a call to parent::__construct() within the child constructor is required. If the child does not define a constructor then it may be inherited from the parent class just like a normal class method (if it was not declared as private). 

For backwards compatibility with PHP 3 and 4, if PHP cannot find a construct() function for a given class, it will search for the old-style constructor function, by the name of the class. Effectively, it means that the only case that would have compatibility issues is if the class had a method named __construct() which was used for different semantics. 

Old style constructors are DEPRECATED in PHP 7.0, and will be removed in a future version. You should always use __construct() in new code. 

Unlike with other methods, PHP will not generate an E_STRICT level error message when construct() is overridden with different parameters than the parent __construct() method has. 

```php
<?php
// new unified constructors: __construct();
class BaseClass
{
    public function __construct()
    {   
        echo 'In BaseClass constructor. <br />';
    }   
}

class SubClass extends BaseClass
{
    public function __construct()
    {   
        echo 'In SubClass constructor. <br />';
    }   
}

class OtherSubClass extends BaseClass
{
    // no __constructor, inherits BaseClass's constructor
}

$bc = new BaseClass();
$sc = new SubClass();
$osc = new OtherSubClass();
```

### Destructor

`__destruct ( void ) : void `

PHP 5 introduces a destructor concept similar to that of other object-oriented languages, such as C++. The destructor method will be called as soon as there are no other references to a particular object, or in any order during the shutdown sequence. 

```php
<?php
// explicitly destroy object
$obj1 = new stdClass();
$obj2 = new stdClass();
$obj3 = new stdClass();
var_dump($obj1, $obj2, $obj3);

// destroy 
unset($obj1);
$obj2 = null;
$obj3 = 'Tom';
var_dump($obj1, $obj2, $obj3);

// destructor
Class Destructor
{
    public function __construct()
    {
        echo 'In construct <br />';
    }

    public function __destruct()
    {
        echo 'Destroying ' . __CLASS__ . '<br />';
    }
}

$des = new Destructor();
```

Like constructors, parent destructors will not be called implicitly by the engine. In order to run a parent destructor, one would have to explicitly call parent::__destruct() in the destructor body. Also like constructors, a child class may inherit the parent's destructor if it does not implement one itself. 
The destructor will be called even if script execution is stopped using exit(). Calling exit() in a destructor will prevent the remaining shutdown routines from executing. 

Destructors called during the script shutdown have HTTP headers already sent. The working directory in the script shutdown phase can be different with some SAPIs (e.g. Apache). 