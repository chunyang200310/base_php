<?php
/* Model.class.php
 * 基础模型类, 每个模型类都会用到的公共代码
 */

declare(strict_types = 1);

error_reporting(E_ALL);

class Model
{
	protected $dao;

	public function __construct()
	{
		require_once './DAOPDO.class.php';;

		$option = [ 
            'host'      =>  'localhost',
            'user'      =>  'root',
            'pass'      =>  'vxvd828q',
            'dbname'    =>  'php_7',
            'port'      =>  3306,
            'charset'   =>  'utf8'
		];

		$this->dao = DAOPDO::getsingleton($option);
	}
}
