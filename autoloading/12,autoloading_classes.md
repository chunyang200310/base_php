# Autoloading Classes

Many developers writing object-oriented applications create one PHP source file per class definition. One of the biggest annoyances is having to write a long list of needed includes at the beginning of each script (one for each class). 
In PHP 5, this is no longer necessary. The spl_autoload_register() function registers any number of autoloaders, enabling for classes and interfaces to be automatically loaded if they are currently not defined. By registering autoloaders, PHP is given a last chance to load the class or interface before it fails with an error. 

```php
<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
$obj  = new MyClass1();
$obj2 = new MyClass2();

// Autoloading with exception handling for 5.3.0+ 
<?php
spl_autoload_register(function ($name) {
    echo "Want to load $name.\n";
    throw new Exception("Unable to load $name.");
});
try {
    $obj = new NonLoadableClass();
} catch (Exception $e) {
    echo $e->getMessage(), "\n";
}
```

Four methods loading class files:

```php
<?php
// 1, use REQUIRE load Class Files
require_once './sub/Cat.class.php';
require_once './sub/Dog.class.php';
require_once './sub/Pig.class.php';

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();

// 2, use __autoload function
function __autoload($className)
{
    echo 'We need class named: ' . $className . '. <br />';
    require_once './sub/' . $className . '.class.php';
}

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();

// 3, use config file loading class file
require_once './common.php';
function __autoload($className)
{
    echo 'We need class named: ' . $className . '. <br />';
    global $classMap;
    require_once $classMap[$className];
}

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();

// 4, spl_autoload_register
require_once './common.php';

spl_autoload_register('class_autoload');

function class_autoload($className)
{
    echo 'We need class named: ' . $className . '. <br />';
    global $classMap;
    require_once $classMap[$className];
}

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();
```

