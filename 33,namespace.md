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

### Using namespaces: Aliasing/Importing

The ability to refer to an external fully qualified name with an alias, or importing, is an important feature of namespaces. This is similar to the ability of unix-based filesystems to create symbolic links to a file or to a directory. 
All versions of PHP that support namespaces support three kinds of aliasing or importing: `aliasing a class name, aliasing an interface name, and aliasing a namespace name`. PHP 5.6+ also allows aliasing or importing function and constant names. 
In PHP, aliasing is accomplished with the use operator. Here is an example showing all 5 kinds of importing: 

```php
<?php
namespace foo;
use My\Full\Classname as Another;

// this is the same as use My\Full\NSname as NSname
use My\Full\NSname;

// importing a global class
use ArrayObject;

// importing a function (PHP 5.6+)
use function My\Full\functionName;

// aliasing a function (PHP 5.6+)
use function My\Full\functionName as func;

// importing a constant (PHP 5.6+)
use const My\Full\CONSTANT;

$obj = new namespace\Another; // instantiates object of class foo\Another
$obj = new Another; // instantiates object of class My\Full\Classname
NSname\subns\func(); // calls function My\Full\NSname\subns\func
$a = new ArrayObject(array(1)); // instantiates object of class ArrayObject
// without the "use ArrayObject" we would instantiate an object of class foo\ArrayObject
func(); // calls function My\Full\functionName
echo CONSTANT; // echoes the value of My\Full\CONSTANT
```

Note that for namespaced names (fully qualified namespace names containing namespace separator, such as Foo\Bar as opposed to global names that do not, such as FooBar), the leading backslash is unnecessary and not recommended, as import names must be fully qualified, and are not processed relative to the current namespace. 

PHP additionally supports a convenience shortcut to place multiple use statements on the same line 

```php
<?php
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // instantiates object of class My\Full\Classname
NSname\subns\func(); // calls function My\Full\NSname\subns\func
```

Importing is performed at compile-time, and so does not affect dynamic class, function or constant names. 

```php
<?php
// Importing and dynamic names 
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // instantiates object of class My\Full\Classname
$a = 'Another';
$obj = new $a;      // instantiates object of class Another
```

In addition, importing only affects unqualified and qualified names. Fully qualified names are absolute, and unaffected by imports.

```php
<?php
// Importing and fully qualified names
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // instantiates object of class My\Full\Classname
$obj = new \Another; // instantiates object of class Another
$obj = new Another\thing; // instantiates object of class My\Full\Classname\thing
$obj = new \Another\thing; // instantiates object of class Another\thing
```

**Scoping rules for importing**:

The *use* keyword must be declared in the outermost scope of a file (the global scope) or inside namespace declarations. This is because the importing is done at compile time and not runtime, so it cannot be block scoped. The following example will show an illegal use of the use keyword: 

```php
<?php
namespace Languages;

function toGreenlandic()
{
    use Languages\Danish;	// Illegal importing rule
    // ...
}
```

**Group use declarations**:

From PHP 7.0 onwards, classes, functions and constants being imported from the same namespace can be grouped together in a single use statement. 

```php
<?php
// Pre PHP 7 code
use some\namespace\ClassA;
use some\namespace\ClassB;
use some\namespace\ClassC as C;

use function some\namespace\fn_a;
use function some\namespace\fn_b;
use function some\namespace\fn_c;

use const some\namespace\ConstA;
use const some\namespace\ConstB;
use const some\namespace\ConstC;

// PHP 7+ code
use some\namespace\{ClassA, ClassB, ClassC as C};
use function some\namespace\{fn_a, fn_b, fn_c};
use const some\namespace\{ConstA, ConstB, ConstC};
```

### Global space

Without any namespace definition, all class and function definitions are placed into the global space - as it was in PHP before namespaces were supported. Prefixing a name with \ will specify that the name is required from the global space even in the context of the namespace. 

```php
<?php
// Using global space specification
namespace A\B\C;

/* This function is A\B\C\fopen */
function fopen() { 
     /* ... */
     $f = \fopen(...); // call global fopen
     return $f;
} 
```

### Using namespaces: fallback to global function/constant

Inside a namespace, when PHP encounters an unqualified Name in a class name, function or constant context, it resolves these with different priorities. Class names always resolve to the current namespace name. Thus to access internal or non-namespaced user classes, one must refer to them with their fully qualified Name as in: 

```php
<?php
// Accessing global classes inside a namespace :
namespace A\B\C;

class Exception extends \Exception {}
$a = new Exception('hi'); // $a is an object of class A\B\C\Exception
$b = new \Exception('hi'); // $b is an object of class Exception

$c = new ArrayObject; // fatal error, class A\B\C\ArrayObject not found
```

For functions and constants, PHP will fall back to global functions or constants if a namespaced function or constant does not exist. 

```php
<?php
// global functions/constants fallback inside a namespace
<?php
namespace A\B\C;

const E_ERROR = 45;
function strlen($str)
{
    return \strlen($str) - 1;
}

echo E_ERROR, "\n"; // prints "45"
echo INI_ALL, "\n"; // prints "7" - falls back to global INI_ALL

echo strlen('hi'), "\n"; // prints "1"

if (is_array('hi')) { // prints "is not array"
    echo "is array\n";
} else {
    echo "is not array\n";
}
```

### Name resolution rules

For the purposes of these resolution rules, here are some important definitions: 

**Namespace name definitions**

*Unqualified name*

This is an identifier without a namespace separator(\\), such as Foo

*Qualified name*

This is an identifier with a namespace separator, such as Foo\Bar

*Fully qualified name*

This is an identifier with a namespace separator that begins with a namespace separator, such as \Foo\Bar. The namespace \Foo is also a fully qualified name. 

*Relative name*

This is an identifier starting with **namespace**, such as namespace\Foo\Bar. 

Names are resolved following these resolution rules: 

1. Fully qualified names always resolve to the name without leading namespace separator. For instance \A\B resolves to A\B. 
2. Relative names always resolve to the name with namespace replaced by the current namespace. If the name occurs in the global namespace, the namespace\ prefix is stripped. For example namespace\A inside namespace X\Y resolves to X\Y\A. The same name inside the global namespace resolves to A. 
3. For qualified names the first segment of the name is translated according to the current class/namespace import table. For example, if the namespace A\B\C is imported as C, the name C\D\E is translated to A\B\C\D\E. 
4. For qualified names, if no import rule applies, the current namespace is prepended to the name. For example, the name C\D\E inside namespace A\B, resolves to A\B\C\D\E. 
5. For unqualified names, the name is translated according to the current import table for the respective symbol type. This means that class-like names are translated according to the class/namespace import table, function names according to the function import table and constants according to the constant import table. For example, after use A\B\C; a usage such as new C() resolves to the name A\B\C(). Similarly, after use function A\B\fn; a usage such as fn() resolves to the name A\B\fn. 
6. For unqualified names, if no import rule applies and the name refers to a class-like symbol, the current namespace is prepended. For example new C() inside namespace A\B resolves to name A\B\C. 
7. For unqualified names, if no import rule applies and the name refers to a function or constant and the code is outside the global namespace, the name is resolved at runtime. Assuming the code is in namespace A\B, here is how a call to function foo() is resolved: 
   1. It looks for a function from the current namespace: A\B\foo(). 
   2. It tries to find and call the global function foo(). 

```php
<?php
// Name resolutions illustrated
namespace A;

use B\D, C\E as F;

// function calls
foo();      // first tries to call "foo" defined in namespace "A"
            // then calls global function "foo"
\foo();     // calls function "foo" defined in global scope
my\foo();   // calls function "foo" defined in namespace "A\my"
F();        // first tries to call "F" defined in namespace "A"
            // then calls global function "F"

// class references
new B();    // creates object of class "B" defined in namespace "A"
            // if not found, it tries to autoload class "A\B"
			// NOT like function, it will NOT autoload global scope class "B"
new D();    // using import rules, creates object of class "D" defined in namespace "B"
            // if not found, it tries to autoload class "B\D"
new F();    // using import rules, creates object of class "E" defined in namespace "C"
            // if not found, it tries to autoload class "C\E"
new \B();   // creates object of class "B" defined in global scope
            // if not found, it tries to autoload class "B"
new \D();   // creates object of class "D" defined in global scope
            // if not found, it tries to autoload class "D"
new \F();   // creates object of class "F" defined in global scope
            // if not found, it tries to autoload class "F"

// static methods/namespace functions from another namespace
B\foo();    // calls function "foo" from namespace "A\B"
B::foo();   // calls method "foo" of class "B" defined in namespace "A"
            // if class "A\B" not found, it tries to autoload class "A\B"
D::foo();   // using import rules, calls method "foo" of class "D" defined in namespace "B"
            // if class "B\D" not found, it tries to autoload class "B\D"
\B\foo();   // calls function "foo" from namespace "B"
\B::foo();  // calls method "foo" of class "B" from global scope
            // if class "B" not found, it tries to autoload class "B"

// static methods/namespace functions of current namespace
A\B::foo();   // calls method "foo" of class "B" from namespace "A\A"
              // if class "A\A\B" not found, it tries to autoload class "A\A\B"
\A\B::foo();  // calls method "foo" of class "B" from namespace "A"
              // if class "A\B" not found, it tries to autoload class "A\B"
```

### FAQ: things you need to know about namespaces

##### First, the common questions

**1, If I don't use namespaces, should I care about any of this?**

No. Namespaces do not affect any existing code in any way, or any as-yet-to-be-written code that does not contain namespaces. You can write this code if you wish: 

```php
<?php
    $a = new \stdClass;
```

This is functionally equivalent to: 

`$a = new stdClass;`

**2, How do I use internal or global classes in a namespace?**

add `\` at the beginning of the functions or classes or constants.

```php
<?php
namespace foo;

$a = new \stdClass;

function test(\ArrayObject $typehintexample = null) {}

$a = \DirectoryIterator::CURRENT_AS_FILEINFO;

// extending an internal or global class
class MyException extends \Exception {}
```

**3, How do I use namespaces classes, functions, or constants in their own namespace? **

```php
<?php
namespace foo;

class MyClass {}

// using a class from the current namespace as a type hint
function test(MyClass $typehintexample = null) {}

// another way to use a class from the current namespace as a type hint
function test(\foo\MyClass $typehintexample = null) {}

// extending a class from the current namespace
class Extended extends MyClass {}

// accessing a global function
$a = \globalfunc();

// accessing a global constant
$b = \INI_ALL;
```

**4, How does a name like \my\name or \name resolve? **

Names that begin with a \ always resolve to what they look like, so \my\name is in fact my\name, and \Exception is Exception. 

```php
<?php
namespace foo;

$a = new \my\name(); // instantiates "my\name" class
echo \strlen('hi'); // calls function "strlen"
$a = \INI_ALL; // $a is set to the value of constant "INI_ALL"
```

**5, How does a name like my\name resolve?**

Names that contain a backslash but do not begin with a backslash like my\name can be resolved in 2 different ways.

If there is an import statement that aliases another name to my, then the import alias is applied to the my in my\name.

Otherwise, the current namespace name is prepended to my\name. `current_namespace\my\name`

```php
<?php
namespace foo;

use blah\blah as foo;

$a = new my\name(); // instantiates "foo\my\name" class
foo\bar::name(); // calls static method "name" in class "blah\blah\bar"
my\bar(); // calls function "foo\my\bar"
$a = my\BAR; // sets $a to the value of constant "foo\my\BAR"
```

**6, How does an unqualified class name like name resolve?**

Class names that do not contain a backslash like name can be resolved in 2 different ways.

If there is an import statement that aliases another name to name, then the import alias is applied. 

Otherwise, the current namespace name is prepended to name. `current_namspace\name`

```php
<?php
namespace foo;

use blah\blah as foo;

$a = new name(); // instantiates "foo\name" class
foo::name(); // calls static method "name" in class "blah\blah"
```

**7, How does an unqualified function name or unqualified constant name like name resolve?**

Function or constant names that do not contain a backslash like name can be resolved in 2 different ways. 

First, the current namespace name is prepended to name. 

Finally, if the constant or function name does not exist in the current namespace, a global constant or function name is used if it exists. OR fatal error!

```php
<?php
// Unqualified function or constant names
namespace foo;

use blah\blah as foo;

const FOO = 1;
function my() {}
function foo() {}
function sort(&$a)
{
    \sort($a); // calls the global function "sort"
    $a = array_flip($a);
    return $a;
}

my(); // calls "foo\my"
$a = strlen('hi'); // calls global function "strlen" because "foo\strlen" does not exist
$arr = array(1,3,2);
$b = sort($arr); // calls function "foo\sort"
$c = foo(); // calls function "foo\foo" - import is not applied

$a = FOO; // sets $a to value of constant "foo\FOO" - import is not applied
$b = INI_ALL; // sets $b to value of global constant "INI_ALL"
```

##### Second, a few implementation details of the namespace implementations that are helpful to understand. 

**1, Import names cannot conflict with classes defined in the same file.**

The following script combinations are legal: 

file1.php

```php
<?php
    namespace my\stuff;
	
	class MyClass {}
```

another.php

```php
<?php
    namespace another;

	class thing {}
```

file2.php

```php
<?php
namespace my\stuff;

include 'file1.php';
include 'another.php';

use another\thing as MyClass;

$a = new MyClass; // instantiates class "thing" from namespace another
```

There is no name conflict, even though the class MyClass exists within the my\stuff namespace, because the MyClass definition is in a separate file. However, the next example causes a fatal error on name conflict because MyClass is defined in the same file as the use statement. 

```php
<?php
namespace my\stuff;

use another\thing as MyClass;

class MyClass {} // fatal error: MyClass conflicts with import statement

$a = new MyClass;
```

**2, Nested namespaces are not allowed.**

PHP does not allow nesting namespaces 

```php
<?php
    namespace my\stuff {
    	namespace nested {
        	class foo {}
   	 	}
	}
```

However, it is easy to simulate nested namespaces like so: 

```php
<?php
    namespace my\stuff\nested {
    class foo {}
	}
```

**3, Before PHP 5.6 neither functions nor constants can be imported via the use statement.**

Before PHP 5.6 the only elements that are affected by use statements are namespaces and class names. In order to shorten a long constant or function, import its containing namespace. 

```php
<?php
namespace mine;

use ultra\long\ns\name;

$a = name\CONSTANT;
name\func();
```

As of PHP 5.6 aliasing or importing function and constant names is allowed. 

**4, Dynamic namespace names (quoted identifiers) should escape backslash.**

It is very important to realize that because the backslash is used as an escape character within strings, it should always be doubled when used inside a string. Otherwise there is a risk of unintended consequences: 

```php
<?php
    // Dangers of using namespaced names inside a double-quoted string
    $a = "dangerous\name"; // \n is a newline inside double quoted strings!
    $obj = new $a;

    $a = 'not\at\all\dangerous'; // no problems here.
    $obj = new $a;
```

Inside a single-quoted string, the backslash escape sequence is much safer to use, but it is still recommended practice to escape backslashes in all strings as a best practice. 

**5, Undefined Constants referenced using any backslash die with fatal error**

Any undefined constant that is unqualified like FOO will produce a notice explaining that PHP assumed FOO was the value of the constant. Any constant, qualified or fully qualified, that contains a backslash will produce a fatal error if not found. 

```php
<?php
	// Undefined constants
    namespace bar;

    $a = FOO; // produces notice - undefined constants "FOO" assumed "FOO";
    $a = \FOO; // fatal error, undefined namespace constant FOO
    $a = Bar\FOO; // fatal error, undefined namespace constant bar\Bar\FOO
    $a = \Bar\FOO; // fatal error, undefined namespace constant Bar\FOO
```

**6, Cannot override special constants NULL, TRUE, FALSE, ZEND_THREAD_SAFE or ZEND_DEBUG_BUILD**

Any attempt to define a namespaced constant that is a special, built-in constant results in a fatal error 

```php
<?php
namespace bar;

const NULL = 0; // fatal error;
const true = 'stupid'; // also fatal error;    
```

