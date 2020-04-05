# Namespaces

### overview

What are namespaces? In the broadest definition namespaces are a way of encapsulating items. This can be seen as an abstract concept in many places. For example, in any operating system directories serve to group related files, and act as a namespace for the files within them. As a concrete example, the file foo.txt can exist in both directory /home/greg and in /home/other, but two copies of foo.txt cannot co-exist in the same directory. In addition, to access the foo.txt file outside of the /home/greg directory, we must prepend the directory name to the file name using the directory separator to get /home/greg/foo.txt. This same principle extends to namespaces in the programming world. 

In the PHP world, namespaces are designed to solve two problems that authors of libraries and applications encounter when creating re-usable code elements such as classes or functions: 

1. Name collisions between code you create, and internal PHP classes/functions/constants or third-party classes/functions/constants.
2. Ability to alias (or shorten) Extra_Long_Names designed to alleviate the first problem, improving readability of source code. 

PHP Namespaces provide a way in which to group related classes, interfaces, functions and constants. Here is an example of namespace syntax in PHP: 

```php
<?php
declare(strict_types = 1); 

namespace my; 

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

class MyClass {}
function myFunction() {}
const MYCONST = 1;

$a = new MyClass;
$c = new \my\Myclass;
var_dump($a, $c);

$a = strlen('hi');
var_dump($a);

$d = namespace\MYCONST;
var_dump($d);

$e = __NAMESPACE__ . '\MYCONST';
var_dump($e);
echo constant($e);
```

### Defining namespaces

Although any valid PHP code can be contained within a namespace, only the following types of code are affected by namespaces: **classes** (including **abstracts** and **traits**), **interfaces**, **functions** and **constants**. 

Namespaces are declared using the namespace keyword. A file containing a namespace must declare the namespace `at the top` of the file before any other code - with one exception: the **declare** keyword. 

```php
<?php
namespace MyProject;

const CONNECT_OK = 1;
class Cnnection {/* ... */}
function connect() {/* ... */}
```

Fully qualified names (i.e. names starting with a backslash) are not allowed in namespace declarations, because such constructs are interpreted as relative namespace expressions. 

The only code construct allowed before a namespace declaration is the declare statement, for defining encoding of a source file. In addition, no non-PHP code may precede a namespace declaration, including extra whitespace.

In addition, unlike any other PHP construct, the same namespace may be defined in multiple files, allowing splitting up of a namespace's contents across the filesystem. 

### Declaring sub-namespaces

Much like directories and files, PHP namespaces also contain the ability to specify a hierarchy of namespace names. Thus, a namespace name can be defined with sub-levels:

```php
<?php
namespace MyProject\Sub\Level; // Declaring a single namespace with hierarchy 
const MY_CONST = 1;
class MyClass {}
function connect() {}
```

### Defining multiple namespaces in the same file

Multiple namespaces may also be declared in the same file. There are two allowed syntaxes. 

```php
<?php
namespace MyProject;

const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }

namespace AnotherProject;

const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
```

This syntax is not recommended for combining namespaces into a single file. Instead it is recommended to use the alternate bracketed syntax. 

```php
<?php
namespace MyProject {
    
const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
}

namespace AnotherProject {
    
const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
}
```

It is strongly discouraged as a coding practice to combine multiple namespaces into the same file. The primary use case is to combine multiple PHP scripts into the same file. 

To combine global non-namespaced code with namespaced code, only bracketed syntax is supported. Global code should be encased in a namespace statement with no namespace name as in: 

```php
<?php
namespace MyProject {
    
const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
}

namespace { // global code
session_start();
$a = MyProject\connect();
echo MyProject\Connection::start();
}
```

No PHP code may exist outside of the namespace brackets except for an opening declare statement. 

```php
<?php
declare(encoding='UTF-8');
namespace MyProject {
    
const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
}

namespace { // global code
session_start();
$a = MyProject\connect();
echo MyProject\Connection::start();
}
```

### Using namespaces: Basics

Before discussing the use of namespaces, it is important to understand how PHP knows which namespaced element your code is requesting. A simple analogy can be made between PHP namespaces and a filesystem. There are three ways to access a file in a file system: 
1. 
Relative file name like foo.txt. This resolves to currentdirectory/foo.txt where currentdirectory is the directory currently occupied. So if the current directory is /home/foo, the name resolves to /home/foo/foo.txt. 
2. 
Relative path name like subdirectory/foo.txt. This resolves to currentdirectory/subdirectory/foo.txt. 
3. Absolute path name like /main/foo.txt. This resolves to /main/foo.txt. 

The same principle can be applied to namespaced elements in PHP. For example, a class name can be referred to in three ways: 
1. 
Unqualified name, or an unprefixed class name like $a = new foo(); or foo::staticmethod();. If the current namespace is currentnamespace, this resolves to currentnamespace\foo. If the code is global, non-namespaced code, this resolves to foo. One caveat: unqualified names for functions and constants will resolve to global functions and constants if the namespaced function or constant is not defined. See Using namespaces: fallback to global function/constant for details. 
2. 
Qualified name, or a prefixed class name like $a = new subnamespace\foo(); or subnamespace\foo::staticmethod();. If the current namespace is currentnamespace, this resolves to currentnamespace\subnamespace\foo. If the code is global, non-namespaced code, this resolves to subnamespace\foo. 
3. Fully qualified name, or a prefixed name with global prefix operator like $a = new \currentnamespace\foo(); or \currentnamespace\foo::staticmethod();. This always resolves to the literal name specified in the code, currentnamespace\foo. 

Here is an example of the three kinds of syntax in actual code: 

file1.php

```php
 
<?php
namespace Foo\Bar\subnamespace;

const FOO = 1;
function foo() {}
class foo
{
    static function staticmethod() {}
}
```

file2.php

```php
<?php
namespace Foo\Bar;

include 'file1.php';

const FOO = 2;
function foo() {}
class foo
{
    static function staticmethod() {}
}

/* Unqualified name */
foo(); // resolves to function Foo\Bar\foo
foo::staticmethod(); // resolves to class Foo\Bar\foo, method staticmethod
echo FOO; // resolves to constant Foo\Bar\FOO

/* Qualified name */
subnamespace\foo(); // resolves to function Foo\Bar\subnamespace\foo
subnamespace\foo::staticmethod(); // resolves to class Foo\Bar\subnamespace\foo,
                                  // method staticmethod
echo subnamespace\FOO; // resolves to constant Foo\Bar\subnamespace\FOO

/* Fully qualified name */
\Foo\Bar\foo(); // resolves to function Foo\Bar\foo
\Foo\Bar\foo::staticmethod(); // resolves to class Foo\Bar\foo, method staticmethod
echo \Foo\Bar\FOO; // resolves to constant Foo\Bar\FOO
```

Note that to access any global class, function or constant, a fully qualified name can be used, such as \strlen() or \Exception or \INI_ALL. 

Accessing global classes, functions and constants from within a namespace :

```php
<?php
namespace Foo;

function strlen() {}
const INI_ALL = 3;
class Exception {}

$a = \strlen('hi'); // calls global function strlen
$b = \INI_ALL; // accesses global constant INI_ALL
$c = new \Exception('error'); // instantiates global class Exception
```

### Namespaces and dynamic language features

PHP's implementation of namespaces is influenced by its dynamic nature as a programming language. Thus, to convert code like the following example into namespaced code: 

Dynamically accessing elements:

example1.php

```php
<?php
class classname
{
    function __construct()
    {
        echo __METHOD__,"\n";
    }
}

function funcname()
{
    echo __FUNCTION__,"\n";
}
const constname = "global";
$a = 'classname';
$obj = new $a; // prints classname::__construct
$b = 'funcname';
$b(); // prints funcname
echo constant('constname'), "\n"; // prints global
```

One must use the fully qualified name (class name with namespace prefix). Note that because there is no difference between a qualified and a fully qualified Name inside a dynamic class name, function name, or constant name, the leading backslash is not necessary. 

Dynamically accessing namespaced elements :

```php
<?php
namespace namespacename;
class classname
{
    function __construct()
    {
        echo __METHOD__,"\n";
    }
}
function funcname()
{
    echo __FUNCTION__,"\n";
}
const constname = "namespaced";
/* note that if using double quotes, "\\namespacename\\classname" must be used */
$a = '\namespacename\classname';
$obj = new $a; // prints namespacename\classname::__construct
$a = 'namespacename\classname';
$obj = new $a; // also prints namespacename\classname::__construct
$b = 'namespacename\funcname';
$b(); // prints namespacename\funcname
$b = '\namespacename\funcname';
$b(); // also prints namespacename\funcname
echo constant('\namespacename\constname'), "\n"; // prints namespaced
echo constant('namespacename\constname'), "\n"; // also prints namespaced
```

### namespace keyword and __ NAMESPACE__ constant

PHP supports two ways of abstractly accessing elements within the current namespace, the `__ NAMESPACE__` magic constant, and the `namespace` keyword. 

The value of __ NAMESPACE__ is a string that contains the current namespace name. In global, un-namespaced code, it contains an empty string. 

```php
<?Php
/***  __NAMESPACE__ ***/
//echo '"', __NAMESPACE__, '"'; 	// ""
namespace MyProject;

echo '"', __NAMESPACE__, '"';

class MyClass {}

function get($className)
{
    $a = __NAMESPACE__ . '\\' . $className;
    return new $a; 
}

$obj = get('MyClass');
var_dump($obj);

```

The namespace keyword can be used to explicitly request an element from the current namespace or a sub-namespace. It is the namespace equivalent of the self operator for classes. 

```php
<?php
    // the namespace operator, inside a namespace
    namespace MyProject;

    use blah\blah as mine; // see "Using namespaces: Aliasing/Importing"

    blah\mine(); // calls function MyProject\blah\mine()
    namespace\blah\mine(); // calls function MyProject\blah\mine()

    namespace\func(); // calls function MyProject\func()
    namespace\sub\func(); // calls function MyProject\sub\func()
    namespace\cname::method(); // calls static method "method" of class MyProject\cname
    $a = new namespace\sub\cname(); // instantiates object of class MyProject\sub\cname
    $b = namespace\CONSTANT; // assigns value of constant MyProject\CONSTANT to $b

	// the namespace operator, in global code 
    namespace\func(); // calls function func()
    namespace\sub\func(); // calls function sub\func()
    namespace\cname::method(); // calls static method "method" of class cname
    $a = new namespace\sub\cname(); // instantiates object of class sub\cname
    $b = namespace\CONSTANT; // assigns value of constant CONSTANT to $b
```

