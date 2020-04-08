# Predefined Variable

PHP provides a large number of predefined variables to all scripts. The variables represent everything from external variables to built-in environment variables, last error messages to last retrieved headers. 

### Superglobals

Superglobals — Superglobals are built-in variables that are always available in all scopes 

Several predefined variables in PHP are "superglobals", which means they are available in all scopes throughout a script. There is no need to do global $variable; to access them within functions or methods. 

These superglobal variables are: 

$GLOBALS 

$_SERVER 

$_GET 

$_POST 

$_FILES 

$_COOKIE 

$_SESSION 

$_REQUEST 

$_ENV 

By default, all of the superglobals are available but there are directives that affect this availability. For further information, refer to the documentation for variables_order. 

If the deprecated register_globals directive is set to on then the variables within will also be made available in the global scope of the script. For example, $_POST['foo'] would also exist as $foo. 

Superglobals cannot be used as variable variables inside functions or class methods. 

### $GLOBALS

$GLOBALS — References all variables available in global scope

An associative array containing references to all variables which are currently defined in the global scope of the script. The variable names are the keys of the array. 

```php
<?php
// $GLOBALS
function test()
{
    $foo = 'local variable';

    echo '$foo in global scope: ' . $GLOBALS['foo'] . '<br />';
    echo '$foo in current scope: ' . $foo . '<br />';
}

$foo = 'Example content';
test();
```

The above example will output something similar to: 

$foo in global scope: Example content
$foo in current scope: local variable

This is a 'superglobal', or automatic global, variable. This simply means that it is available in all scopes throughout a script. There is no need to do global $variable; to access it within functions or methods. 

Unlike all of the other superglobals, $GLOBALS has essentially always been available in PHP. 

### $_SERVER

$_SERVER is an array containing information such as headers, paths, and script locations. The entries in this array are created by the web server. There is no guarantee that every web server will provide any of these; servers may omit some, or provide others not listed here. That said, a large number of these variables are accounted for in the » CGI/1.1 specification, so you should be able to expect those. 

`var_dump($_SERVER)`

### $_GET

An associative array of variables passed to the current script via the URL parameters (aka. query string). Note that the array is not only populated for GET requests, but rather for all requests with a query string. 

`var_dump($_GET);`

The GET variables are passed through `urldecode(). `

### $_POST

An associative array of variables passed to the current script via the HTTP POST method when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request. 

`echo 'Hello ' . htmlspecialchars($_POST["name"]) . '!';`

### $_FILES

An associative array of items uploaded to the current script via the HTTP POST method. The structure of this array is outlined in the POST method uploads section. 

`var_dump($_FILES);`

### $_REQUEST

$_REQUEST — HTTP Request variables

An associative array that by default contains the contents of $_GET, $_POST and $_COOKIE. 

### $_SESSION

Session variables 

An associative array containing session variables available to the current script. See the Session functions documentation for more information on how this is used. 

### $_ENV

Environment variables

An associative array of variables passed to the current script via the environment method. 
These variables are imported into PHP's global namespace from the environment under which the PHP parser is running. Many are provided by the shell under which PHP is running and different systems are likely running different kinds of shells, a definitive list is impossible. Please see your shell's documentation for a list of defined environment variables. 
Other environment variables include the CGI variables, placed there regardless of whether PHP is running as a server module or CGI processor. 

### $_COOKIE

HTTP Cookies

An associative array of variables passed to the current script via HTTP Cookies. 

### $HTTP_RAW_POST_DATA

This feature was DEPRECATED in PHP 5.6.0, and REMOVED as of PHP 7.0.0. 

### $http_response_header

HTTP response headers

The $http_response_header array is similar to the get_headers() function. When using the HTTP wrapper, $http_response_header will be populated with the HTTP response headers. $http_response_header will be created in the local scope. 

```php
<?php
function get_contents() {
  file_get_contents("http://example.com");
  var_dump($http_response_header);
}

get_contents();
var_dump($http_response_header);
```

### $argc

 The number of arguments passed to script 

Contains the number of arguments passed to the current script when running from the command line. 

The script's filename is always passed as an argument to the script, therefore the minimum value of $argc is 1. 

This variable is not available when register_argc_argv is disabled. 

`var_dump($argc);`

### $argv

$argv — Array of arguments passed to script 

Contains an array of all the arguments passed to the script when running from the command line. 

The first argument $argv[0] is always the name that was used to run the script. 

This variable is not available when register_argc_argv is disabled. 

`var_dump($argv);`