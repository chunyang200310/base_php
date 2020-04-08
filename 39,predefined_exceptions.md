# Predefined Exceptions

Exception

ErrorException

Error

ArgumentCountError

ArithmeticError

AssertionError

DivisionByZeroError

CompileError

ParseError

TypeError

### Exception

Exception is the base class for all Exceptions in PHP 5, and the base class for all user exceptions in PHP 7. 
Before PHP 7, Exception did not implement the Throwable interface. 

**Class synopsis**

```php
Exception implements Throwable
{ 
    /* Properties */ 
    protected string $message ; 
    protected int $code ; 
    protected string $file ; 
    protected int $line ; 

    /* Methods */ 
    public __construct ([ string $message = "" [, int $code = 0 [, Throwable $previous = NULL ]]] ) 
    final public getMessage ( void ) : string 
    final public getPrevious ( void ) : Throwable 
    final public getCode ( void ) : mixed 
    final public getFile ( void ) : string 
    final public getLine ( void ) : int 
    final public getTrace ( void ) : array 
    final public getTraceAsString ( void ) : string 
    public __toString ( void ) : string 
    final private __clone ( void ) : void
}
```

### ErrorException

An Error Exception. 

**Class synapsis**

```php
ErrorException extends Exception
{ 
    /* Properties */ 
    protected int $severity ;
    
    /* Inherited properties */ 
    protected string $message ; 
    protected int $code ; 
    protected string $file ; 
    protected int $line ;
    
    /* Methods */ 
    public __construct ([ string $message = "" [, int $code = 0 [, int $severity = E_ERROR [, string $filename = __FILE__ [, int $lineno = __LINE__ [, Exception $previous = NULL ]]]]]] ) 
    final public getSeverity ( void ) : int
        
    /* Inherited methods */ 
    final public Exception::getMessage ( void ) : string 
    final public Exception::getPrevious ( void ) : Throwable 
    final public Exception::getCode ( void ) : mixed 
    final public Exception::getFile ( void ) : string 
    final public Exception::getLine ( void ) : int 
    final public Exception::getTrace ( void ) : array 
    final public Exception::getTraceAsString ( void ) : string 
    public Exception::__toString ( void ) : string 
    final private Exception::__clone ( void ) : void
}
```

### Error

Error is the base class for all internal PHP errors. 

**Class synopsis**

```php
Error implements Throwable
{ 
    /* Properties */ 
    protected string $message ; 
    protected int $code ; 
    protected string $file ; 
    protected int $line ;

    /* Methods */ 
    public __construct ([ string $message = "" [, int $code = 0 [, Throwable $previous = NULL ]]] ) 
    final public getMessage ( void ) : string 
    final public getPrevious ( void ) : Throwable 
    final public getCode ( void ) : mixed 
    final public getFile ( void ) : string 
    final public getLine ( void ) : int 
    final public getTrace ( void ) : array 
    final public getTraceAsString ( void ) : string 
    public __toString ( void ) : string 
    final private __clone ( void ) : void
}
```

### ArgumentCountError

ArgumentCountError is thrown when too few arguments are passed to a user-defined function or method. 

**Class synopsis**

```php
ArgumentCountError extends TypeError
{ 
    /* Inherited properties */ 
    protected string $message ; 
    protected int $code ; 
    protected string $file ; 
    protected int $line ;
    
    /* Inherited methods */ 
    final public Error::getMessage ( void ) : string 
    final public Error::getPrevious ( void ) : Throwable 
    final public Error::getCode ( void ) : mixed 
    final public Error::getFile ( void ) : string 
    final public Error::getLine ( void ) : int 
    final public Error::getTrace ( void ) : array 
    final public Error::getTraceAsString ( void ) : string 
    public Error::__toString ( void ) : string 
    final private Error::__clone ( void ) : void
}
```

### ArithmeticError

ArithmeticError is thrown when an error occurs while performing mathematical operations. In PHP 7.0, these errors include attempting to perform a bitshift by a negative amount, and any call to intdiv() that would result in a value outside the possible bounds of an integer. 

**Class synopsis**

```php
ArithmeticError extends Error
{ 
    /* Inherited properties */ 
    protected string $message ; 
    protected int $code ; 
    protected string $file ; 
    protected int $line ;
    
    /* Inherited methods */ 
    final public Error::getMessage ( void ) : string 
    final public Error::getPrevious ( void ) : Throwable 
    final public Error::getCode ( void ) : mixed 
    final public Error::getFile ( void ) : string 
    final public Error::getLine ( void ) : int 
    final public Error::getTrace ( void ) : array 
    final public Error::getTraceAsString ( void ) : string 
    public Error::__toString ( void ) : string 
    final private Error::__clone ( void ) : void
} 
```

### AssertionError

AssertionError is thrown when an assertion made via assert() fails. 

**Class synopsis**

```php
AssertionError extends Error { 
/* Inherited properties */ 
protected string $message ; 
protected int $code ; 
protected string $file ; 
protected int $line ; 
/* Inherited methods */ 
final public Error::getMessage ( void ) : string 
final public Error::getPrevious ( void ) : Throwable 
final public Error::getCode ( void ) : mixed 
final public Error::getFile ( void ) : string 
final public Error::getLine ( void ) : int 
final public Error::getTrace ( void ) : array 
final public Error::getTraceAsString ( void ) : string 
public Error::__toString ( void ) : string 
final private Error::__clone ( void ) : void }
```

### DivisionByZeroError

DivisionByZeroError is thrown when an attempt is made to divide a number by zero. 

**Class synopsis**

```php
DivisionByZeroError extends ArithmeticError { 
/* Inherited properties */ 
protected string $message ; 
protected int $code ; 
protected string $file ; 
protected int $line ; 
/* Inherited methods */ 
final public Error::getMessage ( void ) : string 
final public Error::getPrevious ( void ) : Throwable 
final public Error::getCode ( void ) : mixed 
final public Error::getFile ( void ) : string 
final public Error::getLine ( void ) : int 
final public Error::getTrace ( void ) : array 
final public Error::getTraceAsString ( void ) : string 
public Error::__toString ( void ) : string 
final private Error::__clone ( void ) : void } 
```

### CompileError

CompileError is thrown for some compilation errors, which formerly issued a fatal error. 

**Class synopsis**

```php
CompileError extends Error { 
/* Inherited properties */ 
protected string $message ; 
protected int $code ; 
protected string $file ; 
protected int $line ; 
/* Inherited methods */ 
final public Error::getMessage ( void ) : string 
final public Error::getPrevious ( void ) : Throwable 
final public Error::getCode ( void ) : mixed 
final public Error::getFile ( void ) : string 
final public Error::getLine ( void ) : int 
final public Error::getTrace ( void ) : array 
final public Error::getTraceAsString ( void ) : string 
public Error::__toString ( void ) : string 
final private Error::__clone ( void ) : void } 
```

### ParseError

ParseError is thrown when an error occurs while parsing PHP code, such as when eval() is called. 

ParseError extends CompileError as of PHP 7.3.0. Formerly, it extended Error. 

**Class synopsis**

```php
ParseError extends CompileError { 
/* Inherited properties */ 
protected string $message ; 
protected int $code ; 
protected string $file ; 
protected int $line ; 
/* Inherited methods */ 
final public Error::getMessage ( void ) : string 
final public Error::getPrevious ( void ) : Throwable 
final public Error::getCode ( void ) : mixed 
final public Error::getFile ( void ) : string 
final public Error::getLine ( void ) : int 
final public Error::getTrace ( void ) : array 
final public Error::getTraceAsString ( void ) : string 
public Error::__toString ( void ) : string 
final private Error::__clone ( void ) : void }
```

### TypeError

There are three scenarios where a TypeError may be thrown. The first is where the argument type being passed to a function does not match its corresponding declared parameter type. The second is where a value being returned from a function does not match the declared function return type. The third is where an invalid number of arguments are passed to a built-in PHP function (strict mode only). 

**Class synopsis**

```php
TypeError extends Error { 
/* Inherited properties */ 
protected string $message ; 
protected int $code ; 
protected string $file ; 
protected int $line ; 
/* Inherited methods */ 
final public Error::getMessage ( void ) : string 
final public Error::getPrevious ( void ) : Throwable 
final public Error::getCode ( void ) : mixed 
final public Error::getFile ( void ) : string 
final public Error::getLine ( void ) : int 
final public Error::getTrace ( void ) : array 
final public Error::getTraceAsString ( void ) : string 
public Error::__toString ( void ) : string 
final private Error::__clone ( void ) : void }
```

