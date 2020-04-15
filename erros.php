<?php
declare(strict_types = 1);

error_reporting(E_ALL);

/*** change error display style ***/
// 1, change php.ini: 
// error_reporting=E_ALL & ~E_DEPRECATED & ~E_STRICT
// You must restart apache

// 2, use: error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT); 
// Only affect current script

// 3, use: ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_STRICT);

/* save error infos to specify file */
// 1, start error log in php.ini: log_errors=on
// 2, set log file size: log_errors_max_len=1024
// 3, set log path: error_log='/opt/lampp/errors'
// 4, display_errors=off

// custom error handler
set_error_handler('my_handler');

$err_str = '';

function my_handler($err_level, $err_mess, $err_file, $err_line)
{
	global $err_str;

	switch ($err_level) {
			case 2:
			$err_str .= 'Warning: ' . $err_mess . 'in ' . $err_file . ' at line ' . $err_line;
			break;
		case 8:
			$err_str .= 'Notice: ' . $err_mess . 'in ' . $err_file . ' at line ' . $err_line;
			break;
		case 8192:
			$err_str .= 'Notice: ' . $err_mess . 'in ' . $err_file . ' at line ' . $err_line;
			break;
	}
}
