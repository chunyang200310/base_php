# Exceptions

PHP has an exception model similar to that of other programming languages. An exception can be thrown, and caught ("catched") within PHP. Code may be surrounded in a try block, to facilitate the catching of potential exceptions. Each try must have at least one corresponding catch or finally block. 

The thrown object must be an instance of the Exception class or a subclass of Exception. Trying to throw an object that is not will result in a PHP Fatal Error. 

***catch***

Multiple catch blocks can be used to catch different classes of exceptions. Normal execution (when no exception is thrown within the try block) will continue after that last catch block defined in sequence. Exceptions can be thrown (or re-thrown) within a catch block. 
When an exception is thrown, code following the statement will not be executed, and PHP will attempt to find the first matching catch block. If an exception is not caught, a PHP Fatal Error will be issued with an "Uncaught Exception ..." message, unless a handler has been defined with set_exception_handler(). 
In PHP 7.1 and later, a catch block may specify multiple exceptions using the pipe (|) character. This is useful for when different exceptions from different class hierarchies are handled the same. 

***finally***

In PHP 5.5 and later, a finally block may also be specified after or instead of catch blocks. Code within the finally block will always be executed after the try and catch blocks, regardless of whether an exception has been thrown, and before normal execution resumes. 
One notable interaction is between the finally block and a return statement. If a return statement is encountered inside either the try or the catch blocks, the finally block will still be executed. Moreover, the return statement is evaluated when encountered, but the result will be returned after the finally block is executed. Additionaly, if the finally block also contains a return statement, the value from the finally block is returned. 

```php
<?php
// Throwing an Exception
function inverse($x)
{
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    return 1/$x;
}

try {
    echo inverse(5) . '<br />';
    echo inverse(0) . '<br />';
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br />';
}

// Continue execute
echo 'Hello world. <br />';

// Exception handling with a finally block
function inverse2($x)
{
    if (!$x) {
        throw new Exception('Division by zero');
    }
    return 1 / $x;
}

try {
    echo inverse2(5) . '<br />';
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br />';
} finally {
    echo 'First finally. <br />';
}

try {
    echo inverse2(0) . '<br />';
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br />';
} finally {
    echo 'Second finally. <br />';
}

// Continue execution
echo 'Hallo die Welt. <br />';

// Interaction between the finally block and return
function test()
{
    try {
        throw new Exception('foo');
    } catch (Exception $e) {
        return 'catch';
    } finally {
        return 'finally';
    }
}

echo test() . '<br />';

// Nested Exception
class MyException extends Exception {}
class Test
{
    public function testing()
    {
        try {
            try {
                throw new MyException('foo!');
            } catch (MyException $e) {
                // rethrow it
                throw $e;
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}

$foo = new Test();
$foo->testing();
echo '<br />';

// Multi catch exception handling
class MyException1 extends Exception {}

class MyOtherException extends Exception {}

class Test1
{
    public function testing()
    {
        try {
            throw new MyException();
        } catch (MyException | MyOtherExctption $e) {
            var_dump(get_class($e));
        }
    }
}

$foo = new test1();
$foo->testing();
```

**Extending Exceptions**:

A User defined Exception class can be defined by extending the built-in Exception class. The members and properties below, show what is accessible within the child class that derives from the built-in Exception class. 

```php
<?php
class Exception extends Throwable
{
    protected $message = 'Unknown exception';   // exception message
    private   $string;                          // __toString cache
    protected $code = 0;                        // user defined exception code
    protected $file;                            // source filename of exception
    protected $line;                            // source line of exception
    private   $trace;                           // backtrace
    private   $previous;                        // previous exception if nested exception
    public function __construct($message = null, $code = 0, Exception $previous = null);
    final private function __clone();           // Inhibits cloning of exceptions.
    final public  function getMessage();        // message of exception
    final public  function getCode();           // code of exception
    final public  function getFile();           // source filename
    final public  function getLine();           // source line
    final public  function getTrace();          // an array of the backtrace()
    final public  function getPrevious();       // previous exception
    final public  function getTraceAsString();  // formatted string of trace
    // Overrideable
    public function __toString();               // formatted string for display
```

If a class extends the built-in Exception class and re-defines the constructor, it is highly recommended that it also call parent::__construct() to ensure all available data has been properly assigned. The __toString() method can be overridden to provide a custom output when the object is presented as a string. 