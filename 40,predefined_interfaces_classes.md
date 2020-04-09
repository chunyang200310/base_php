# Predefined Interfaces and Classes

Traversable

Iterator

IteratorAggregate

Throwable

ArrayAccess

Serializable

Closure

Generator

WeakReference

### Traversable

Interface to detect if a class is traversable using foreach. 
Abstract base interface that cannot be implemented alone. Instead it must be implemented by either IteratorAggregate or Iterator. 

Internal (built-in) classes that implement this interface can be used in a foreach construct and do not need to implement IteratorAggregate or Iterator. 

This is an internal engine interface which cannot be implemented in PHP scripts. Either IteratorAggregate or Iterator must be used instead. When implementing an interface which extends Traversable, make sure to list IteratorAggregate or Iterator before its name in the implements clause. 

**Interface synopsis**

`Traversable { } `

This interface has no methods, its only purpose is to be the base interface for all traversable classes. 

### The Iterator interface

Interface for external iterators or objects that can be iterated themselves internally. 

**Interface synopsis**

```php
Iterator extends Traversable { 
/* Methods */ 
abstract public current ( void ) : mixed 
abstract public key ( void ) : scalar 
abstract public next ( void ) : void 
abstract public rewind ( void ) : void 
abstract public valid ( void ) : bool }
```

### The IteratorAggregate interface

Interface to create an external Iterator. 

```php
IteratorAggregate extends Traversable { 
/* Methods */ 
abstract public getIterator ( void ) : Traversable }
```

Basic usage

```php
<?php
class myData implements IteratorAggregate
{
    public $property1 = "Public property one";
    public $property2 = "Public property two";
    public $property3 = "Public property three";
    
    public function __construct() {
        $this->property4 = "last property";
    }
    
    public function getIterator() {
        return new ArrayIterator($this);
    }
}

$obj = new myData;

foreach($obj as $key => $value) {
    var_dump($key, $value);
    echo "\n";
}
```

### Throwable

Throwable is the base interface for any object that can be thrown via a throw statement in PHP 7, including Error and Exception. 

PHP classes cannot implement the Throwable interface directly, and must instead extend Exception. 

```php
Throwable { 
/* Methods */ 
abstract public getMessage ( void ) : string 
abstract public getCode ( void ) : int 
abstract public getFile ( void ) : string 
abstract public getLine ( void ) : int 
abstract public getTrace ( void ) : array 
abstract public getTraceAsString ( void ) : string 
abstract public getPrevious ( void ) : Throwable 
abstract public __toString ( void ) : string } 
```

### The ArrayAccess interface

Interface to provide accessing objects as arrays. 

```php
ArrayAccess { 
/* Methods */ 
abstract public offsetExists ( mixed $offset ) : bool 
abstract public offsetGet ( mixed $offset ) : mixed 
abstract public offsetSet ( mixed $offset , mixed $value ) : void 
abstract public offsetUnset ( mixed $offset ) : void }
```

Basic usage:

```php
<?php
class Obj implements ArrayAccess
{
    private $container = array();
    
    public function __construct() {
        $this->container = array(
            "one"   => 1,
            "two"   => 2,
            "three" => 3,
        );
    }
    
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
    
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}

$obj = new Obj;
var_dump(isset($obj["two"]));
var_dump($obj["two"]);
unset($obj["two"]);
var_dump(isset($obj["two"]));
$obj["two"] = "A value";
var_dump($obj["two"]);
$obj[] = 'Append 1';
$obj[] = 'Append 2';
$obj[] = 'Append 3';
print_r($obj);
```

### The Serializable interface

Interface for customized serializing. 
Classes that implement this interface no longer support __ sleep() and __ wakeup(). The method serialize is called whenever an instance needs to be serialized. This does not invoke __ destruct() or have any other side effect unless programmed inside the method. When the data is unserialized the class is known and the appropriate unserialize() method is called as a constructor instead of calling __construct(). If you need to execute the standard constructor you may do so in the method. 

```php
Serializable { 
/* Methods */ 
abstract public serialize ( void ) : string 
abstract public unserialize ( string $serialized ) : void } 
```

### The Closure class

Class used to represent anonymous functions. 
Anonymous functions, implemented in PHP 5.3, yield objects of this type. This fact used to be considered an implementation detail, but it can now be relied upon. Starting with PHP 5.4, this class has methods that allow further control of the anonymous function after it has been created. 
Besides the methods listed here, this class also has an __invoke method. This is for consistency with other classes that implement calling magic, as this method is not used for calling the function. 

```php
Closure { 
/* Methods */ 
private __construct ( void ) 
public static bind ( Closure $closure , object $newthis [, mixed $newscope = "static" ] ) : Closure 
public bindTo ( object $newthis [, mixed $newscope = "static" ] ) : Closure 
public call ( object $newthis [, mixed $... ] ) : mixed 
public static fromCallable ( callable $callable ) : Closure } 
```

### The Generator class

Generator objects are returned from generators. 
Caution 
Generator objects cannot be instantiated via new. 

```php
Generator implements Iterator { 
/* Methods */ 
public current ( void ) : mixed 
public getReturn ( void ) : mixed 
public key ( void ) : mixed 
public next ( void ) : void 
public rewind ( void ) : void 
public send ( mixed $value ) : mixed 
public throw ( Throwable $exception ) : mixed 
public valid ( void ) : bool 
public __wakeup ( void ) : void }
```

### The WeakReference class

Weak references allow the programmer to retain a reference to an object which does not prevent the object from being destroyed. They are useful for implementing cache like structures. 

The class WeakReference is not to be confused with the class WeakRef of the Weakref extension. 

WeakReferences cannot be serialized. 

```php
WeakReference { 
/* Methods */ 
public __construct ( void ) 
public static create ( object $referent ) : WeakReference 
public get ( void ) : ?object }
```

example:

```php
<?php
$obj = new stdClass;
$weakref = WeakReference::create($obj);
var_dump($weakref->get());
unset($obj);
var_dump($weakref->get());
```

