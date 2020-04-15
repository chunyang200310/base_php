<?php
/*
 * framework config
 */
declare(strict_types = 1);

return [
	// database
	'host'				=>	'127.0.0.1',
	'user'				=>	'root',
	'pass'				=>	'mydb666',
	'dbname'			=>	'php_7',
	'port'				=>	'3306',
	'charset'			=>	'utf8',
	'table_prefix'		=>	'',

	// smarty config
	'left_delimiter'		=>	'<{',
	'right_delimiter'		=>	'}>',

	'default_module'		=>	'admin',
	'default_controller'	=>	'category',
	'default_action'		=>	'indexAction'
];
